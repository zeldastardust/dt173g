<?php

//Headers
header("Access-Control-Allow-Origin:*");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// include database and object files
include_once './config/database.php';
include_once './objects/Work.php';

// variable for request method
$method = $_SERVER['REQUEST_METHOD'];

// check if id is set
if(isset($_GET['id'])) {
   $id = $_GET['id'] != '' ? $_GET['id'] : null;
}
// instantiate database and work object
$database = new Database();
$db = $database->getConnection();

// initialize object
$work = new Work($db);

//switch for requests
switch($method) {
   case 'GET':
      if(isset($id)) {
        $result = $work->readOne($id);         
      } else {
        $result = $work->read();
      }
      // check if more than 0 record found
      if(sizeof($result) > 0) {
         http_response_code(200); // set response code - 200 OK
      } else {
         http_response_code(404); // set response code - 404 Not found
         $result = array('message' => 'Could not find work');
      }
      break;
   case 'POST':
    // get posted data
      $data = json_decode(file_get_contents('php://input'));
 
       // set work property values
      $work->company = $data->company;
      $work->title = $data->title;
      $work->startwork = $data->startwork;
      $work->stopwork = $data->stopwork;

      // create the work
      if($work->create()) {
         http_response_code(201); // set response code - 201 created
         $result = array('message' => 'Work created');
      } else {
         http_response_code(503); // set response code - 503 server error
         $result = array('message' => 'Could not create work');
      }
      break;
   case 'PUT':
    //check if id is set
      if(!isset($id)) {
         http_response_code(510); 
         $result = array('message' => 'An id is needed');
      } else {
          // get id of work to be edited
         $data = json_decode(file_get_contents('php://input'));

         // set work property values
         $work->company = $data->company;
         $work->title = $data->title;
         $work->startwork = $data->startwork;
         $work->stopwork = $data->stopwork;

         // update work
         if($work->update($id)) {
            http_response_code(200);  // set response code - 200 ok
            $result = array('message' => 'Work updated');
         } else {
            http_response_code(503); // set response code - 503 server error
            $result = array('message' => 'Could not update work');
         }
      }
      break;
   case 'DELETE':

    //check if id is set
      if(!isset($id)) {
         http_response_code(510); 
         $result = array('message' => 'An id is needed');
      } else {
         if($work->delete($id)) {
            http_response_code(200);  // set response code - 200 ok
            $result = array('message' => 'Work deleted');
         } else {
            http_response_code(503); // set response code - 503 server error
            $result = array('message' => 'Unable to delete work');
         }
      }
      break;
}

// Return result as JSON
echo json_encode($result);

// Close DB connection
$db = $database->close();
?>