<?php
class Work{
  
    // database connection and table name
    private $conn;
    private $table_name = "work";
  
    // object properties
    public $id;
    public $company;
    public $title;
    public $startwork;
    public $stopwork;
    
  
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read work
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
// create work
function create(){
  
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                company=:company, title=:title, startwork=:startwork, stopwork=:stopwork";
  
    // prepare query
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->company=htmlspecialchars(strip_tags($this->company));
    $this->title=htmlspecialchars(strip_tags($this->title));
    $this->startwork=htmlspecialchars(strip_tags($this->startwork));
    $this->stopwork=htmlspecialchars(strip_tags($this->stopwork));
    
  
    // bind values
    $stmt->bindParam(":company", $this->company);
    $stmt->bindParam(":title", $this->title);
    $stmt->bindParam(":startwork", $this->startwork);
    $stmt->bindParam(":stopwork", $this->stopwork);
    
  
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
  
    // bind id of work to be updated
    $stmt->bindParam(1, $this->id);
  
    // execute query
    $stmt->execute();
  
    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
  
    // set values to object properties
    $this->company = $row['company'];
    $this->title = $row['title'];
    $this->startwork = $row['startwork'];
    $this->stopwork = $row['stopwork'];
}
// update the work
function update(){
  
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                company = :company,
                title = :title,
                startwork = :startwork,
                stopwork = :stopwork
            WHERE
                id = :id";
  
    // prepare query statement
    $stmt = $this->conn->prepare($query);
  
    // sanitize
    $this->company=htmlspecialchars(strip_tags($this->company));
    $this->title=htmlspecialchars(strip_tags($this->title));
    $this->startwork=htmlspecialchars(strip_tags($this->startwork));
    $this->stopwork=htmlspecialchars(strip_tags($this->stopwork));
    $this->id=htmlspecialchars(strip_tags($this->id));
  
    // bind new values
    $stmt->bindParam(':company', $this->company);
    $stmt->bindParam(':title', $this->title);
    $stmt->bindParam(':startwork', $this->startwork);
    $stmt->bindParam(':stopwork', $this->stopwork);
    $stmt->bindParam(':id', $this->id);
  
    // execute the query
    if($stmt->execute()){
        return true;
    }
  
    return false;
}
// delete the work
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
