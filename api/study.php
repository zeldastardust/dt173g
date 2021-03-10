<?php
//  headers
header("Access-Control-Allow-Origin: *");//tillåter åtkomst från alla domäner
header("Content-Type: application/json; charset=UTF-8");//talar om att det är json
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");//tillåter request metoder
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, 
Authorization, X-Requested-With");//talar om att headers ska användas
  
// include database and object files
include_once './config/database.php';
include_once './objects/Study.php';
  
// instantiate database and study object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$study = new Study($db);

// variable for request method
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
        $result = $study->readOne($id);
        } else {
        $result = $study->read();
        }
  // check if more than 0 record found
  if(sizeof($result) > 0) {
    http_response_code(200); // set response code - 200 OK
 } else {
    http_response_code(404); // set response code - 404 Not found
    $result = array('message' => 'Could not find study');
 }
 break;

    case'POST':
    // get posted data
    $data = json_decode(file_get_contents("php://input"));
    
    // set study property values
    $study->place = $data->place;
    $study->coursename = $data->coursename;
    $study->startedu = $data->startedu;
    $study->stopedu = $data->stopedu;
    
  
    // create the study 
    if($study->create()){  
        // set response code - 201 created
        http_response_code(201);
        // tell the user
        $result = array("message" => "Study was created.");
    }
    // if unable to create the study, tell the user
    else{  
        // set response code - 503 service unavailable
        http_response_code(503);
  
        // tell the user
        $result = array("message" => "Unable to create study.");
    }
    break;

    case'PUT':
        //check if id is set
      if(!isset($id)) {
        http_response_code(510); 
        $result = array('message' => 'An id is needed');
     } else {
            // get id of study to be edited
    $data = json_decode(file_get_contents("php://input"));
  
    // set study property values
    $study->place = $data->place;
    $study->coursename = $data->coursename;
    $study->startedu = $data->startedu;
    $study->stopedu = $data->stopedu;
    
    // update study
    if($study->update($id)){
        // set response code - 200 ok
        http_response_code(200);
        // tell the user
        $result = array("message" => "study was updated.");
    } 
    // if unable to update the study, tell the user
    else{
        // set response code - 503 service unavailable
        http_response_code(503);
    
        // tell the user
        $result = array("message" => "Unable to update study.");
    }
}
    break;

    case 'DELETE':
        //check if id is set
          if(!isset($id)) {
             http_response_code(510); 
             $result = array('message' => 'An id is needed');
          } else {
             if($study->delete($id)) {
                http_response_code(200);  // set response code - 200 ok
                $result = array('message' => 'Study deleted');
             } else {
                http_response_code(503); // set response code - 503 server error
                $result = array('message' => 'Unable to delete study');
             }
          }
          break;

}
// Return result as JSON
echo json_encode($result);
// Close DB connection
$db = $database->close();
?>