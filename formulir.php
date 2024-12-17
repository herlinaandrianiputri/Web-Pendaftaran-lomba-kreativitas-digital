<?php
// Memulai sesi
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Jika belum login, alihkan ke halaman login
    exit();
}

// Koneksi ke database
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'lombakreatifitasdigital_';

$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

// Ambil data kategori dari tabel
$query = "SELECT id_kategori, nama_kategori FROM kategori";
$result = $conn->query($query);

// Siapkan array untuk kategori
$kategori_options = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $kategori_options[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Pendaftaran - Lomba Kreativitas Digital</title>
    <style>
        /* Gaya CSS */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 18px;
        }

        header {
            text-align: center;
            padding: 10px 0;
            background: linear-gradient(135deg, #f06292, #9c27b0);
            color: #fff;
            margin-bottom: 20px;
            border-radius: 8px;
        }

        h1 {
            font-size: 24px;
            margin: 0;
        }

        .form-group {
            margin-bottom: 10px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 90%;
            padding: 10px;
            margin: 2px 0 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        .form-group input[type="submit"] {
            display: block;
            width: 150px;
            margin: 0 auto;
            background-color: white;
            color: #007bff;
            text-align: center;
            font-size: 1.2rem;
            font-weight: bold;
            border-radius: 25px;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
        }

        .form-group input[type="submit"]:hover {
            background: linear-gradient(135deg, #f06292, #9c27b0);
            color: white;
            transform: scale(1.05);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Formulir Pendaftaran</h1>
        </header>

        <form action="proses_form.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap</label>
                <input type="text" id="nama" name="nama_lengkap" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="tanggal_lahir">Tanggal Lahir</label>
                <input type="date" id="tanggal_lahir" name="tanggal_lahir" required>
            </div>
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" id="alamat" name="alamat" required>
            </div>
            <div class="form-group">
                <label for="nama_kategori">Kategori</label>
                <select id="nama_kategori" name="id_kategori" required>
                    <option value="">-- Pilih Kategori --</option>
                    <?php foreach ($kategori_options as $kategori): ?>
                        <option value="<?= htmlspecialchars($kategori['id_kategori']); ?>">
                            <?= htmlspecialchars($kategori['nama_kategori']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="telepon">Nomor Telepon</label>
                <input type="tel" id="telepon" name="telepon" required>
            </div>
            <div class="form-group">
                <label for="keahlian">Keahlian</label>
                <input type="text" id="keahlian" name="keahlian" required>
            </div>
            <div class="form-group">
                <label for="pengalaman_lomba">Pengalaman Lomba</label>
                <textarea id="pengalaman_lomba" name="pengalaman_lomba" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="foto_diri">Foto Diri</label>
                <input type="file" id="foto_diri" name="foto_diri" accept="image/*" required>
            </div>

            <div class="form-group">
                <input type="submit" value="Daftar">
            </div>
        </form>
    </div>
</body>
</html>
