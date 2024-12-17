<?php
// Memulai sesi
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Jika belum login, alihkan ke halaman login
    exit();
}

// Pastikan file koneksi.php terhubung dengan benar
include 'koneksi.php';
if (!$conn) {
    die("Koneksi ke database gagal."); // Debugging jika koneksi tidak tersedia
}

// Proses pencarian data
$search = '';
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
    $search = $_GET['search'];
}

// Proses hapus data
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $query = "DELETE FROM pendaftaran WHERE id_pendaftaran = ?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            header("Location: admin.php"); // Redirect setelah delete
            exit();
        } else {
            echo "Gagal menghapus data. Pesan error: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Fetch data untuk tampilan
$query = "SELECT p.*, k.nama_kategori FROM pendaftaran p INNER JOIN kategori k ON p.id_kategori = k.id_kategori";
if ($search) {
    $query .= " WHERE p.nama_lengkap LIKE ? OR p.email LIKE ? OR p.alamat LIKE ? OR k.nama_kategori LIKE ?";
    $search_param = "%" . $search . "%";
}

// Eksekusi query
if ($stmt = $conn->prepare($query)) {
    if ($search) {
        $stmt->bind_param("ssss", $search_param, $search_param, $search_param, $search_param);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} else {
    die("Query gagal disiapkan: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Pendaftaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        header {
            background: white;
            padding: 10px;
        }
        header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header a {
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 4px;
        }
        header a.btn-primary {
            background-color: #0056b3;
        }
        .container {
            width: 90%;
            margin: 20px auto;
        }
        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 4px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
        }
        .form-container input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-container input[type="submit"] {
            background: linear-gradient(135deg, #f06292, #9c27b0);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-container input[type="submit"]:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 14px; /* Perkecil ukuran font tabel */
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
        th {
            background: linear-gradient(135deg, #f06292, #9c27b0);
            color: white;
        }
        td img {
            max-width: 80px; /* Perkecil ukuran gambar */
            border-radius: 4px;
        }
        .btn-primary {
            background: linear-gradient(135deg, #f06292, #9c27b0);
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 4px;
            border: none;
            margin-right: 55px; /* Memberikan jarak kanan */
            margin-bottom: 5px; /* Memberikan jarak bawah */
        }
        .btn-danger {
            background-color: #dc3545;
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 4px;
            border: none;
            margin-left: 55px; /* Memberikan jarak kiri */
            margin-bottom: 5px; /* Memberikan jarak bawah */
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-danger:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <a href="index.php" class="btn btn-primary">Beranda</a>
            <a href="tambah.php" class="btn btn-primary">Tambah Data</a>
        </div>
    </header>

    <div class="container">
        <div class="form-container">
            <h2>Daftar Pendaftaran</h2>
            
            <!-- Form Pencarian -->
            <form method="GET" action="">
                <input type="text" name="search" value="<?= htmlspecialchars($search); ?>" placeholder="Cari berdasarkan nama, email, alamat atau kategori">
                <input type="submit" value="Cari" class="btn btn-primary">
            </form>
            
            <!-- Tabel untuk menampilkan data -->
            <?php if (!empty($data)): ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Tanggal Lahir</th>
                            <th>Alamat</th>
                            <th>Kategori</th>
                            <th>Telepon</th>
                            <th>Keahlian</th>
                            <th>Pengalaman Lomba</th>
                            <th>Foto</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $row): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['id_pendaftaran']); ?></td>
                                <td><?= htmlspecialchars($row['nama_lengkap']); ?></td>
                                <td><?= htmlspecialchars($row['email']); ?></td>
                                <td><?= htmlspecialchars($row['tanggal_lahir']); ?></td>
                                <td><?= htmlspecialchars($row['alamat']); ?></td>
                                <td><?= htmlspecialchars($row['nama_kategori']); ?></td>
                                <td><?= htmlspecialchars($row['telepon']); ?></td>
                                <td><?= htmlspecialchars($row['keahlian']); ?></td>
                                <td><?= htmlspecialchars($row['pengalaman_lomba']); ?></td>
                                <td><img src="uploads/<?= htmlspecialchars($row['foto_diri']); ?>" alt="Foto" width="80"></td>
                                <td>
                                    <a href="edit.php?id=<?= htmlspecialchars($row['id_pendaftaran']); ?>" class="btn btn-primary">Edit</a>
                                    <a href="?delete=<?= htmlspecialchars($row['id_pendaftaran']); ?>" class="btn btn-danger">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Tidak ada data pendaftaran yang ditemukan.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
