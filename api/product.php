<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// include database and object files
include_once './config/database.php';
include_once './objects/Product.php';
  
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$product = new Product($db);

$method = $_SERVER['REQUEST_METHOD'];

// set ID property of record to read
/* If a param of ID is set, save that too
if(isset($_GET['id'])) {
    $id = $_GET['id'] != '' ? $_GET['id'] : null;
 }*/
//if id is in url
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}


//switch for requests
switch ($method) {  
    case 'GET': 
        if(!isset($id)) {
        // query products
        $stmt = $product->read();
        $num = $stmt->rowCount();
  
        // check if more than 0 record found
        if($num>0){  
            // products array
            $products_arr=array();
            $products_arr["records"]=array(); 
            // retrieve our table contents
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                // extract row
                // this will make $row['name'] to
                // just $name only
                extract($row); 
                $product_item=array(
                    "id" => $id,
                    "name" => $name,
                    "description" => html_entity_decode($description),
                    "price" => $price,
                    "category_id" => $category_id,
                    "category_name" => $category_name
                );  
                array_push($products_arr["records"], $product_item);
                }
            // set response code - 200 OK
            http_response_code(200); 
            // show products data in json format
            echo json_encode($products_arr);
            }  
        else{  
            // set response code - 404 Not found
            http_response_code(404);
    
            // tell the user no products found
            echo json_encode(
            array("message" => "No products found.")
            );
            } 
       }else{
            // set ID property of record to read
            //$product->id = isset($_GET['id']) ? $_GET['id'] : die();
            $product->readOne($id);
  
            if($product->name!=null){
                // create array
                $product_arr = array(
                    "id" =>  $product->id,
                    "name" => $product->name,
                    "description" => $product->description,
                    "price" => $product->price,
                    "category_id" => $product->category_id,
                    "category_name" => $product->category_name
            
                );
            
                // set response code - 200 OK
                http_response_code(200);
            
                // make it json format
                echo json_encode($product_arr);
            }
            
            else{
                // set response code - 404 Not found
                http_response_code(404);
            
                // tell the user product does not exist
                echo json_encode(array("message" => "Product does not exist."));
            }
                       // echo " id satt";
        }
    break;

    case'POST':
    // get posted data
    $data = json_decode(file_get_contents("php://input"));
  
    // make sure data is not empty
    if(
    !empty($data->name) &&
    !empty($data->price) &&
    !empty($data->description) &&
    !empty($data->category_id)
    ){
  
    // set product property values
    $product->name = $data->name;
    $product->price = $data->price;
    $product->description = $data->description;
    $product->category_id = $data->category_id;
    $product->created = date('Y-m-d H:i:s');
  
    // create the product
    if($product->create()){
  
        // set response code - 201 created
        http_response_code(201);
  
        // tell the user
        echo json_encode(array("message" => "Product was created."));
    }
  
    // if unable to create the product, tell the user
    else{
  
        // set response code - 503 service unavailable
        http_response_code(503);
  
        // tell the user
        echo json_encode(array("message" => "Unable to create product."));
    }
    }
  
    // tell the user data is incomplete
    else{
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the user
    echo json_encode(array("message" => "Unable to create product. Data is incomplete."));
    }
    break;

    case'PUT':
            // get id of product to be edited
    $data = json_decode(file_get_contents("php://input"));
    
    // set ID property of product to be edited
    $product->id = $data->id;
    
    // set product property values
    $product->name = $data->name;
    $product->price = $data->price;
    $product->description = $data->description;
    $product->category_id = $data->category_id;
    
    // update the product
    if($product->update()){
    
        // set response code - 200 ok
        http_response_code(200);
    
        // tell the user
        echo json_encode(array("message" => "Product was updated."));
    }
    
    // if unable to update the product, tell the user
    else{
    
        // set response code - 503 service unavailable
        http_response_code(503);
    
        // tell the user
        echo json_encode(array("message" => "Unable to update product."));
    }
    break;

    case 'DELETE':
        // get product id
    $data = json_decode(file_get_contents("php://input"));
    
    // set product id to be deleted
    $product->id = $id;
    
    // delete the product
    if($product->delete()){
    
        // set response code - 200 ok
        http_response_code(200);
    
        // tell the user
        echo json_encode(array("message" => "Product was deleted."));
    }
    
    // if unable to delete the product
    else{
    
        // set response code - 503 service unavailable
        http_response_code(503);
    
        // tell the user
        echo json_encode(array("message" => "Unable to delete product."));
    }
    break;

}
?>
