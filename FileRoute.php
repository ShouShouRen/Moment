<?php
session_start();
//Define require File Name
define('Vendor_PATH', __DIR__ . '/vendor' . '/');
define('ROOT_PATH', dirname(__FILE__) . '/');
define('Core_PATH', ROOT_PATH . 'core' . '/');
define('Function_PATH', ROOT_PATH . 'functions' . '/');
define('Base', ROOT_PATH . 'Base.php'.'/');
//Defne web Url
define('Web_Root_Path',$_SESSION['WEB_ROOT'].'/'); //這裡之後搬家之後需要修正路徑位置
define('Resource_PATH', Web_Root_Path.'resource' . '/');
define('Page_PATH',Web_Root_Path.'page' . '/');
define('Image_PATH', Web_Root_Path.'images' . '/');
define('Template_PATH', Web_Root_Path.'templates' . '/');
define('Logout', Web_Root_Path . 'logout.php');
$_SESSION["Resource_PATH"] = Resource_PATH;
$_SESSION["Page_PATH"] = Page_PATH;
$_SESSION["Image_PATH"] = Image_PATH;
$_SESSION["LOGOUT"] = Logout;
//Define User templates
function outputFiles($path)
{
    // Check directory exists or not
    if (file_exists($path) && is_dir($path)) {
        // Scan the files in this directory
        $result = scandir($path);
        // Filter out the current (.) and parent (..) directories
        $files = array_diff($result, array('.', '..'));
        return $files;
    } else {
        die("Error0");
    }
}
function strriposfunction($val = "", $type = "")
{
    switch ($type) {
        case "1":
            //去除副檔名
            $fileName = $val;
            if (false !== $pos = strripos($fileName, '.')) {
                $fileName = substr($fileName, 0, $pos);
            }
            break;

        case "2":
            //取得副檔名
            $fileName = $val;
            if (false !== $pos = strripos($fileName, '.')) {
                $fileName = substr($fileName, $pos + 1, strlen($fileName));
            }

            break;
    }
    return $fileName;
}
foreach (outputFiles(ROOT_PATH."page") as $file) {
    // define(strriposfunction($val=$file,$type="1"),$file);
    $_SESSION["Route-".strriposfunction($val=$file,$type="1")] = $file;
}
?>