<?php

function readMenu($menu) {
    // query menu item
    $stmt = $menu->read();
    $num = $stmt->rowCount();

    // check if more than 0 record found
    if($num>0) {
      
        // menu array
        $menu_array = array();
        $menu_array["records"] = array();
      
        // retrieve our table contents
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            // extract row
            extract($row);
      
            $menu_item = array(
                "id" => $id,
                "name" => $name,
                "price" => $price,
                "description" => html_entity_decode($description),
                "category_id" => $category_id,
                "category_name" => $category_name
            );
      
            array_push($menu_array["records"], $menu_item);
        }
      
        http_response_code(200);
        // show products data in json format
        echo json_encode($menu_array);
    } else {
        http_response_code(404);
        echo json_encode(
            array("message" => "Menu is empty.")
        );
    }
}      

function createMenu($data, $menu) {
    // make sure data is not empty
    if(
        !empty($data->name) &&
        !empty($data->price) &&
        !empty($data->description) &&
        !empty($data->category_id)
    ) {
        // set product property values
        $menu->name = $data->name;
        $menu->price = $data->price;
        $menu->description = $data->description;
        $menu->category_id = $data->category_id;
        $menu->created_at = date('Y-m-d H:i:s');
    
        // create the menu
        if($menu->create()){
            http_response_code(201);
            echo json_encode(array("message" => "New item added to menu."));
        } else {
            // if unable to create the product, tell the user
            http_response_code(503);
            echo json_encode(array("message" => "Unable to create new menu item."));
        }
    } else {
        // tell the user data is incomplete
        http_response_code(400);
        echo json_encode(array("message" => "Unable to create new menu item. Data is incomplete."));
    }
}

function readOneMenu($id, $menu) {
    // set ID property of record to read
    $menu->id = $id;
    
    // read the details of menu to be edited
    $menu->readOne();
    
    if($menu->name!=null){
        // create array
        $menu_array = array(
            "id" =>  $menu->id,
            "name" => $menu->name,
            "description" => $menu->description,
            "price" => $menu->price,
            "category_id" => $menu->category_id,
            "category_name" => $menu->category_name
    
        );
    
        http_response_code(200);
        echo json_encode($menu_array);
    } else {
        http_response_code(404);
        echo json_encode(array("message" => "Menu item does not exist."));
    }
}

function updateMenu($data, $menu) {
    // set ID property of menu to be edited
    $menu->id = $data->id;
    
    // set menu property values
    $menu->name = $data->name;
    $menu->price = $data->price;
    $menu->description = $data->description;
    $menu->category_id = $data->category_id;
    
    // update the menu
    if($menu->update()) {
        http_response_code(200);
        echo json_encode(array("message" => "Menu item updated."));
    } else {
        // if unable to update the product, tell the user
        http_response_code(503);
        echo json_encode(array("message" => "Unable to update menu item."));
    }
}

function deleteMenu($data, $menu) {
    // set menu id to be deleted
    $menu->id = $data->id;
    
    // delete the menu
    if($menu->delete()) {
        http_response_code(200);
        echo json_encode(array("message" => "Menu item deleted."));
    } else {
        // if unable to delete the product
        http_response_code(503);
        echo json_encode(array("message" => "Unable to delete menu item."));
    }
}