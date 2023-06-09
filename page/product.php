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
function printProduct($user,$passwd,&$url){
    $db = new Connect($user,$passwd);

    $limit = 10;
    $page = intval($_GET["page"] ?? "1");
    $url["page"] = $page;
    if($page == 0) $start = ($page) * $limit;
    else $start = ($page - 1) * $limit;
    $product = $db->prepare("SELECT * FROM `Menu` LIMIT $start, $limit");
    $product->execute();
    $total = $db->query("SELECT * FROM `Menu`")->rowCount();
    $total_pages = intval(ceil($total / $limit));
    $url["total_pages"] = $total_pages;
    
    $content = '
    <table class="table" style="margin-top: 80px">
        <thead class="table-dark">
            <tr align="center" >
                <th scope="col" align="center" >check</th>
                <th scope="col" align="center" ><input type="checkbox" onClick="toggle(this)" class="form-check-input h3"></th>
                <th scope="col" align="center" >title</th>
                <th scope="col" align="center" >price</th>
                <th scope="col" align="center" >image</th>
            </tr>
        </thead>
        <tbody>';
    while($productInfo = $product->fetch(PDO::FETCH_ASSOC)){
    $content .= '
        <tr class="product_tab">
            <td align="center" >'.$productInfo["id"].'</td>
            <td align="center" ><input type="checkbox" class="form-check-input h3" name="select" value='.$productInfo["id"].'></td>
            <td align="center" >'.$productInfo["title"].'</td>
            <td align="center" >'.$productInfo["price"].'</td>
            <td align="center" >'.$productInfo["image"].'</td>
        </tr>
        ';
    }
    $content .= '
    </tbody></table>
    ';
    return $content;
}
// <td align="center" >
                // <form method="post" action="product.php?page='.$page.'">
                    // <input type="hidden" name="customers_remove" value="'.$productInfo["id"].'">
                    // <input class="btn btn-danger" type="submit" name="submit" value="移除" >
                // </form>
            // </td>
Base(function($user,$passwd) use ($url){
    $loader = new FilesystemLoader(ROOT_PATH.'/templates');
    $twig = new Environment($loader);
    // 確認是否收到 POST 請求
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $whichOnes = $_POST['data1'];
        $controller = new Controller($user,$passwd);
        foreach($whichOnes as $i){
            $controller->deleteData("menu",$i); 
        }
    }
    $url["result"] = printProduct($user,$passwd,$url);
    if (basename($_SERVER["PHP_SELF"]) == basename(__FILE__)){
        $url["product_active"] = "active";
        echo $twig->render('product.twig',$url);
    }
});
?>