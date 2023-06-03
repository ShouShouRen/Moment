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
        $db = new Connect($user,$passwd);
        $sql = 'SELECT `Guests`.`token`, `orders`.`desk`,`orders`.`product_name`,`orders`.`product_count`,`orders`.`totalPrice` FROM `Guests` NATURAL JOIN `orders` WHERE `Guests`.`token` = "$2y$10$rptGIlBzE3gpd0A7kdNyLu6gTWEEIt6UmY/WLMctwVyNjRTKLgT3m";';
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $callBack = $stmt -> fetchAll(PDO::FETCH_ASSOC);
        var_dump($db->convert($callBack)); 
        $loader = new FilesystemLoader(ROOT_PATH.'/templates');
        $twig = new Environment($loader);
        if (basename($_SERVER["REQUEST_URI"]) == basename(__FILE__)){
            $url["orders_active"] = "active";
            echo $twig->render('orders.twig',$url);
        }
    }
    // $sql = 'SELECT Guests.token, orders.desk,orders.product_name,orders.product_count,orders.totalPrice FROM Guests NATURAL JOIN orders WHERE Guests.token = "$2y$10$rptGIlBzE3gpd0A7kdNyLu6gTWEEIt6UmY/WLMctwVyNjRTKLgT3m";';
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
                $db = new Connect($user,$passwd);
                $amerge = array_combine($_POST['product_name'],$_POST['product_count']);
                foreach ($amerge as $key => $val) {
                    $stmt = $db -> prepare("INSERT INTO `orders` (desk,token,product_name,product_count,totalPrice) VALUES(:desk,:token,:product_name,:product_count,:totalPrice)");
                    $stmt->execute([
                        ':desk' => $_POST["desk"],
                        ":token" => $_POST["token"],
                        ':product_name' => $key,
                        ':product_count' => $val,
                        ':totalPrice' => $_POST["getTotalPrice"] 
                    ]);
                }
                
            }
            else{
                die('err');
            }
        }
    }
});
?>