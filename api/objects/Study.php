<?php
class Study{
  
    // database connection and table name
    private $conn;
    private $table_name = "study";
  
    // object properties
    public $id;
    public $place;
    public $coursename;
    public $startedu;
    public $stopedu;
    
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read studies
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
// create studies
function create(){
  
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                place=:place, coursename=:coursename, startedu=:startedu, stopedu=:stopedu";
  
    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->place=htmlspecialchars(strip_tags($this->place));
    $this->coursename=htmlspecialchars(strip_tags($this->coursename));
    $this->startedu=htmlspecialchars(strip_tags($this->startedu));
    $this->stopedu=htmlspecialchars(strip_tags($this->stopedu));
    
  
    // bind values
    $stmt->bindParam(":place", $this->place);
    $stmt->bindParam(":coursename", $this->coursename);
    $stmt->bindParam(":startedu", $this->startedu);
    $stmt->bindParam(":stopedu", $this->stopedu);
    
  
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
  
    // bind id of studies to be updated
    $stmt->bindParam(1, $this->id);
  
    // execute query
    $stmt->execute();
  
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
  
    // set values to object properties
    $this->place = $row['place'];
    $this->coursename = $row['coursename'];
    $this->startedu = $row['startedu'];
    $this->stopedu = $row['stopedu'];
}
// update the study
function update(){
  
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                place = :place,
                coursename = :coursename,
                startedu = :startedu,
                stopedu = :stopedu
            WHERE
                id = :id";
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->place=htmlspecialchars(strip_tags($this->place));
    $this->coursename=htmlspecialchars(strip_tags($this->coursename));
    $this->startedu=htmlspecialchars(strip_tags($this->startedu));
    $this->stopedu=htmlspecialchars(strip_tags($this->stopedu));
    $this->id=htmlspecialchars(strip_tags($this->id));
  
    // bind new values
    $stmt->bindParam(':place', $this->place);
    $stmt->bindParam(':coursename', $this->coursename);
    $stmt->bindParam(':startedu', $this->startedu);
    $stmt->bindParam(':stopedu', $this->stopedu);
    $stmt->bindParam(':id', $this->id);
  
    // execute the query
    if($stmt->execute()){
        return true;
    }
  
    return false;
}
// delete the study
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
