<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// include database and object files
include_once './config/database.php';
include_once './objects/Work.php';
  
// instantiate database and work object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$work = new Work($db);

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
        // query work
        $stmt = $work->read();
        $num = $stmt->rowCount();
  
        // check if more than 0 record found
        if($num>0){  
            // work array
            $work_arr=array();
            $work_arr["records"]=array(); 
            // retrieve our table contents
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                // extract row
                // this will make $row['name'] to
                // just $name only
                extract($row); 
                $work_item=array(
                    "id" => $id,
                    "company" => $company,
                    "title" => $title,
                    "startwork" => $startwork,
                    "stopwork" => $stopwork
                    
                );  
                array_push($work_arr["records"], $work_item);
                }
            // set response code - 200 OK
            http_response_code(200); 
            // show work data in json format
            echo json_encode($work_arr);
            }  
        else{  
            // set response code - 404 Not found
            http_response_code(404);
    
            // tell the user no work found
            echo json_encode(
            array("message" => "No works found.")
            );
            } 
       }else{
            // set ID property of record to read
            //$work->id = isset($_GET['id']) ? $_GET['id'] : die();
            $work->readOne($id);
  
            if($work->company!=null){
                // create array
                $work_arr = array(
                    "id" =>  $work->id,
                    "company" => $work->company,
                    "title" => $work->title,
                    "startwork" => $work->startwork,
                    "stopwork" => $work->stopwork
                  
                );
            
                // set response code - 200 OK
                http_response_code(200);
            
                // make it json format
                echo json_encode($work_arr);
            }
            
            else{
                // set response code - 404 Not found
                http_response_code(404);
            
                // tell the user product does not exist
                echo json_encode(array("message" => "Work does not exist."));
            }
                       // echo " id satt";
        }
    break;

    case'POST':
    // get posted data
    $data = json_decode(file_get_contents("php://input"));
  
    // make sure data is not empty
    if(
    !empty($data->company) &&
    !empty($data->title) &&
    !empty($data->startwork) &&
    !empty($data->stopwork)
    ){
  
    // set product property values
    $work->company = $data->company;
    $work->title = $data->title;
    $work->startwork = $data->startwork;
    $work->stopwork = $data->stopwork;
    
  
    // create the product
    if($work->create()){
  
        // set response code - 201 created
        http_response_code(201);
  
        // tell the user
        echo json_encode(array("message" => "Work was created."));
    }
  
    // if unable to create the work, tell the user
    else{
  
        // set response code - 503 service unavailable
        http_response_code(503);
  
        // tell the user
        echo json_encode(array("message" => "Unable to create work."));
    }
    }
  
    // tell the user data is incomplete
    else{
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the user
    echo json_encode(array("message" => "Unable to create work. Data is incomplete."));
    }
    break;

    case'PUT':
            // get id of work to be edited
    $data = json_decode(file_get_contents("php://input"));
    
    // set ID property of product to be edited
    $work->id = $data->id;
    
    // set product property values
    $work->company = $data->company;
    $work->title = $data->title;
    $work->startwork = $data->startwork;
    $work->stopwork = $data->stopwork;
    
    // update the product
    if($work->update()){
    
        // set response code - 200 ok
        http_response_code(200);
    
        // tell the user
        echo json_encode(array("message" => "work was updated."));
    }
    
    // if unable to update the work, tell the user
    else{
    
        // set response code - 503 service unavailable
        http_response_code(503);
    
        // tell the user
        echo json_encode(array("message" => "Unable to update work."));
    }
    break;

    case 'DELETE':
        // get work id
    $data = json_decode(file_get_contents("php://input"));
    
    // set work id to be deleted
    $work->id = $id;
    
    // delete the work
    if($work->delete()){
    
        // set response code - 200 ok
        http_response_code(200);
    
        // tell the user
        echo json_encode(array("message" => "work was deleted."));
    }
    
    // if unable to delete the work
    else{
    
        // set response code - 503 service unavailable
        http_response_code(503);
    
        // tell the user
        echo json_encode(array("message" => "Unable to delete work."));
    }
    break;

}
// Close DB connection
$db = $database->close();
?>
