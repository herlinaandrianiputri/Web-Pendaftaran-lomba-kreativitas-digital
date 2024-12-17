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

// Fetch semua data pendaftaran
$query = "SELECT p.*, k.nama_kategori FROM pendaftaran p 
          INNER JOIN kategori k ON p.id_kategori = k.id_kategori";
$result = $conn->query($query);
$data = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];

// Proses unduh laporan
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['download'])) {
        $query = "SELECT p.*, k.nama_kategori FROM pendaftaran p 
                  INNER JOIN kategori k ON p.id_kategori = k.id_kategori";
        $result = $conn->query($query);

        if ($result) {
            $data = $result->fetch_all(MYSQLI_ASSOC);

            // Buat file CSV
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment;filename="laporan_pendaftaran.csv"');

            $output = fopen('php://output', 'w');
            fputcsv($output, ['ID', 'Nama Lengkap', 'Email', 'Tanggal Lahir', 'Alamat', 'Kategori', 'Telepon', 'Keahlian', 'Pengalaman Lomba', 'Foto']);
            
            foreach ($data as $row) {
                fputcsv($output, [
                    $row['id_pendaftaran'],
                    $row['nama_lengkap'],
                    $row['email'],
                    $row['tanggal_lahir'],
                    $row['alamat'],
                    $row['nama_kategori'],
                    $row['telepon'],
                    $row['keahlian'],
                    $row['pengalaman_lomba'],
                    $row['foto_diri']
                ]);
            }

            fclose($output);
            exit();
        } else {
            die("Gagal membuat laporan: " . $conn->error);
        }
    }

    if (isset($_POST['print'])) {
        echo "<script>window.print();</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pimpinan - Laporan Pendaftaran</title>
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
            background: linear-gradient(135deg, #f06292, #9c27b0); /* Tema warna linear gradient */
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 4px;
            display: inline-block;
            transition: background-color 0.3s ease; /* Tambahkan efek transisi */
        }
        header a.btn-primary:hover {
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
        .form-container input[type="submit"] {
            width: 30%;
            padding: 8px;
            margin-bottom: 10px;
            border: none;
            border-radius: 7px;
            background: linear-gradient(135deg, #f06292, #9c27b0); /* Sesuaikan warna sesuai tema */
            color: white;
            cursor: pointer;
            display: inline-block;
            margin-right: 10px;
            transition: background-color 0.3s ease; /* Tambahkan efek transisi */
        }
        .form-container input[type="submit"]:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background: linear-gradient(135deg, #f06292, #9c27b0);
            color: white;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <a href="index.php" class="btn btn-primary">Beranda</a>
        </div>
    </header>

    <div class="container">
        <div class="form-container">
            <h2>Pimpinan - Laporan Pendaftaran</h2>
            
            <!-- Form untuk mengunduh dan mencetak laporan -->
            <form method="POST" action="">
                <input type="submit" name="download" value="Unduh Laporan Pendaftaran" class="btn btn-primary">
                <input type="submit" name="print" value="Cetak Laporan" class="btn btn-primary">
            </form>
            
            <!-- Tabel untuk menampilkan data -->
            <?php if (!empty($data)): ?>
                <table>
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
                                <td><img src="uploads/<?= htmlspecialchars($row['foto_diri']); ?>" alt="Foto" width="100"></td>
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
