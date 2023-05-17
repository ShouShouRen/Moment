<?php
session_start();
require_once($_SESSION["Base"]);
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
$url = $URLS;
Base(function($user,$passwd) use ($url){
    if(isset($_POST["Desk"])){
        $db = new Connect($user,$passwd);
        $today = date("Y-m-d H:i:s"); 
        $desk = $_POST["Desk"];
        $sql = "SELECT * FROM `Guests`";
        $stmt = $db->prepare($sql);
        $stmt->execute();
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
        $code =  urlencode("https://moment.duacodie.com/Merge/test/index.php?token=$out");
        $url["code"] = "https://barcodeapi.org/api/qr/$code";
        $url["QRcode"] = "true";
    }
    $loader = new FilesystemLoader(ROOT_PATH.'/templates');
    $twig = new Environment($loader);
    if (basename($_SERVER["REQUEST_URI"]) == basename(__FILE__)){
        $url["qr_active"] = "active";
        echo $twig->render('qr.twig',$url);
    }
});
?>