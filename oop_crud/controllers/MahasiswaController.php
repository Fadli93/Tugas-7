<?php
namespace Controllers;

use Models\Mahasiswa;

class MahasiswaController {
    private $model;
    
    public function __construct() {
        $this->model = new Mahasiswa();
    }
    
    public function index() {
        $stmt = $this->model->read();
        return $stmt;
    }
    
    public function create($data) {
        $this->model->nim = $data['nim'];
        $this->model->nama = $data['nama'];
        $this->model->jurusan = $data['jurusan'];
        $this->model->semester = $data['semester'];
        
        if ($this->model->create()) {
            header("Location: index.php?message=Data berhasil ditambahkan");
            exit();
        }
    }
    
    public function edit($id) {
        $this->model->id = $id;
        $this->model->readOne();
        return $this->model;
    }
    
    public function update($data) {
        $this->model->id = $data['id'];
        $this->model->nim = $data['nim'];
        $this->model->nama = $data['nama'];
        $this->model->jurusan = $data['jurusan'];
        $this->model->semester = $data['semester'];
        
        if ($this->model->update()) {
            header("Location: index.php?message=Data berhasil diupdate");
            exit();
        }
    }
    
    public function delete($id) {
        $this->model->id = $id;
        
        if ($this->model->delete()) {
            header("Location: index.php?message=Data berhasil dihapus");
            exit();
        }
    }
}
?>