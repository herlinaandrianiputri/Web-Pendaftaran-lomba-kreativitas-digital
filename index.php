<?php
// Menggunakan koneksi.php untuk terhubung ke database
require 'koneksi.php'; // Pastikan path file sudah benar

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lomba Kreativitas Digital 2024</title>
    <style>
        /* Gaya Umum */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px 0;
            background: white;
        }

        /* Container Utama */
        .container {
            width: 80%;
            max-width: 800px;
            margin: auto;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Header dengan Gradasi */
        .header {
            text-align: center;
            padding: 20px;
            background: linear-gradient(135deg, #f06292, #9c27b0);
            color: white;
        }

        .header h1 {
            font-size: 2.5rem;
            margin: 0;
        }

        .header p {
            font-size: 1.1rem;
            margin: 10px 0 0;
        }

        /* Konten Utama */
        .content {
            text-align: center;
            padding: 10px 10px;
            background-color: white;
            color: #2d3436;
            margin-bottom: 10px;
        }

        .content h2 {
            font-size: 1.5rem;
            margin-bottom: 7px;
            font-weight: bold;
        }

        .content p {
            font-size: 1rem;
            line-height: 1.5;
            margin: 0 auto 10px;
            max-width: 700px;
        }

        .content img {
            width: 100%;
            max-width: 400px;
            height: auto;
            border-radius: 8px;
            margin: 15px 0;
        }

        /* Bagian Hadiah */
        .hadiah {
            text-align: center;
            padding: 20px;
            background: linear-gradient(135deg, #f06292, #9c27b0);
            color: white;
        }

        .hadiah h2 {
            font-size: 1.6rem;
            margin-bottom: 10px;
        }

        .hadiah ul {
            list-style: none;
            padding: 0;
        }

        .hadiah ul li {
            font-size: 1rem;
            margin: 8px 0;
        }

      /* Tombol Login dengan Animasi */
      .login-btn {
            display: inline-block;
            padding: 12px 25px;
            background: linear-gradient(135deg, #f06292, #7b1fa2) /* Warna tombol pink */
            color: #007bff;
            text-decoration: none;
            font-size: 1.2rem;
            font-weight: bold;
            border-radius: 25px;
            transition: all 0.3s ease;
            margin-top: 15px;
        }

        .login-btn:hover {
            background: linear-gradient(135deg, #f06292, #9c27b0);
            color: white;
            transform: scale(1.1); /* Efek besar saat hover */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Bayangan untuk efek */
        }


        /* Footer */
        .footer {
            text-align: center;
            padding: 3px;
            background: #2d3436;
            color: white;
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
    <!-- Container Utama -->
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Lomba Kreativitas Digital 2024</h1>
        </div>

        <!-- Konten Utama -->
        <div class="content">
            <h2>Tentang Lomba</h2>
            <img src="https://infojateng.id/wp-content/uploads/2021/09/Konten-Kreator-696x450-1.png" alt="Gambar Lomba">
            <p>
                Selamat datang di Lomba Kreativitas Digital! Kami mengundang Anda untuk mengikuti lomba yang bertujuan untuk menguji kemampuan kreativitas dan keterampilan digital Anda.
            </p>
            <p>
                Dalam lomba ini, peserta akan menghadapi tantangan dalam menciptakan karya digital yang inovatif dan kreatif. Jangan lewatkan kesempatan ini!
            </p>
            <a href="login.php" class="login-btn">Login untuk Mendaftar</a>
        </div>

        <!-- Bagian Hadiah -->
        <div class="hadiah">
            <h2>Hadiah yang Akan Anda Dapatkan</h2>
            <ul>
                <li>🏆 Juara 1: Rp 10.000.000 + Sertifikat + Trophy</li>
                <li>🥈 Juara 2: Rp 7.500.000 + Sertifikat</li>
                <li>🥉 Juara 3: Rp 5.000.000 + Sertifikat</li>
                <li>🎖 Semua peserta mendapatkan e-sertifikat</li>
            </ul>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; 2024 Lomba Kreativitas Digital.</p>
        </div>
    </div>
</body>
</html>
