<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// include database and object files
include_once './config/database.php';
include_once './objects/Sites.php';
  
// instantiate database and sites object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$sites = new Sites($db);

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
        // query site
        $stmt = $sites->read();
        $num = $stmt->rowCount();
  
        // check if more than 0 record found
        if($num>0){  
            // site array
            $sites_arr=array();
            $sites_arr["records"]=array(); 
            // retrieve our table contents
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                // extract row
                // this will make $row['name'] to
                // just $name only
                extract($row); 
                $sites_item=array(
                    "id" => $id,
                    "webname" => $webname,
                    "url" => $url,
                    "description" => $description               
                );  
                array_push($sites_arr["records"], $sites_item);
                }
            // set response code - 200 OK
            http_response_code(200); 
            // show work data in json format
            echo json_encode($sites_arr);
            }  
        else{  
            // set response code - 404 Not found
            http_response_code(404);
    
            // tell the user no studies found
            echo json_encode(
            array("message" => "No sites found.")
            );
            } 
       }else{
            // set ID property of record to read
        
            $sites->readOne($id);
  
            if($sites->webname!=null){
                // create array
                $sites_arr = array(
                    "id" =>  $sites->id,
                    "webname" => $sites->webname,
                    "url" => $sites->url,
                    "description" => $sites->description
                );
            
                // set response code - 200 OK
                http_response_code(200);
            
                // make it json format
                echo json_encode($sites_arr);
            }
            
            else{
                // set response code - 404 Not found
                http_response_code(404);
            
                // tell the user site does not exist
                echo json_encode(array("message" => "site does not exist."));
            }
                       // echo " id satt";
        }
    break;

    case'POST':
    // get posted data
    $data = json_decode(file_get_contents("php://input"));
  
    // make sure data is not empty
    if(
    !empty($data->webname) &&
    !empty($data->url) &&
    !empty($data->description) 
    ){
  
    // set sites property values
    $sites->webname = $data->webname;
    $sites->url = $data->url;
    $sites->description = $data->description;

    // create the site 
    if($sites->create()){
  
        // set response code - 201 created
        http_response_code(201);
  
        // tell the user
        echo json_encode(array("message" => "Site was created."));
    }
  
    // if unable to create the site, tell the user
    else{
  
        // set response code - 503 service unavailable
        http_response_code(503);
  
        // tell the user
        echo json_encode(array("message" => "Unable to create site."));
    }
    }
  
    // tell the user data is incomplete
    else{
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the user
    echo json_encode(array("message" => "Unable to create site. Data is incomplete."));
    }
    break;

    case'PUT':
            // get id of site to be edited
    $data = json_decode(file_get_contents("php://input"));
    
    // set ID property of site to be edited
    $sites->id = $data->id;
    
    // set product property values
    $sites->webname = $data->webname;
    $sites->url = $data->url;
    $sites->description = $data->description;
   
    // update sites
    if($sites->update()){
    
        // set response code - 200 ok
        http_response_code(200);
    
        // tell the user
        echo json_encode(array("message" => "Site was updated."));
    }
    
    // if unable to update the site, tell the user
    else{
    
        // set response code - 503 service unavailable
        http_response_code(503);
    
        // tell the user
        echo json_encode(array("message" => "Unable to update the site."));
    }
    break;

    case 'DELETE':
        // get site id
    $data = json_decode(file_get_contents("php://input"));
    
    // set site id to be deleted
    $sites->id = $id;
    
    // delete the site
    if($sites->delete()){
    
        // set response code - 200 ok
        http_response_code(200);
    
        // tell the user
        echo json_encode(array("message" => "site was deleted."));
    }
    
    // if unable to delete the site
    else{
    
        // set response code - 503 service unavailable
        http_response_code(503);
    
        // tell the user
        echo json_encode(array("message" => "Unable to delete site."));
    }
    break;

}
// Close DB connection
$db = $database->close();
?>