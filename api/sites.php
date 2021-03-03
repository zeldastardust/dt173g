<?php
// headers
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
// check if id is set
if(isset($_GET['id'])) {
    $id = $_GET['id'] != '' ? $_GET['id'] : null;
 }


//switch for requests
switch ($method) {  
    case 'GET': 
        if(isset($id)) {
        $result = $sites->readOne($id);
        } else {
        $result = $sites->read();
        }
        // check if more than 0 record found
        if(sizeof($result) > 0) {
            http_response_code(200); // set response code - 200 OK
         } else {
            http_response_code(404); // set response code - 404 Not found
            $result = array('message' => 'Could not find site');
         }
         break;

    case'POST':
    // get posted data
    $data = json_decode(file_get_contents("php://input"));
  
    // set sites property values
    $sites->webname = $data->webname;
    $sites->url = $data->url;
    $sites->description = $data->description;

    // create the study 
    if($sites->create()){  
        // set response code - 201 created
        http_response_code(201);
        // tell the user
        $result = array("message" => "Site was created.");
    }
    // if unable to create the site, tell the user
    else{  
        // set response code - 503 service unavailable
        http_response_code(503);
  
        // tell the user
        $result = array("message" => "Unable to create site.");
    }
    break;
    case'PUT':
        //check if id is set
      if(!isset($id)) {
        http_response_code(510); 
        $result = array('message' => 'An id is needed');
     } else {
            // get id of site to be edited
    $data = json_decode(file_get_contents("php://input"));
  
    // set site property values
    $sites->webname = $data->webname;
    $sites->url = $data->url;
    $sites->description = $data->description;
    
    
    // update site
    if($sites->update($id)){
        // set response code - 200 ok
        http_response_code(200);
        // tell the user
        $result = array("message" => "site was updated.");
    } 
    // if unable to update the site, tell the user
    else{
        // set response code - 503 service unavailable
        http_response_code(503);
    
        // tell the user
        $result = array("message" => "Unable to update site.");
    }
}
    break;

    case 'DELETE':
        //check if id is set
          if(!isset($id)) {
             http_response_code(510); 
             $result = array('message' => 'An id is needed');
          } else {
             if($sites->delete($id)) {
                http_response_code(200);  // set response code - 200 ok
                $result = array('message' => 'Site deleted');
             } else {
                http_response_code(503); // set response code - 503 server error
                $result = array('message' => 'Unable to delete site');
             }
          }
          break;

}
// Return result as JSON
echo json_encode($result);
// Close DB connection
$db = $database->close();
?>