<?php
namespace Models;

use Config\Database;

class Mahasiswa {
    private $conn;
    private $table = 'mahasiswa';
    
    public $id;
    public $nim;
    public $nama;
    public $jurusan;
    public $semester;
    
    public function __construct() {
        $database = Database::getInstance();
        $this->conn = $database->getConnection();
    }
    
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                 SET nim = :nim, nama = :nama, 
                     jurusan = :jurusan, semester = :semester";
        
        $stmt = $this->conn->prepare($query);
        
        $this->nim = htmlspecialchars(strip_tags($this->nim));
        $this->nama = htmlspecialchars(strip_tags($this->nama));
        $this->jurusan = htmlspecialchars(strip_tags($this->jurusan));
        $this->semester = htmlspecialchars(strip_tags($this->semester));
        
        $stmt->bindParam(':nim', $this->nim);
        $stmt->bindParam(':nama', $this->nama);
        $stmt->bindParam(':jurusan', $this->jurusan);
        $stmt->bindParam(':semester', $this->semester);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    public function read() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
    
    public function readOne() {
        $query = "SELECT * FROM " . $this->table . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        $this->nim = $row['nim'];
        $this->nama = $row['nama'];
        $this->jurusan = $row['jurusan'];
        $this->semester = $row['semester'];
    }
    
    public function update() {
        $query = "UPDATE " . $this->table . "
                 SET nim = :nim, nama = :nama, 
                     jurusan = :jurusan, semester = :semester
                 WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $this->nim = htmlspecialchars(strip_tags($this->nim));
        $this->nama = htmlspecialchars(strip_tags($this->nama));
        $this->jurusan = htmlspecialchars(strip_tags($this->jurusan));
        $this->semester = htmlspecialchars(strip_tags($this->semester));
        $this->id = htmlspecialchars(strip_tags($this->id));
        
        $stmt->bindParam(':nim', $this->nim);
        $stmt->bindParam(':nama', $this->nama);
        $stmt->bindParam(':jurusan', $this->jurusan);
        $stmt->bindParam(':semester', $this->semester);
        $stmt->bindParam(':id', $this->id);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>