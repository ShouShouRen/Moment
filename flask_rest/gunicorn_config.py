import multiprocessing

#workers = multiprocessing.cpu_count() * 2 + 1
workers = 1
bind = 'unix:flask_rest.sock'
#bind = '127.0.0.1:3000'
umask = 0o007
reload = True
#logging
accesslog = '/var/log/apache2/Moment/api-access.log'
errorlog = '/var/log/apache2/Moment/api-error.log'