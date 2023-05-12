<?php
if(isset($_GET["token"])&&isset($_GET["sec"])){
    $data = $_GET["token"];
    $sec = $_GET["sec"];
    if(password_verify($sec,$data)){
        $decoder_code = base64_decode($sec);
        $arr = explode(" ",$decoder_code);
        var_dump($arr);
    }
    else{
        echo "error1";
    }
}
else{
    echo "NONE";
    header("Location: index.php");
}
?>