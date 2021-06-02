<?php
include_once './router/menu.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );
$requestMethod = $_SERVER["REQUEST_METHOD"];

switch ($uri[2]) {
    case 'menu':
        menuRouter($requestMethod);
        break;
    
    default:
        echo "404";
        break;
}


?>