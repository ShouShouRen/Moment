<?php
require_once('../FileRoute.php');
require_once(Base);
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
$url = $URLS;
Base(function() use ($url){
    $loader = new FilesystemLoader(ROOT_PATH.'/templates');
    $twig = new Environment($loader);
    if (basename($_SERVER["REQUEST_URI"]) == basename(__FILE__)){
        $url["orders_active"] = "active";
        echo $twig->render('orders.twig',$url);
    }
});
?>