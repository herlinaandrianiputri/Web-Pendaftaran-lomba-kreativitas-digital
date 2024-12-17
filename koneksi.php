<?php
$host = 'localhost'; // Alamat host MySQL (biasanya 'localhost')
$username = 'root'; // Nama pengguna database
$password = ''; // Password pengguna (sebaiknya kosong pada local, tapi perlu diisi pada host live)
$dbname = 'lombakreatifitasdigital_'; // Nama database

// Membuat koneksi ke database
$conn = mysqli_connect($host, $username, $password, $dbname);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
} else {
    echo " ";
}