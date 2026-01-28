<?php
session_start();
require 'koneksi.php';

// Proteksi & Cek ID
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin' || !isset($_GET['id'])) {
    header("Location: kelola_paket.php");
    exit;
}

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM paket_data WHERE id='$id'");
$p = mysqli_fetch_assoc($data);

// --- LOGIKA UPDATE ---
if (isset($_POST['update_paket'])) {
    $nama = $_POST['nama_paket'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];

    $query = "UPDATE paket_data SET nama_paket='$nama', harga='$harga', deskripsi='$deskripsi' WHERE id='$id'";
    
    if(mysqli_query($conn, $query)){
        echo "<script>alert('Paket berhasil diupdate!'); window.location='kelola_paket.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Paket - Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container" style="margin-top: 50px; max-width: 500px;">
        <div class="card">
            <h2>Edit Paket Data</h2>
            <form method="POST">
                <div class="form-group">
                    <label>Nama Paket:</label>
                    <input type="text" name="nama_paket" value="<?= $p['nama_paket'] ?>" required>
                </div>
                <div class="form-group">
                    <label>Harga (Rp):</label>
                    <input type="number" name="harga" value="<?= $p['harga'] ?>" required>
                </div>
                <div class="form-group">
                    <label>Deskripsi:</label>
                    <input type="text" name="deskripsi" value="<?= $p['deskripsi'] ?>" required>
                </div>
                <div style="display:flex; gap:10px;">
                    <button type="submit" name="update_paket" class="btn primary" style="flex:1;">Update</button>
                    <a href="kelola_paket.php" class="btn secondary" style="flex:1; text-align:center; background:#6c757d; color:white; text-decoration:none; line-height:45px;">Batal</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>