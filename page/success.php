<?php
session_start();
require("../FileRoute.php");
if(!isset($_SESSION["Base"])){
    header('location:'.Web_Root_Path."index.php");
    die();
}
require_once($_SESSION["Base"]);
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
$url = $URLS;
Base(function($user,$passwd,$data=null) use ($url){
    if(!isset($data)) die("Error");
    $db = new Connect($user,$passwd);
    $sql = 'SELECT `Guests`.`token`, `orders`.`desk`,`orders`.`product_name`,`orders`.`product_count`,`orders`.`totalPrice` FROM `Guests` NATURAL JOIN `orders` WHERE `token`=:token';
    $stmt = $db->prepare($sql);
    $stmt->execute([":token"=>$data]);
    $callBack = $stmt -> fetchAll(PDO::FETCH_ASSOC);
    
    $url["order"] = $db->convert($callBack);
    if(!isset($url["order"])) {
        header("Location: /index.php");
        die();
    }
    $loader = new FilesystemLoader(ROOT_PATH.'/templates');
    $twig = new Environment($loader);
    if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)){
        echo $twig->render('success.twig',$url);
    }
});
?>