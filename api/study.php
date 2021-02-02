<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  
// include database and object files
include_once './config/database.php';
include_once './objects/Study.php';
  
// instantiate database and study object
$database = new Database();
$db = $database->getConnection();
  
// initialize object
$study = new Study($db);

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
        // query study
        $stmt = $study->read();
        $num = $stmt->rowCount();
  
        // check if more than 0 record found
        if($num>0){  
            // study array
            $study_arr=array();
            $study_arr["records"]=array(); 
            // retrieve our table contents
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                // extract row
                // this will make $row['name'] to
                // just $name only
                extract($row); 
                $study_item=array(
                    "id" => $id,
                    "place" => $place,
                    "coursename" => $coursename,
                    "startedu" => $startedu,
                    "stopedu" => $stopedu
                    
                );  
                array_push($study_arr["records"], $study_item);
                }
            // set response code - 200 OK
            http_response_code(200); 
            // show work data in json format
            echo json_encode($study_arr);
            }  
        else{  
            // set response code - 404 Not found
            http_response_code(404);
    
            // tell the user no studies found
            echo json_encode(
            array("message" => "No studies found.")
            );
            } 
       }else{
            // set ID property of record to read
            //$work->id = isset($_GET['id']) ? $_GET['id'] : die();
            $study->readOne($id);
  
            if($study->place!=null){
                // create array
                $study_arr = array(
                    "id" =>  $study->id,
                    "place" => $study->place,
                    "coursename" => $study->coursename,
                    "startedu" => $study->startedu,
                    "stopedu" => $study->stopedu
                  
                );
            
                // set response code - 200 OK
                http_response_code(200);
            
                // make it json format
                echo json_encode($study_arr);
            }
            
            else{
                // set response code - 404 Not found
                http_response_code(404);
            
                // tell the user study does not exist
                echo json_encode(array("message" => "study does not exist."));
            }
                       // echo " id satt";
        }
    break;

    case'POST':
    // get posted data
    $data = json_decode(file_get_contents("php://input"));
  
    // make sure data is not empty
    if(
    !empty($data->place) &&
    !empty($data->coursename) &&
    !empty($data->startedu) &&
    !empty($data->stopedu)
    ){
  
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
        echo json_encode(array("message" => "Study was created."));
    }
  
    // if unable to create the study, tell the user
    else{
  
        // set response code - 503 service unavailable
        http_response_code(503);
  
        // tell the user
        echo json_encode(array("message" => "Unable to create study."));
    }
    }
  
    // tell the user data is incomplete
    else{
  
    // set response code - 400 bad request
    http_response_code(400);
  
    // tell the user
    echo json_encode(array("message" => "Unable to create study. Data is incomplete."));
    }
    break;

    case'PUT':
            // get id of study to be edited
    $data = json_decode(file_get_contents("php://input"));
    
    // set ID property of study to be edited
    $study->id = $data->id;
    
    // set study property values
    $study->place = $data->place;
    $study->coursename = $data->coursename;
    $study->startedu = $data->startedu;
    $study->stopedu = $data->stopedu;
    
    // update study
    if($study->update()){
    
        // set response code - 200 ok
        http_response_code(200);
    
        // tell the user
        echo json_encode(array("message" => "study was updated."));
    }
    
    // if unable to update the study, tell the user
    else{
    
        // set response code - 503 service unavailable
        http_response_code(503);
    
        // tell the user
        echo json_encode(array("message" => "Unable to update study."));
    }
    break;

    case 'DELETE':
        // get study id
    $data = json_decode(file_get_contents("php://input"));
    
    // set study id to be deleted
    $study->id = $id;
    
    // delete the study
    if($study->delete()){
    
        // set response code - 200 ok
        http_response_code(200);
    
        // tell the user
        echo json_encode(array("message" => "study was deleted."));
    }
    
    // if unable to delete the study
    else{
    
        // set response code - 503 service unavailable
        http_response_code(503);
    
        // tell the user
        echo json_encode(array("message" => "Unable to delete study."));
    }
    break;

}
// Close DB connection
$db = $database->close();
?>