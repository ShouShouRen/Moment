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

    $code = mt_rand(0,1000000);
    $_SESSION['code'] = $code;
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.js"></script>
<script>
// $.ajax({
//     method: "POST",
//     url: "index.php",
//     data: { code: <?php #echo $code; ?> } // 使用 PHP 輸出動態生成的 code 值
// }).done(function(response){
//     window.location.href = "index.php?token=" + response;
// });
$(function(){
  var form = $('<form action="index.php?token=<?=$out?>" method="POST">' +
    '<input type="hidden" name="code" value="<?=$_SESSION['code']?>">' +
    '</form>');
  $('body').append(form);
  form.submit();
});
</script>