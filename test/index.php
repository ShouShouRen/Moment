<?php
    require_once("../FileRoute.php");
    require_once(Core_PATH."controller.Class.php");
    require_once("../config.php");
    $db = new Connect($user,$passwd);
    
    if(isset($_GET["token"])){
        $data = $_GET["token"];

        
        $sql = "SELECT token,base64 FROM Guests WHERE token = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$data]);
        $count = $stmt->rowCount();
        if($count==0){
            die('error');
        }
        
        $sec = $stmt->fetch(PDO::FETCH_ASSOC);


        if(password_verify($sec["base64"],$data)){
            $decoder_code = base64_decode($sec["base64"]);
            $arr = explode(" ",$decoder_code);

            $time = $arr[1];
            echo $time . "<br>";
            $end = date("H:$time+15:s");
            // echo $end;
            // if($time<=$end){
            //     echo('aaa');
            // }else{
            //     echo("bbb");
            // }
            
            // echo date("H:i:s",strtotime("+5 min"));
        }
        else{
            echo "error1";
        }
    }
    else{
        echo "NONE";
        // header("Location: index.php");
    }
?>