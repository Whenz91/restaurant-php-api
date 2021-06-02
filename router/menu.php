<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Max-Age: 3600");
header("Content-Type: application/json; charset=UTF-8");
  
// include database and object files
include_once './config/connect.php';
include_once './model/menu.php';
include_once './controllers/menuController.php';

function menuRouter($requestMethod) {
    // instantiate database and product object
    $database = new Database();
    $db = $database->getConnection();
        
    // initialize object
    $menu = new Menu($db);

    // get id param
    $id = isset($_GET['id']) ? $_GET['id'] : null;
    // get posted data
    $data = json_decode(file_get_contents("php://input"));

    switch ($requestMethod) {
        case 'GET':
            if($id === null) {
                readMenu($menu);
            } else {
                readOneMenu($id, $menu);
            }
            break;
        case 'POST':
            createMenu($data, $menu);
            break;
        case 'PUT':
            updateMenu($data, $menu);
            break;
        case 'DELETE':
            deleteMenu($data, $menu);
            break;
        
        default:
            echo "Nothing found";
            break;
    }
    
}