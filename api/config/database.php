<?php

//Work-----------------------------------------------------------------------------------------
//id(int, AI, primary key)|company(varchar255)|title(varchar255)|startwork(date)|stopwork(date)
//---------------------------------------------------------------------------------------------
//Study----------------------------------------------------------------------------------------
//id(int, AI, primary key)|place(varchar255)|coursename(varchar255)|startedu(date)|stopedu(date)
//----------------------------------------------------------------------------------------------
//Sites-----------------------------------------------------------------------------------------
//id(int, AI, primary key)|webname(text)|url(text)|description(text)
//----------------------------------------------------------------------------------------------

class Database{
  
    //specify your own database credentials
    private $host = "localhost";
    private $db_name = "dt173g";
    private $username = "dt173g";
    private $password = "password";
    public $conn;

    
    /*private $host ="studentmysql.miun.se";
    private $db_name="mali1910";
    private $username="mali1910";
    private $password="18xu8adm";
    public $conn;*/
  
    // get the database connection
    public function getConnection(){
  
        $this->conn = null;
  
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
  
        return $this->conn;
    }
    public function close()
    {
        $this->conn = null;
    }
}
?>