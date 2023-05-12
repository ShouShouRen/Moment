<?php
    require_once("../FileRoute.php");
    require_once(Core_PATH."controller.Class.php");
    require_once("../config.php");
    $db = new Connect($user,$passwd);
    
    $today = date("Y-m-d H:i:s"); 
    $desk = "A1";
    
    $stmt = $db->prepare('SELECT * FROM Guests');
    $stmt->execute();
    $count=$stmt->rowCount();
    
    $numberID = $count + 1 ;

    $sec = $today." ".$numberID." ".$desk;
    $send = base64_encode($sec);
    $out = password_hash($send,PASSWORD_DEFAULT);
    

    $sql = "INSERT INTO Guests(token) VALUES (?)";
    $stmt = $db->prepare($sql);
    $stmt->execute([$out]);

    
    header("Location: get.php?token=$out&sec=$send");
?>