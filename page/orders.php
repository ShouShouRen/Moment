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
Base(function($user,$passwd,$data=null,$insert=true) use ($url){
    if($insert){
        $loader = new FilesystemLoader(ROOT_PATH.'/templates');
        $twig = new Environment($loader);
        if (basename($_SERVER["REQUEST_URI"]) == basename(__FILE__)){
            $url["orders_active"] = "active";
            echo $twig->render('orders.twig',$url);
        }
    }
    else{
        if(!isset($data)) die("NO Data");
        $db = new Connect($user,$passwd);
        $sql = "SELECT * FROM `Guests` WHERE `token`=:token;";
        $ret = $db->prepare($sql);
        $ret->execute([
            ':token' => $data
        ]);
        $callBack = $ret -> fetch(PDO::FETCH_ASSOC);
        if(isset($callBack["token"])){
            if(isset($_POST['product_name'])) { 
                foreach ($_POST['product_name'] as $index => $productName) {
                    echo $index."  ".$productName."<br>";
                }
            }
            else{
                die('err');
            }
        }
    }
});
?>