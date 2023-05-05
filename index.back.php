<?php
session_start();
$q = explode('/',$_SERVER['PHP_SELF']);
array_pop($q);
$q = implode("/", $q);
$_SESSION['WEB_ROOT'] = $q;
require_once('FileRoute.php');
require_once(ROOT_PATH.'config.php');
require_once(Core_PATH.'controller.Class.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login With Google</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
    
</head>
<body>
    <div class="container" style="margin-top:100px;">
        <?php
            if(isset($_COOKIE["id"]) && isset($_COOKIE["sss"]) && isset($_SESSION['ucode'])){
                $Controller = new Controller($user,$passwd);
                if($Controller->checkUserStatus($_COOKIE["id"],$_COOKIE["sss"])){
                    header('location: '.Web_Root_Path.'page/dashboard.php');
                    exit();
                }
                else{
                    header('location:'.Web_Root_Path."index.php");
                    exit();
                }
            }
            else{
        ?>
        <img src="images/Logo.png" alt="Logo" style="display: table;margin:0 atuo;max-width: 150px;"/>
        <form action="" method="POST">
            <div class="form-group">
                <label for="exampleInputEmail1">Email Address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Enter password">
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
            <button onclick="window.location = '<?php echo $login_url?>'" type="button" class="btn btn-danger">Login with Google</button>
        </form>
        <?php } ?>
    </div>
</body>
</html>
