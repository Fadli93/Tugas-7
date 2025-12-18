<?php
require_once '../config/Database.php';
require_once '../models/Mahasiswa.php';
require_once '../controllers/MahasiswaController.php';

use Controllers\MahasiswaController;

$controller = new MahasiswaController();
$mahasiswa = null;

// Handle actions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['create'])) {
        $controller->create($_POST);
    } elseif (isset($_POST['update'])) {
        $controller->update($_POST);
    }
}

if (isset($_GET['action'])) {
    if ($_GET['action'] == 'delete' && isset($_GET['id'])) {
        $controller->delete($_GET['id']);
    } elseif ($_GET['action'] == 'edit' && isset($_GET['id'])) {
        $mahasiswa = $controller->edit($_GET['id']);
    }
}

$stmt = $controller->index();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Mahasiswa - OOP</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #4CAF50;
        }
        
        .form-container {
            background-color: #f8f9fa;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 30px;
            border: 1px solid #ddd;
        }
        
        .form-title {
            color: #4CAF50;
            margin-bottom: 20px;
            font-size: 1.4em;
        }
        
        .form-group {
            margin-bottom: 20px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        
        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        input[type="text"]:focus,
        input[type="number"]:focus {
            border-color: #4CAF50;
            outline: none;
        }
        
        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        
        .btn-primary {
            background-color: #4CAF50;
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #45a049;
        }
        
        .btn-warning {
            background-color: #ff9800;
            color: white;
        }
        
        .btn-warning:hover {
            background-color: #e68900;
        }
        
        .btn-danger {
            background-color: #f44336;
            color: white;
        }
        
        .btn-danger:hover {
            background-color: #d32f2f;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
        }
        
        tr:hover {
            background-color: #f5f5f5;
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        
        .message {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
            font-weight: bold;
        }
        
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .empty-message {
            text-align: center;
            padding: 40px;
            color: #666;
            font-style: italic;
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }
            
            .form-group {
                grid-template-columns: 1fr;
            }
            
            table {
                display: block;
                overflow-x: auto;
            }
            
            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📚 Aplikasi CRUD Mahasiswa - OOP</h1>
        
        <?php if (isset($_GET['message'])): ?>
            <div class="message success">
                ✅ <?php echo htmlspecialchars($_GET['message']); ?>
            </div>
        <?php endif; ?>
        
        <!-- Form Create/Update -->
        <div class="form-container">
            <h2 class="form-title">
                <?php echo isset($mahasiswa) ? '✏️ Edit Data Mahasiswa' : '➕ Tambah Data Mahasiswa'; ?>
            </h2>
            <form method="POST" action="">
                <?php if (isset($mahasiswa)): ?>
                    <input type="hidden" name="id" value="<?php echo $mahasiswa->id; ?>">
                <?php endif; ?>
                
                <div class="form-group">
                    <div>
                        <label>NIM:</label>
                        <input type="text" name="nim" required 
                               value="<?php echo isset($mahasiswa) ? $mahasiswa->nim : ''; ?>">
                    </div>
                    <div>
                        <label>Nama:</label>
                        <input type="text" name="nama" required
                               value="<?php echo isset($mahasiswa) ? $mahasiswa->nama : ''; ?>">
                    </div>
                    <div>
                        <label>Jurusan:</label>
                        <input type="text" name="jurusan" required
                               value="<?php echo isset($mahasiswa) ? $mahasiswa->jurusan : ''; ?>">
                    </div>
                    <div>
                        <label>Semester:</label>
                        <input type="number" name="semester" min="1" max="14" required
                               value="<?php echo isset($mahasiswa) ? $mahasiswa->semester : ''; ?>">
                    </div>
                </div>
                
                <div>
                    <?php if (isset($mahasiswa)): ?>
                        <button type="submit" name="update" class="btn btn-warning">
                            📤 Update Data
                        </button>
                        <a href="index.php" class="btn" style="background-color: #6c757d; color: white; text-decoration: none; display: inline-block; margin-left: 10px;">
                            ↩️ Batal
                        </a>
                    <?php else: ?>
                        <button type="submit" name="create" class="btn btn-primary">
                            ✅ Simpan Data
                        </button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
        
        <!-- Table Data Mahasiswa -->
        <h2 style="color: #333; margin-top: 30px;">📋 Daftar Mahasiswa</h2>
        
        <?php if ($stmt->rowCount() > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Jurusan</th>
                        <th>Semester</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)): 
                    ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo htmlspecialchars($row['nim']); ?></td>
                            <td><?php echo htmlspecialchars($row['nama']); ?></td>
                            <td><?php echo htmlspecialchars($row['jurusan']); ?></td>
                            <td><?php echo htmlspecialchars($row['semester']); ?></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="index.php?action=edit&id=<?php echo $row['id']; ?>" 
                                       class="btn btn-warning" style="padding: 8px 15px;">
                                       ✏️ Edit
                                    </a>
                                    <a href="index.php?action=delete&id=<?php echo $row['id']; ?>" 
                                       class="btn btn-danger" style="padding: 8px 15px;"
                                       onclick="return confirm('Yakin ingin menghapus data ini?')">
                                       🗑️ Hapus
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-message">
                <p>📭 Tidak ada data mahasiswa. Silahkan tambah data baru.</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>