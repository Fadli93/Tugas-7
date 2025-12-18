<?php
namespace Config;

class Database {
    private static $instance = null;
    private $conn;
    
    private $host = "localhost";
    // private $host = "127.0.0.1:3307";
    private $user = "root";
    private $pass = "123";
    private $dbname = "db_mahasiswa";
    
    private function __construct() {
        try {
            $this->conn = new \PDO(
                "mysql:host={$this->host};dbname={$this->dbname}",
                $this->user,
                $this->pass
            );
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
    
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->conn;
    }
}
?>