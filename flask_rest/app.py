from flask import Flask, request, abort, jsonify,send_file,make_response
from flask_restful import Resource, Api,reqparse
import logging,os
app = Flask(__name__)
api = Api(app)

class DB:
    def __init__(self):
        import pymysql
        self.con = pymysql.connect(host='127.0.0.1',port=3306,user='derrick',passwd='Ed0911872587-',db='Moment',charset = 'utf8')
    @property
    def connect(self):
        return self.con
    def call_back(self,result):
        import json
        ret = []
        content = {}
        for i in result:
            content = {'id':i['id'],'title':i['title'],'price':i['price'],'description':i['description'],'category':i['category'],'image':i['image']}
            ret.append(content)
            content = {}
        resp = make_response(json.dumps(ret, ensure_ascii=False,default=str))
        resp.headers['Content-Type'] = 'application/json'
        return resp
    def call_one_back(self,result,search_data):
        import json
        ret = []
        content = {}
        for i in result:
            content = {'MSG':i[search_data]}
        resp = make_response(json.dumps(content, ensure_ascii=False,default=str))
        resp.headers['Content-Type'] = 'application/json'
        return resp
class print_stuff(Resource):
    def __init__(self):
        import pymysql
        self.reqparse = reqparse.RequestParser()
        self.reqparse.add_argument('id', type = int, default=None,location=['headers', 'args'])
        self.reqparse.add_argument('title', type = str, default=None,location=['headers', 'args'])
        self.reqparse.add_argument('search', type = str, default=None,location=['headers', 'args'])
        self.db = DB()
        self.cursor = self.db.connect.cursor(cursor=pymysql.cursors.DictCursor)
        super(print_stuff, self).__init__()
    def get(self):
        args = self.reqparse.parse_args()
        if(args['search'] is None):
            if(args['id'] is not None and args['title'] is not None ):
                self.cursor.execute(f'SELECT * FROM Menu WHERE `title` = "{args["title"]}" and `id` = {args["id"]};')
                return self.db.call_back(self.cursor.fetchall())
            elif(args['id'] is not None and args['title'] is None):
                self.cursor.execute(f'SELECT * FROM Menu WHERE `id` = {args["id"]};')
                return self.db.call_back(self.cursor.fetchall())
            elif(args['title'] is not None and args['id'] is None):
                self.cursor.execute(f'SELECT * FROM Menu WHERE `title` = "{args["title"]}";')
                return self.db.call_back(self.cursor.fetchall())
        else:
            if(args['id'] is not None and args['title'] is not None ):
                self.cursor.execute(f'SELECT `{args["search"]}` FROM Menu WHERE `title` = "{args["title"]}" and `id` = {args["id"]};')
                return self.db.call_one_back(self.cursor.fetchall(),args['search'])
            elif(args['id'] is not None and args['title'] is None):
                self.cursor.execute(f'SELECT `{args["search"]}` FROM Menu WHERE `id` = {args["id"]};')
                return self.db.call_one_back(self.cursor.fetchall(),args['search'])
            elif(args['title'] is not None and args['id'] is None):
                self.cursor.execute(f'SELECT `{args["search"]}` FROM Menu WHERE `title` = "{args["title"]}";')
                return self.db.call_one_back(self.cursor.fetchall(),args['search'])
        return {
            'MSG':"NULL"
        } 
    
class Data_full(Resource):
    def get(self):
        import pymysql
        db = DB()
        cursor = db.connect.cursor(cursor=pymysql.cursors.DictCursor)
        cursor.execute("SELECT * FROM Menu;")
        result = cursor.fetchall()
        return db.call_back(result)
    
# class GetFile(Resource):
#     def get(self,filename):
#         Base = os.path.dirname(__file__)
#         file = f"{Base}/API"
#         return send_file(f"{file}/{filename}.json")
    
# api.add_resource(GetFile,'/file/<string:filename>')
api.add_resource(print_stuff,'/menu/get')
api.add_resource(Data_full,'/menu')
if __name__ != '__main__':
    # 如果不是直接运行，则将日志输出到 gunicorn 中
    gunicorn_logger = logging.getLogger('gunicorn.error')
    app.logger.handlers = gunicorn_logger.handlers
    app.logger.setLevel(gunicorn_logger.level)
if __name__ == '__main__':
    app.run()