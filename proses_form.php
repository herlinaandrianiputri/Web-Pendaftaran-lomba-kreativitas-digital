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

// Proses data saat form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari formulir
    $nama_lengkap = $_POST['nama_lengkap'] ?? '';
    $email = $_POST['email'] ?? '';
    $tanggal_lahir = $_POST['tanggal_lahir'] ?? '';
    $alamat = $_POST['alamat'] ?? '';
    $id_kategori = $_POST['id_kategori'] ?? ''; // Menggunakan id_kategori dari dropdown
    $telepon = $_POST['telepon'] ?? '';
    $keahlian = $_POST['keahlian'] ?? '';
    $pengalaman_lomba = $_POST['pengalaman_lomba'] ?? '';
    $foto_diri = '';

    // Validasi input formulir
    if (empty($nama_lengkap) || empty($email) || empty($tanggal_lahir) || empty($alamat) || empty($id_kategori) || empty($telepon) || empty($keahlian) || empty($pengalaman_lomba)) {
        die("Semua data wajib diisi."); // Berikan pesan jika ada data yang kosong
    }

    // Proses upload file
    if (isset($_FILES['foto_diri']) && $_FILES['foto_diri']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "uploads/"; // Folder penyimpanan file
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true); // Buat folder jika belum ada
        }
        $target_file = $target_dir . basename($_FILES["foto_diri"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validasi ukuran dan ekstensi file
        if ($_FILES["foto_diri"]["size"] > 2097152) { // Maksimal 2MB
            die("Ukuran file terlalu besar. Maksimal 2MB.");
        }
        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            die("Hanya file JPG, JPEG, PNG, dan GIF yang diizinkan.");
        }

        // Upload file
        if (move_uploaded_file($_FILES["foto_diri"]["tmp_name"], $target_file)) {
            $foto_diri = basename($_FILES["foto_diri"]["name"]);
        } else {
            die("Terjadi kesalahan saat meng-upload file.");
        }
    } else {
        die("Pilih file untuk di-upload.");
    }

    // Query untuk memasukkan data ke tabel pendaftaran
    $query = "INSERT INTO pendaftaran (nama_lengkap, email, tanggal_lahir, alamat, id_kategori, telepon, keahlian, pengalaman_lomba, foto_diri) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($query)) { // Memastikan query dipersiapkan dengan benar
        $stmt->bind_param(
            "sssssssss",
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

        // Eksekusi query dan cek hasilnya
        if ($stmt->execute()) {
            echo "<div style='text-align: center; margin-top: 20px;'>";
            echo "<p style='color: green; font-size: 18px;'>Pendaftaran berhasil! Data Anda telah disimpan.</p>";
            echo "<a href='index.php' class='form-container input[type=\"submit\"] index-button'>Kembali ke Menu Utama</a>";
            echo "</div>";
        } else {
            echo "<p style='color: red;'>Gagal menyimpan data. Pesan error: " . $stmt->error . "</p>";
        }
        $stmt->close();
    } else {
        die("Query gagal disiapkan: " . $conn->error); // Jika query tidak berhasil disiapkan
    }
}
?>

<!-- Kode CSS -->
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
    display: inline-block;
    padding: 12px 25px;
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
    transform: scale(1.1);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.index-button {
    display: inline-block;
    padding: 12px 25px;
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

.index-button:hover {
    background: linear-gradient(135deg, #f06292, #9c27b0);
    color: white;
    transform: scale(1.1);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}
</style>
