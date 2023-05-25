<?php
require_once('FileRoute.php');
session_start();
require_once($_SESSION["Core_PATH"].'controller.Class.php');
require_once($_SESSION["Config"]);
// require_once('SessionMG.php');

//Start Debug Message
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
//End Debug Message
if(isset($_GET["code"])){
    $_SESSION['ucode'] = $_GET["code"];
    $token = $gClient->fetchAccessTokenWithAuthCode($_GET["code"]);
}
else{
    header('Location:'.Web_Root_Path."index.php");
    exit();
}
if(isset($token["error"])!="invalid_grant"){
     
    $oAuth = new Google_Service_Oauth2($gClient);
    $userData = $oAuth->userinfo_v2_me->get();
    $_SESSION['userData'] = array(
        'email' => $userData['email'],
        'avatar' => $userData['picture'],
        'familyName' => $userData['familyName'],
        'givenName' => $userData['givenName'] 
    ); 

    if(!isset($_SESSION['userData'])){
        header("Location: ".Web_Root_Path.'index.php');
        exit();
    }
    
    // $ret = $stmt->fetch(PDO::FETCH_ASSOC);
    // insert data
    $Controller = new Controller($user,$passwd);
    echo $Controller->LoginPremission(array(
        'email' => $userData['email'],
        'avatar' => $userData['picture'],
        'familyName' => $userData['familyName'],
        'givenName' => $userData['givenName'] 
    ));
}
else{
    header('Location: '.Web_Root_Path.'index.php');
    exit();
}
?>