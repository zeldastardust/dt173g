<?php
class Sites{
  
    // database connection and table name
    private $conn;
    private $table_name = "sites";
  
    // object properties
    public $id;
    public $webname;
    public $url;
    public $description;
    
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read sites
 function read(){
  
    // select all query
    $query = "SELECT *
            FROM
                " . $this->table_name ;
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // execute query
    $stmt->execute();
    $num = $stmt->rowCount();
  
    // check if more than 0 record found
    if ($num > 0) {
        //array site objects
      $data = array();
       $data['sitelist'] = array();
      // $data['itemCount'] = $num;

       // retrieve the table contents
       while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          // extract data from row to variables
          extract($row); 
          $site = array(
             'id' => $id,
             'webname' => $webname,
             'url' => $url,
             'description' => $description
             
          );

          array_push($data['sitelist'], $site);
       }
    }

    return $data;
 }
// create sites
function create(){
  
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                webname=:webname, url=:url, description=:description";
  
    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->webname=htmlspecialchars(strip_tags($this->webname));
    $this->url=htmlspecialchars(strip_tags($this->url));
    $this->description=htmlspecialchars(strip_tags($this->description));
   
    // bind values
    $stmt->bindParam(":webname", $this->webname);
    $stmt->bindParam(":url", $this->url);
    $stmt->bindParam(":description", $this->description);
    
    // execute query
    if($stmt->execute()){
        return true;
    }
    return false;     
}

function readOne($id){  
    // query to read single record
    $query = "SELECT
                *
            FROM
                " . $this->table_name . "
            WHERE
                id = ". $id."
            LIMIT
                1";
  
    // prepare query statement
    $stmt = $this->conn->prepare( $query );
  
  
    // execute query
    $stmt->execute();
  
    // get retrieved row
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
  
    if(!$data) {
        $data = array();
     }

     return $data;

  }
// update site function
function update($id){
  
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                webname = :webname,
                url = :url,
                description = :description
                
            WHERE
                id = :id";
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->webname=htmlspecialchars(strip_tags($this->webname));
    $this->url=htmlspecialchars(strip_tags($this->url));
    $this->description=htmlspecialchars(strip_tags($this->description));
    $this->id=htmlspecialchars(strip_tags($id));
  
    // bind new values
    $stmt->bindParam(':webname', $this->webname);
    $stmt->bindParam(':url', $this->url);
    $stmt->bindParam(':description', $this->description);
    $stmt->bindParam(':id', $this->id);
  
    // execute the query
    if($stmt->execute()){
        return true;
    }
  
    return false;
}
// delete the site
function delete($id){
  
    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE id =:id";
  
    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->id=htmlspecialchars(strip_tags($id));
  
    // bind id of record to delete
    $stmt->bindParam(':id', $this->id);
    // execute query
    if($stmt->execute()){
        return true;
    }
  
    return false;
}
}
?>
