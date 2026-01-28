<?php
require 'koneksi.php';

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = 'user'; // Default semua pendaftar adalah USER biasa

    // Cek apakah username sudah ada
    $cek_user = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    
    if (mysqli_num_rows($cek_user) > 0) {
        echo "<script>alert('Username sudah terpakai! Ganti yang lain.');</script>";
    } else {
        // Simpan ke database
        // Catatan: Untuk keamanan produksi, password sebaiknya di-hash (password_hash)
        $query = "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')";
        
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Pendaftaran Berhasil! Silakan Login.'); window.location='login.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Daftar Akun - Tevfiq Cell</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container" style="margin-top: 50px; max-width: 400px;">
        <div class="card">
            <h2 style="text-align: center; color: #007bff;">Daftar Akun Baru</h2>
            <form method="POST">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Masukkan Username" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Masukkan Password" required>
                </div>
                <button type="submit" name="register" class="btn secondary" style="width:100%;">Daftar Sekarang</button>
            </form>
            <p style="text-align:center; margin-top:10px;">
                Sudah punya akun? <a href="login.php" style="color: #007bff; font-weight: bold;">Login disini</a>
            </p>
        </div>
    </div>