<?php
// Menggunakan koneksi.php untuk terhubung ke database
require 'koneksi.php'; // Pastikan path file sudah benar

// Cek apakah tombol login ditekan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil input dari form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Enkripsi password menggunakan MD5
    $password_hash = md5($password);

    // Query untuk mengambil data pengguna dari database
    $query = "SELECT * FROM pengguna WHERE username='$username' AND password='$password_hash'";
    $result = mysqli_query($conn, $query);

    // Cek apakah pengguna ditemukan
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        session_start();
        $_SESSION['username'] = $username;

        if ($user['role'] == 'peserta') {
            header("Location: formulir.php");
        } elseif ($user['role'] == 'admin') {
            header("Location: admin.php");
        } elseif ($user['role'] == 'pimpinan') {
            header("Location: pimpinan.php");
        } else {
            $error = "Akses tidak ditemukan!";
        }
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Lomba Kreativitas Digital</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px 0;
        }

        .container {
            width: 80%;
            max-width: 400px;
            margin: auto;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            background: white;
        }

        .header {
            text-align: center;
            padding: 17px;
            background: linear-gradient(135deg, #f06292, #9c27b0);
            color: white;
        }

        .header h1 {
            font-size: 1.7rem;
            margin: 0;
        }

        .form-container {
            padding: 20px;
        }

        .form-container label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #2d3436;
        }

        .form-container input[type="text"],
        .form-container input[type="password"] {
            width: calc(100% - 20px); /* Lebih dari 20px untuk memberi ruang di pinggir */
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            box-sizing: border-box; /* Membuat margin dihitung dalam total ukuran */
        }

        .form-container input[type="submit"] {
            display: inline-block;
            padding: 12px 25px;
            background-color: white; /* Warna awal tombol */
            color: #007bff; /* Warna tulisan */
            text-align: center;
            font-size: 1.2rem;
            font-weight: bold;
            border-radius: 25px;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none; /* Menghilangkan tampilan pinggiran */
        }

        .form-container input[type="submit"]:hover {
            background: linear-gradient(135deg, #f06292, #9c27b0); /* Warna saat di-hover */
            color: white;
            transform: scale(1.1); /* Efek besar saat hover */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Bayangan untuk efek */
        }

        .error {
            color: red;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }

        .footer {
            text-align: center;
            padding: 2px;
            background: #2d3436;
            color: white;
            font-size: 0.8rem;
        }

        /* Menempatkan tombol di tengah bagian bawah */
        .button-container {
            display: flex;
            justify-content: center; /* Menempatkan tombol di tengah secara horizontal */
            margin-top: 15px; /* Sesuaikan jarak ke bagian bawah */
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Login</h1>
        </div>

        <!-- Form Login -->
        <div class="form-container">
            <?php if (isset($error)): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
            <form action="" method="post">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                
                <!-- Letakkan tombol login di tengah bagian bawah -->
                <div class="button-container">
                    <input type="submit" value="Login">
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; 2024 Lomba Kreativitas Digital</p>
        </div>
    </div>
</body>
</html>
