<?php
class Work {
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
   public function __construct($db) {
      $this->conn = $db;
   }

   // read work
   public function read() {
       // select all query
      $query = 'SELECT * FROM ' . $this->table_name;
       // prepare query statement
      $stmt = $this->conn->prepare($query);
       // execute query
      $stmt->execute();
      $num = $stmt->rowCount();

     
    // check if more than 0 record found
      if ($num > 0) {
          //array work objects
        $data = array();
         $data['worklist'] = array();
        // $data['itemCount'] = $num;

         // retrieve the table contents
         while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // extract data from row to variables
            extract($row); 
            $work = array(
               'id' => $id,
               'company' => $company,
               'title' => $title,
               'startwork' => $startwork,
               'stopwork' => $stopwork
            );

            array_push($data['worklist'], $work);
         }
      }

      return $data;
   }

   // read one object
   public function readOne($id) {
       // query to read single object
      $query = 'SELECT * FROM ' . $this->table_name . ' WHERE id = ' . $id . ' LIMIT 1';
       
      // prepare query statement
      $stmt = $this->conn->prepare($query);
      
      // execute query
      $stmt->execute();

       // get retrieved row
      $data = $stmt->fetch(PDO::FETCH_ASSOC);

      if(!$data) {
         $data = array();
      }

      return $data;

   }

   // CREATE
   public function create() {

    // query to insert work object
      $query = 'INSERT INTO 
                  ' . $this->table_name . '
               SET
                  company = :company,
                  title = :title,
                  startwork = :startwork,
                  stopwork = :stopwork';

    // prepare query
      $stmt = $this->conn->prepare($query);
      
      // Sanitize input
      $this->company = htmlspecialchars(strip_tags($this->company));
      $this->title = htmlspecialchars(strip_tags($this->title));
      $this->startwork = htmlspecialchars(strip_tags($this->startwork));
      $this->stopwork = htmlspecialchars(strip_tags($this->stopwork));

      // Bind values
      $stmt->bindParam(':company', $this->company);
      $stmt->bindParam(':title', $this->title);
      $stmt->bindParam(':startwork', $this->startwork);
      $stmt->bindParam(':stopwork', $this->stopwork);

      // execute query
      if($stmt->execute()) {
         return true;
      }

      return false;
   }
   
   //update Work function
   public function update($id) {

    // update query
      $query = 'UPDATE 
                  ' . $this->table_name . '
               SET
                  company = :company,
                  title = :title,
                  startwork = :startwork,
                  stopwork = :stopwork
               WHERE
                  id = :id';

      // prepare query statement
      $stmt = $this->conn->prepare($query);

      // Sanitize input
      $this->id = htmlspecialchars(strip_tags($id));
      $this->company = htmlspecialchars(strip_tags($this->company));
      $this->title = htmlspecialchars(strip_tags($this->title));
      $this->startwork = htmlspecialchars(strip_tags($this->startwork));
      $this->stopwork = htmlspecialchars(strip_tags($this->stopwork));

      // Bind new values
      $stmt->bindParam(':id', $this->id);
      $stmt->bindParam(':company', $this->company);
      $stmt->bindParam(':title', $this->title);
      $stmt->bindParam(':startwork', $this->startwork);
      $stmt->bindParam(':stopwork', $this->stopwork);

       // execute the query
      if($stmt->execute()) {
         return true;
      }

      return false;
   }

  // delete the work
   public function delete($id) {

     // delete query
      $query = 'DELETE FROM
                  ' . $this->table_name . '
               WHERE
                  id = :id';

    // prepare query
      $stmt = $this->conn->prepare($query);

      // Sanitize input
      $this->id = htmlspecialchars(strip_tags($id));

      // bind id of record to delete
      $stmt->bindParam(':id', $this->id);

    // execute query
      if($stmt->execute()) {
         return true;
      }

      return false;
   }
}
