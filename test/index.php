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
            die('error0');
        }
        $sec = $stmt->fetch(PDO::FETCH_ASSOC);
        if(password_verify($sec["base64"],$data)){
            $decoder_code = base64_decode($sec["base64"]);
            $arr = explode(" ",$decoder_code);

            $_SESSION['time'] = $arr[1];
            $_SESSION['new_time'] = date('H:i:s', strtotime($_SESSION['time'].'+1 minutes')); // 加上 15 分鐘
            $now = date("H:i:s");
            if(($now > $_SESSION['new_time'])){
                $sql = "DELETE FROM `Guests` WHERE token = ?";
                $stmt = $db->prepare($sql);
                $stmt->execute([$data]);
                die("error2");
            }
            if(isset($_SESSION['time']) && isset($_SESSION['new_time'])){
                echo $now."<br><br>";
                echo $_SESSION['time']."<br>";
                echo $_SESSION['new_time']."<br>"; // 顯示加上 15 分鐘後的時間，格式為 時:分:秒
            }
            else{
                echo $now."<br><br>";
            }
            // echo $end;
            // if($time<=$end){
            //     echo('aaa');
            // }else{
            //     echo("bbb");
            // }
            
            // // echo date("H:i:s",strtotime("+5 min"));

            // $currentTimestamp = time();
            // $entryTimestamp = $currentTimestamp + (1 * 60);//設定一分鐘到數

            // $entryTime = date('Y-m-d H:i:s', $currentTimestamp);
            // $endTime = date('Y-m-d H:i:s', $entryTimestamp);
            
            // echo "進入網站時間:$entryTime"."<br>";
            // echo "禁止操作時間:$endTime"."<br>";
            // var_dump($_POST["code"]);
            $hide = $_POST["code"];
            if($hide == $_SESSION['code']){
                echo "suc";
            }else{
                die("err");
            }
        }
        else{
            dir("error1");
        }
    }
    else{
        die ("NONE");
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
    // var currentTime = new Date().getTime() / 1000;
    // var endTime = <?php echo $entryTimestamp; ?>;

    // var remainingTime = endTime - currentTime;

    // function updateRemainingTime() {
    //     var minutes = Math.floor(remainingTime / 60);
    //     var seconds = Math.floor(remainingTime % 60);
    //     var timeDisplay = minutes + " 分鐘 " + seconds + " 秒";
    //     document.getElementById("remaining-time").innerHTML = "剩下時間" + timeDisplay;
    //     remainingTime--;
    //     if (remainingTime <= 0) {
    //         // document.getElementById("remaining-time").innerHTML = "Error";
    //         window.location.href = "error.html";

    //     } else {
    //         setTimeout(updateRemainingTime, 1000);
    //     }
    // }
    // updateRemainingTime();
    // (function(_0x36f176,_0x18bdb7){var _0x5dad06=_0x3c55,_0x2bb393=_0x36f176();while(!![]){try{var _0x1d9321=-parseInt(_0x5dad06(0x7c))/0x1+-parseInt(_0x5dad06(0x75))/0x2*(parseInt(_0x5dad06(0x7e))/0x3)+-parseInt(_0x5dad06(0x74))/0x4*(parseInt(_0x5dad06(0x7a))/0x5)+-parseInt(_0x5dad06(0x72))/0x6+parseInt(_0x5dad06(0x7f))/0x7*(-parseInt(_0x5dad06(0x7d))/0x8)+-parseInt(_0x5dad06(0x6f))/0x9*(parseInt(_0x5dad06(0x7b))/0xa)+parseInt(_0x5dad06(0x78))/0xb;if(_0x1d9321===_0x18bdb7)break;else _0x2bb393['push'](_0x2bb393['shift']());}catch(_0x4644a4){_0x2bb393['push'](_0x2bb393['shift']());}}}(_0x2b10,0x6b3de));function updateRemainingTime(){var _0xe417f9=_0x3c55,_0x52293b=Math['floor'](remainingTime/0x3c),_0x3c5090=Math['floor'](remainingTime%0x3c),_0x7a882e=_0x52293b+_0xe417f9(0x71)+_0x3c5090+'\x20秒';document[_0xe417f9(0x76)]('remaining-time')[_0xe417f9(0x70)]=_0xe417f9(0x73)+_0x7a882e,remainingTime--,remainingTime<=0x0?window[_0xe417f9(0x79)][_0xe417f9(0x6e)]=_0xe417f9(0x77):setTimeout(updateRemainingTime,0x3e8);}function _0x3c55(_0x4447f2,_0xcd7c59){var _0x2b106d=_0x2b10();return _0x3c55=function(_0x3c553f,_0x1d7123){_0x3c553f=_0x3c553f-0x6e;var _0x6d8b2d=_0x2b106d[_0x3c553f];return _0x6d8b2d;},_0x3c55(_0x4447f2,_0xcd7c59);}updateRemainingTime();function _0x2b10(){var _0x4fda7f=['href','19539uqMQuo','innerHTML','\x20分鐘\x20','2353704NkipVr','剩下時間','2587636rLwFdr','50zHcDcM','getElementById','error.html','38243293xYyyVm','location','5tqbxET','3370VCBVeV','533561izQFtp','2792Qpivoi','47967EYEfaP','6685JKSZVM'];_0x2b10=function(){return _0x4fda7f;};return _0x2b10();}
    // function _0x4ebc(_0x20c765,_0x5a5abc){var _0x3a068e=_0x3a06();return _0x4ebc=function(_0x4ebcd3,_0x102c8f){_0x4ebcd3=_0x4ebcd3-0xd9;var _0x3be38f=_0x3a068e[_0x4ebcd3];return _0x3be38f;},_0x4ebc(_0x20c765,_0x5a5abc);}(function(_0x503f38,_0xffa4d0){var _0x1bc0d4=_0x4ebc,_0x1eced3=_0x503f38();while(!![]){try{var _0x213daa=parseInt(_0x1bc0d4(0xd9))/0x1*(parseInt(_0x1bc0d4(0xe4))/0x2)+parseInt(_0x1bc0d4(0xe1))/0x3+-parseInt(_0x1bc0d4(0xe0))/0x4+parseInt(_0x1bc0d4(0xdb))/0x5+-parseInt(_0x1bc0d4(0xdf))/0x6+-parseInt(_0x1bc0d4(0xe6))/0x7+-parseInt(_0x1bc0d4(0xdc))/0x8*(-parseInt(_0x1bc0d4(0xdd))/0x9);if(_0x213daa===_0xffa4d0)break;else _0x1eced3['push'](_0x1eced3['shift']());}catch(_0x39e4d7){_0x1eced3['push'](_0x1eced3['shift']());}}}(_0x3a06,0x3684e));function updateRemainingTime(){var _0x32208a=_0x4ebc,_0x403967=Math['floor'](remainingTime/0x3c),_0x4e8050=Math[_0x32208a(0xe5)](remainingTime%0x3c),_0x59681a=_0x403967+'\x20分鐘\x20'+_0x4e8050+'\x20秒';document[_0x32208a(0xe3)](_0x32208a(0xda))['innerHTML']=_0x32208a(0xe2)+_0x59681a,remainingTime--,remainingTime<=0x0?window[_0x32208a(0xde)]['href']='error.html':setTimeout(updateRemainingTime,0x3e8);}updateRemainingTime();function _0x3a06(){var _0x4e5031=['2917110rpvpef','12307UydwgO','remaining-time','624740uimaHM','40QvaKZo','1192095LIiXUq','location','1203570golwrS','1776872DHCkBu','1271364nDHOZy','剩下時間','getElementById','12iuvUxK','floor'];_0x3a06=function(){return _0x4e5031;};return _0x3a06();}
</script>