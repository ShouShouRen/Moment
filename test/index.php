<?php
    require_once("../FileRoute.php");
    require_once(Core_PATH."controller.Class.php");
    require_once("../config.php");
    session_start();
    $db = new Connect($user,$passwd);
    
    if(isset($_GET["token"])){
        // $hide = $_POST["code"];
        // if($hide != $_SESSION['code']){
        //     die("error3");
        // }
        $_SESSION['code'] += 1;
        $data = $_GET["token"];
        $sql = "SELECT token,base64 FROM Guests WHERE token = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$data]);
        $count = $stmt->rowCount();
        if($count==0){
            $sql = "ALTER TABLE `Guests` AUTO_INCREMENT = 0;";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            header("Location: index.php");
            die();
        }
        $sec = $stmt->fetch(PDO::FETCH_ASSOC);
        if(password_verify($sec["base64"],$data)){
            $decoder_code = base64_decode($sec["base64"]);
            $arr = explode(" ",$decoder_code);
            $_SESSION['time'] = $arr[1];
            $_SESSION['new_time'] = date('H:i:s', strtotime($_SESSION['time'].'+1 minutes')); // 加上 15 分鐘
            $now = date("H:i:s");
            if(($now > $_SESSION['new_time']) OR ($now < $_SESSION['time'])){
                $sql = "DELETE FROM `Guests` WHERE token = ?";
                $stmt = $db->prepare($sql);
                $stmt->execute([$data]);
                die("error2");
            }
            if(isset($_SESSION['time']) && isset($_SESSION['new_time'])){
                echo $now."<br><br>";
                echo $_SESSION['time']."<br>";
                echo $_SESSION['new_time']."<br>"; // 顯示加上 15 分鐘後的時間，格式為 時:分:秒
            }
            else{
                echo $now."<br><br>";
            }
            
        }
        else{
            $sql = "DELETE FROM `Guests` WHERE token = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$data]);
            die("error1");
        }
    }
    else{
        die ("NONE");
    }
?>
