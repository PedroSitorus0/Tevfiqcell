<?php
session_start();
require 'koneksi.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek user di database
    $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);
        // Verifikasi password (gunakan password_verify jika password di-hash)
        if ($password == $data['password']) {
            $_SESSION['user_id'] = $data['id'];
            $_SESSION['role'] = $data['role'];
            $_SESSION['username'] = $data['username'];
            
            if ($data['role'] == 'admin') {
                header("Location: admin.php");
            } else {
                header("Location: index.php");
            }
            exit;
        }
    }
    $error = "Username atau Password salah!";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Login - Tevfiq Cell</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container" style="margin-top: 50px; max-width: 400px;">
        <div class="card">
            <h2 style="text-align: center;">Login Tevfiq Cell</h2>
            <?php if(isset($error)) echo "<p style='color:red;text-align:center;'>$error</p>"; ?>
            <form method="POST">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>
                <button type="submit" name="login" class="btn primary" style="width:100%;">Masuk</button>
            </form>
            <p style="text-align:center; margin-top:10px;"><a href="register.php">Belum punya akun? Daftar</a></p>
        </div>
    </div>
</body>
</html>