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
function printData($user,$passwd,&$url){
    $db = new Connect($user,$passwd);
    $limit = 10;
    $page = intval($_GET["page"] ?? "1");
    $url["page"] = $page;
    if($page == 0) $start = ($page) * $limit;
    else $start = ($page - 1) * $limit;
    $user = $db->prepare("SELECT * FROM `Guests` LIMIT $start, $limit");
    $user->execute();
    $total = $db->query("SELECT * FROM `Guests`")->rowCount();
    $total_pages = intval(ceil($total / $limit));
    $url["total_pages"] = $total_pages;
    $content = '
            <table class="table" style="margin-top: 80px">
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
                    <form method="post" action="customers.php?page='.$page.'">
                        <input type="hidden" name="customers_remove" value="'.$userInfo["id"].'">
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
    if(isset($_POST["customers_remove"])){
        $controller = new Controller($user,$passwd);
        $result = $controller->deleteData("guest",$_POST["customers_remove"]);
        if(!$result){
            die($result);
        }
    }
    $url["result"] = printData($user,$passwd,$url);
    $loader = new FilesystemLoader(ROOT_PATH.'/templates');
    $twig = new Environment($loader);
    if (basename($_SERVER["PHP_SELF"]) == basename(__FILE__)){
        $url["customers_active"] = "active";
        echo $twig->render('customers.twig',$url);
    }
});
?>