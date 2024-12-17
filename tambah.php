<?php
// Koneksi ke database
require_once 'koneksi.php';

// Ambil data kategori untuk dropdown
$queryKategori = "SELECT id_kategori, nama_kategori FROM kategori";
$resultKategori = $conn->query($queryKategori);
$kategori_options = $resultKategori->fetch_all(MYSQLI_ASSOC);

// Proses penyimpanan data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_lengkap = $_POST['nama_lengkap'];
    $email = $_POST['email'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $alamat = $_POST['alamat'];
    $id_kategori = $_POST['nama_kategori'];
    $telepon = $_POST['telepon'];
    $keahlian = $_POST['keahlian'];
    $pengalaman_lomba = $_POST['pengalaman_lomba'];

    // Jika ada file foto yang diunggah
    $foto_diri = '';
    if (!empty($_FILES['foto_diri']['name'])) {
        $foto_diri = $_FILES['foto_diri']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($foto_diri);

        // Pindahkan file yang diunggah ke direktori tujuan
        move_uploaded_file($_FILES['foto_diri']['tmp_name'], $target_file);
    }

    // Simpan data ke database
    $insertQuery = "INSERT INTO pendaftaran 
                    (nama_lengkap, email, tanggal_lahir, alamat, id_kategori, telepon, keahlian, pengalaman_lomba, foto_diri) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param(
        'ssssissss',
        $nama_lengkap,
        $email,
        $tanggal_lahir,
        $alamat,
        $id_kategori,
        $telepon,
        $keahlian,
        $pengalaman_lomba,
        $foto_diri
    );

    if ($stmt->execute()) {
        header("Location: admin.php?message=Data berhasil ditambahkan");
        exit();
    } else {
        echo "Gagal menambahkan data: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Pendaftaran</title>
    <style>
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
            <h1>Tambah Data Pendaftaran</h1>
        </header>
        <form action="tambah.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama_lengkap">Nama Lengkap:</label>
                <input type="text" id="nama_lengkap" name="nama_lengkap" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="tanggal_lahir">Tanggal Lahir:</label>
                <input type="date" id="tanggal_lahir" name="tanggal_lahir" required>
            </div>
            
            <div class="form-group">
                <label for="alamat">Alamat:</label>
                <textarea id="alamat" name="alamat" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="nama_kategori">Kategori:</label>
                <select id="nama_kategori" name="nama_kategori" required>
                    <option value="" disabled selected>Pilih Kategori</option>
                    <?php foreach ($kategori_options as $kategori): ?>
                        <option value="<?= htmlspecialchars($kategori['id_kategori']); ?>">
                            <?= htmlspecialchars($kategori['nama_kategori']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="telepon">Telepon:</label>
                <input type="text" id="telepon" name="telepon" required>
            </div>
            
            <div class="form-group">
                <label for="keahlian">Keahlian:</label>
                <textarea id="keahlian" name="keahlian" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="pengalaman_lomba">Pengalaman Lomba:</label>
                <textarea id="pengalaman_lomba" name="pengalaman_lomba" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="foto_diri">Foto Diri:</label>
                <input type="file" id="foto_diri" name="foto_diri" required>
            </div>
            
            <div class="form-group">
                <input type="submit" value="Tambah Data">
            </div>
        </form>
    </div>
</body>
</html>
