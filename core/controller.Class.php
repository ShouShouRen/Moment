<?php
session_start();
require_once($_SESSION["Config"]);
class Connect extends PDO{
    public function __construct($user,$passwd){
        parent::__construct("mysql:host=localhost;dbname=Moment",$user,$passwd,array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8"));
        $this->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $this->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
    }
}
class Controller{
    private $db;
    function __construct($user,$passwd){
        $this->db = new Connect($user,$passwd);
    }
    
    //check if user is logged in
    function checkUserStatus($id,$session){
        $user = $this->db -> prepare("SELECT id FROM users WHERE id=:id AND session=:session");
        $user->execute([
            ':id' => intval($id),
            ':session' => $session
        ]);
        $userInfo = $user -> fetch(PDO::FETCH_ASSOC);
        if(!isset($userInfo["id"])){
            return FALSE;
        }
        else{
            return TRUE;
        }

    }
    function generateCode($length){
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789!@#$%&*-+";
        $code = "";
        $clean = strlen($chars)-1;
        while(strlen($code) < $length){
            $code .= $chars[mt_rand(0,$clean)];
        }
        return $code;
    }
    //print data
    function printData(){
        $user = $this->db->prepare("SELECT * FROM users ORDER BY id");
        $user->execute();
        $content = '
                <table class="table">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Avatar</th>
                            <th scope="col">Email</th>
                            <th scope="col">移除</th>
                        </tr>
                    </thead>
                    <tbody>    
        ';
        while($userInfo = $user->fetch(PDO::FETCH_ASSOC)){
            $content .= '
                <tr class="user_tab">
                    <td>'.$userInfo["f_name"].'</td>
                    <td>'.$userInfo["l_name"].'</td>
                    <td><img style="max-width: 50px;" src="'.$userInfo["avatar"].'" alt="avatar"></td>
                    <td>'.$userInfo["email"].'</td>
                    
                    <td>
                        <form method="post" action="people.php">
                            <input type="hidden" name="user_remove" value="'.$userInfo["email"].'">
                            <input class="btn btn-danger" type="submit" name="submit" value="移除" >
                        </form>
                    </td>
                </tr>
            ';
        }
        $content .= '</tbody></table>';
        return $content;
    }
    //Init data
    function insertData($data){
        $checkUser = $this->db->prepare("SELECT * FROM users WHERE email=:email");
        $checkUser->execute(['email'=> $data["email"]]);
        $info = $checkUser->fetch(PDO::FETCH_ASSOC);
        if(!isset($info["id"])){
            // $session = $this->generateCode(20);
            // $inserUser = $this->db -> prepare("INSERT INTO users (f_name,l_name,avatar,email,password,session) VALUES(:f_name,:l_name,:avatar,:email,:password,:session)");
            // $inserUser->execute([
            //     ':f_name' => $data["givenName"],
            //     ':l_name' => $data["familyName"],
            //     ':avatar' => $data["avatar"],
            //     ':email' => $data["email"],
            //     ':password' => $this->generateCode(10),
            //     ':session' => $session
            // ]);
            // if($inserUser){
            //     setcookie("id",$this->db->lastInsertId(),time()+60*60*24*30,"/","moment.duacodie.com");
            //     setcookie("sss",$session,time()+60*60*24*30,"/","moment.duacodie.com");
            //     $_SESSION['id'] = $this->db->lastInsertId();
            //     header('Location: index.php');
            //     exit();
            // }
            // else{
            //     return "Error inserting user!";
            // }
            ?>
                <script language="javascript">
                    window.location.replace("<?= Error_PATH ?>"+"permission_error.html");
                </script>
            <?php
        }
        else{
            setcookie("id",$info["id"],time()+60*60*24*30,"/","moment.duacodie.com");
            setcookie("sss",$info["session"],time()+60*60*24*30,"/","moment.duacodie.com");
            $_SESSION['id'] = $info["id"];
            header('Location: index.php');
            exit();
        }
    }

    function deleteData($data){
        try{
            $checkUser = $this->db->prepare("SELECT email FROM users WHERE email=:email");
            $checkUser->execute(['email'=> $data]);
        }
        catch (PDOException $e) {
           return $e;
        }
        return true;
    }
}

?>