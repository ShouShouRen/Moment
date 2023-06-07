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
function printData($user,$passwd){
    $db = new Connect($user,$passwd);
    $user = $db->prepare("SELECT *  FROM `Guests`");
    $user->execute();
    $content = '
            <table class="table">
                <thead class="table-dark">
                    <tr align="center" >
                        <th scope="col" align="center" >id</th>
                        <th scope="col" align="center" >token</th>
                        <th scope="col" align="center" >Base64</th>
                        <th scope="col" align="center" >功能</th>
                    </tr>
                </thead>
                <tbody>    
    ';
    while($userInfo = $user->fetch(PDO::FETCH_ASSOC)){
        $content .= '
            <tr class="user_tab">
                <td align="center" >'.$userInfo["id"].'</td>
                <td align="center" >'.$userInfo["token"].'</td>
                <td align="center" >'.$userInfo["base64"].'</td>
                <td align="center" >
                    <form method="post" action="people.php">
                        <input type="hidden" name="user_remove" value="'.$userInfo["id"].'">
                        <input class="btn btn-danger" type="submit" name="submit" value="移除" >
                    </form>
                </td>
            </tr>
            ';
        
    }
    $content .= '
        </tbody></table>
        ';
    return $content;
}
Base(function($user,$passwd) use ($url){
    $url["result"] = printData($user,$passwd);
    // $db = new Connect($user,$passwd);
    // $sql = "SELECT *  FROM `Guests`";
    // $stmt = $db->prepare($sql);
    // $stmt->execute();
    // $count = $stmt->rowCount();
    // if($count==0){
    //     $url["result"] = $count;
    // }
    // else{
    //     $callback = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //     $url["result"] = $callback;
    // }
    $loader = new FilesystemLoader(ROOT_PATH.'/templates');
    $twig = new Environment($loader);
    if (basename($_SERVER["REQUEST_URI"]) == basename(__FILE__)){
        $url["customers_active"] = "active";
        echo $twig->render('customers.twig',$url);
    }
});
?>