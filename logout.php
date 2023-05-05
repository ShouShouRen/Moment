<?php
setcookie('id','',time()-60*60*24*30,'/',"moment.duacodie.com");
setcookie('sss','',time()-60*60*24*30,'/',"moment.duacodie.com");
session_start();
if (isset($_SESSION['ucode'])){
    unset($_SESSION['ucode']);
    session_destroy();
}
header("Location: index.php");
die();
?>