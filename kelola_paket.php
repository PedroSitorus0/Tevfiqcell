<?php
session_start();
require 'koneksi.php';

// Proteksi Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

// --- LOGIKA CREATE (TAMBAH PAKET) ---
if (isset($_POST['tambah_paket'])) {
    $nama = $_POST['nama_paket'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];

    $query = "INSERT INTO paket_data (nama_paket, harga, deskripsi) VALUES ('$nama', '$harga', '$deskripsi')";
    mysqli_query($conn, $query);
    echo "<script>alert('Paket berhasil ditambahkan!'); window.location='kelola_paket.php';</script>";
}

// --- LOGIKA DELETE (HAPUS PAKET) ---
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM paket_data WHERE id='$id'");
    echo "<script>alert('Paket dihapus!'); window.location='kelola_paket.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Paket - Admin</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .admin-container { display: flex; gap: 20px; flex-wrap: wrap; }
        .form-card { flex: 1; min-width: 300px; }
        .table-card { flex: 2; min-width: 300px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        th { background: #007bff; color: white; }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>Kelola Paket Data 締</h1>
            <nav>
                <ul>
                    <li><a href="admin.php">Kembali ke Pesanan</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container admin-container">
        
        <div class="card form-card">
            <h2>Tambah Paket Baru</h2>
            <form method="POST">
                <div class="form-group">
                    <label>Nama Paket:</label>
                    <input type="text" name="nama_paket" placeholder="Cth: Internet Sultan 100GB" required>
                </div>
                <div class="form-group">
                    <label>Harga (Rp):</label>
                    <input type="number" name="harga" placeholder="Cth: 100000" required>
                </div>
                <div class="form-group">
                    <label>Deskripsi:</label>
                    <input type="text" name="deskripsi" placeholder="Cth: Masa aktif 30 hari" required>
                </div>
                <button type="submit" name="tambah_paket" class="btn primary">Simpan Paket</button>
            </form>
        </div>

        <div class="card table-card">
            <h2>Daftar Paket Tersedia</h2>
            <table>
                <tr>
                    <th>Nama Paket</th>
                    <th>Harga</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
                <?php
                $paket = mysqli_query($conn, "SELECT * FROM paket_data ORDER BY harga ASC");
                while($p = mysqli_fetch_assoc($paket)){
                    echo "<tr>
                        <td>{$p['nama_paket']}</td>
                        <td>Rp ".number_format($p['harga'])."</td>
                        <td>{$p['deskripsi']}</td>
                        <td>
                            <a href='edit_paket.php?id={$p['id']}' class='btn info' style='padding:5px 10px; font-size:12px;'>Edit</a>
                            <a href='kelola_paket.php?hapus={$p['id']}' class='btn secondary' style='background:red; padding:5px 10px; font-size:12px; color:white;' onclick='return confirm(\"Yakin hapus paket ini?\")'>Hapus</a>
                        </td>
                    </tr>";
                }
                ?>
            </table>
        </div>

    </main>
</body>
</html>