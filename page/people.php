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
    $controller = new Controller($user,$passwd);
    if(isset($_POST["user_remove"])&&($_SESSION['userData']['email'] != $_POST["user_remove"])){
        $result = $controller->deleteData($_POST["user_remove"]);
        if(!$result){
            die($result);
        }
    }
    if(isset($_POST["user_add"])){
        $result = $controller->insertData($_POST["user_add"]);
    }
    $url['user_table'] = $controller->printData(); 

    $loader = new FilesystemLoader(ROOT_PATH.'/templates');
    $twig = new Environment($loader);
    if (basename($_SERVER["REQUEST_URI"]) == basename(__FILE__)){
        $url["people_active"] = "active";
        echo $twig->render('people.twig',$url);
    }
});
?>