<?php
    require_once("../FileRoute.php");
    require_once(Core_PATH."controller.Class.php");
    require_once("../config.php");
    session_start();
    $db = new Connect($user,$passwd);
    
    $today = date("Y-m-d H:i:s"); 
    $desk = "A1";

    $sql = "SELECT token,base64 FROM Guests WHERE token = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$data]);
    $count = $stmt->rowCount();
    if($count==0){
        $sql = "ALTER TABLE `Guests` AUTO_INCREMENT = 0;";
        $stmt = $db->prepare($sql);
        $stmt->execute(); 
    }
    
    $stmt = $db->prepare("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE   (TABLE_NAME = 'Guests');");
    $stmt->execute();
    $count = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $numberID = $count['AUTO_INCREMENT'] + 1 ;

    $sec = $today." ".$numberID." ".$desk;
    $send = base64_encode($sec);
    $out = password_hash($send,PASSWORD_DEFAULT);
    

    $sql = "INSERT INTO Guests(token,base64) VALUES (?,?)";
    $stmt = $db->prepare($sql);
    $stmt->execute([$out,$send]);

    $code = mt_rand(0,1000000);
    $_SESSION['code'] = $code;
    header("Location: index.php?token=$out");
?>
