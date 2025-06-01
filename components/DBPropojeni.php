<?php
class Database {
    private $servername = "sql112.infinityfree.com";
    private $username = "if0_39112415";
    private $password = "tqMybSA7gTBC5s";
    private $database = "if0_39112415_vinyldatabase";
    private $conn;

    public function __construct() {
        $this->conn = new mysqli(
            $this->servername, 
            $this->username, 
            $this->password, 
            $this->database
        );

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }


        $this->conn->set_charset("utf8");
    }

    public function getConnection() {
        return $this->conn;
    }

    public function closeConnection() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
?>
