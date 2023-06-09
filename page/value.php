<?php
// 確認是否收到 POST 請求
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 獲取 POST 資料
    $data1 = $_POST['data1'];
    var_dump($data1);
    // 在這裡可以對資料進行處理，例如儲存到資料庫或進行其他操作

    // 回傳回應
    $response = "資料已成功處理";
    echo $response;
}
?>