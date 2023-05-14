<?php
error_reporting(0);

require_once("../FileRoute.php");
require_once(Core_PATH . "controller.Class.php");
require_once("../config.php");
require_once(Base);

session_start();

$db = new Connect($user, $passwd);
$today = date("Y-m-d H:i:s");
$desk = "A1";
$sql = "SELECT * FROM `Guests`";
$stmt = $db->prepare($sql);
$stmt->execute();
$count = $stmt->rowCount();
if ($count == 0) {
    $sql = "ALTER TABLE `Guests` AUTO_INCREMENT = 0;";
    $stmt = $db->prepare($sql);
    $stmt->execute();
}

$stmt = $db->prepare("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE   (TABLE_NAME = 'Guests');");
$stmt->execute();
$count = $stmt->fetch(PDO::FETCH_ASSOC);

$numberID = $count['AUTO_INCREMENT'] + 1;

$sec = $today . " " . $numberID . " " . $desk;
$send = base64_encode($sec);
$out = password_hash($send, PASSWORD_DEFAULT);
$sql = "INSERT INTO Guests(token,base64) VALUES (?,?)";
$stmt = $db->prepare($sql);
$stmt->execute([$out, $send]);
$code = urlencode("https://moment.duacodie.com/Merge/test/index.php?token=$out");
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$url = $URLS;
$url["code"] = "https://barcodeapi.org/api/qr/$code";

Base(function () use ($url) {
    $loader = new FilesystemLoader(ROOT_PATH . '/templates');
    $twig = new Environment($loader);
    if (basename($_SERVER["REQUEST_URI"]) == basename(__FILE__)) {
        $url["qr_active"] = "active";
        echo $twig->render('qr.twig', $url);
    }
});
