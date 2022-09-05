<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

define("URL", str_replace("index.php","",(isset($_SERVER['HTTPS']) ? "https" : "http").
"://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]"));


require_once "controllers/UserController.php";
require_once "controllers/ImageController.php";


$userController = new UserController();
$imageController = new ImageController();




try{
    if(empty($_GET['page'])){
        throw new Exception("La page n'existe pas");
    } else {
        $url = explode("/",filter_var($_GET['page'],FILTER_SANITIZE_URL));
        if(empty($url[0])) throw new Exception ("La page n'existe pas");
        switch($url[0]){
        
            case "register": $userController->registerUser();
            break;
            case "login": $userController->login();
            break;    
            default : throw new Exception ("La page n'existe pas");
        }
    }
} catch (Exception $e){
    $msg = $e->getMessage();
    echo $msg;
   
}