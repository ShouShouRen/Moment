<?php
    require_once("../FileRoute.php");
    require_once(Core_PATH."controller.Class.php");
    require_once("../config.php");
    session_start();
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
    

    $sql = "INSERT INTO Guests(token,base64) VALUES (?,?)";
    $stmt = $db->prepare($sql);
    $stmt->execute([$out,$send]);

    
    header("Location: index.php?token=$out");
    $code = mt_rand(0,1000000);
    $_SESSION['code'] = $code;

?>
<script src="../resource/jquery.min.js"></script>
<script>
    $.ajax({
        method: "POST",
        url: "index.php",
        data: {<?= $code ?>}
    }).done((e)=>{
        console.log(e);
    })
</script>