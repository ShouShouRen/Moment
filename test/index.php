<?php
    require_once("../FileRoute.php");
    require_once(Core_PATH."controller.Class.php");
    require_once("../config.php");
    session_start();
    $db = new Connect($user,$passwd);
    
    if(isset($_GET["token"])){
        $data = $_GET["token"];

        
        $sql = "SELECT token,base64 FROM Guests WHERE token = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$data]);
        $count = $stmt->rowCount();
        if($count==0){
            die('error');
        }
        
        $sec = $stmt->fetch(PDO::FETCH_ASSOC);


        if(password_verify($sec["base64"],$data)){
            $decoder_code = base64_decode($sec["base64"]);
            $arr = explode(" ",$decoder_code);

            // $time = $arr[1];
            // echo $time . "<br>";
            // $end = date("H:$time+15:s");
            // $time = date('Y-m-d H:i:s');
            // $new_time = date('Y-m-d H:i:s', strtotime($time . '+15 minutes'));
            // echo $new_time;
            // // echo $end;
            // if($time < $new_time){
            //     echo('aaa');
            // }else{
            //     echo("bbb");
            // }
            
            // // echo date("H:i:s",strtotime("+5 min"));

            $currentTimestamp = time();
            $entryTimestamp = $currentTimestamp + (1 * 60);//設定一分鐘到數

            $entryTime = date('Y-m-d H:i:s', $currentTimestamp);
            $endTime = date('Y-m-d H:i:s', $entryTimestamp);

            echo "進入網站時間:$entryTime<br>";
            echo "禁止操作時間:$endTime<br>";
        }
        else{
            echo "error1";
        }
    }
    else{
        echo "NONE";
        // header("Location: index.php");
    }
?>
<!DOCTYPE html>
<html lang="zh-Hant-TW">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div id="remaining-time"></div>
</body>
</html>
<script>
    var currentTime = new Date().getTime() / 1000;
    var endTime = <?php echo $entryTimestamp; ?>;

    var remainingTime = endTime - currentTime;

    function updateRemainingTime() {
        var minutes = Math.floor(remainingTime / 60);
        var seconds = Math.floor(remainingTime % 60);
        var timeDisplay = minutes + " 分鐘 " + seconds + " 秒";
        document.getElementById("remaining-time").innerHTML = "剩下時間" + timeDisplay;
        remainingTime--;
        if (remainingTime <= 0) {
            // document.getElementById("remaining-time").innerHTML = "Error";
            window.location.href = "error.html";

        } else {
            setTimeout(updateRemainingTime, 1000);
        }
    }
    updateRemainingTime();
</script>