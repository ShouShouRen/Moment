<?php
session_start();
require_once($_SESSION["Vendor_PATH"].'autoload.php');

$URLS = array(
    "avatar" => $_SESSION["userData"]["avatar"],
    "givenName" => $_SESSION['userData']['givenName'],
    "logout" => $_SESSION["LOGOUT"],
    "session" => $_SESSION,
    //定義網站URL
    "dashboard" => $_SESSION["Route-dashboard"], 
    "customers" => $_SESSION["Route-customers"],
    "orders" => $_SESSION["Route-orders"],
    "qr" => $_SESSION["Route-qr"],
    //End
);

function Base(callable $fn){
    require_once($_SESSION["Config"]);
    require_once($_SESSION["Core_PATH"].'controller.Class.php');
    if (isset($_SESSION['ucode'])) {
        $Controller = new Controller($user, $passwd);
        if($_COOKIE['id']!=$_SESSION['id']){
            header('location:'.Web_Root_Path."logout.php"); 
            exit();
        }
        if ($Controller->checkUserStatus($_COOKIE["id"], $_COOKIE["sss"])) {
            return $fn($user,$passwd);
        } else {
            header('location:'.Web_Root_Path."index.php");
        }
    } else {
        header('location:'.Web_Root_Path."index.php");
        die();
    }
}
?>