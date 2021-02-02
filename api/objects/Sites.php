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
  
    return $stmt;
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
  
    // bind id of sites to be updated
    $stmt->bindParam(1, $this->id);
  
    // execute query
    $stmt->execute();
  
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
  
    // set values to object properties
    $this->webname = $row['webname'];
    $this->url = $row['url'];
    $this->description = $row['description'];
    
}
// update the site
function update(){
  
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
    $this->id=htmlspecialchars(strip_tags($this->id));
  
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
function delete(){
  
    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
  
    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->id=htmlspecialchars(strip_tags($this->id));
  
    // bind id of record to delete
    $stmt->bindParam(1, $this->id);
  
    // execute query
    if($stmt->execute()){
        return true;
    }
  
    return false;
}
}
?>
