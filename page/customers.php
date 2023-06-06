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
Base(function($user,$passwd) use ($url){
    $db = new Connect($user,$passwd);
    $sql = "SELECT *  FROM `Guests`";
    $stmt = $db->prepare($sql);
    $ret = $stmt->execute();
    $loader = new FilesystemLoader(ROOT_PATH.'/templates');
    $twig = new Environment($loader);
    if (basename($_SERVER["REQUEST_URI"]) == basename(__FILE__)){
        $url["customers_active"] = "active";
        echo $twig->render('customers.twig',$url);
    }
});
?>