<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <?php if(isset($_POST)){
    // echo $_POST["getTotalPrice"];
    // echo $_POST["token"];
    // echo $_POST
    // var_dump($_POST);
    // echo($_POST["desk"]);
    foreach ($_POST['product_name'] as $index => $productName) {
      echo $index."  ".$productName."\n";
    }
    foreach($_POST["product_count"] as $idx => $productCount){
      echo $index."  ".$productCount."\n";
    }
  }else{
    die("error");
  }
  ?>
</body>
</html>