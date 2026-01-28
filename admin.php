<?php
session_start();
require 'koneksi.php';

// Proteksi: Hanya Admin yang boleh masuk
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

// Logic Update Status (CRUD - Update)
if (isset($_GET['terima'])) {
    $id = $_GET['terima'];
    mysqli_query($conn, "UPDATE riwayat_pembelian SET status='sukses' WHERE id='$id'");
    header("Location: admin.php");
}

// Logic Hapus (CRUD - Delete)
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM riwayat_pembelian WHERE id='$id'");
    header("Location: admin.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #007bff; color: white; }
    </style>
</head>
<body>
    <header>
    <div class="container">
        <h1>Admin Panel 諾</h1>
        <nav>
            <ul>
                <li><a href="admin.php">Pesanan Masuk</a></li>
                <li><a href="kelola_paket.php">Kelola Paket Data</a></li> 
                <li><a href="logout.php" style="color: #ffcccc;">Logout</a></li>
            </ul>
        </nav>
    </div>
</header>

<main class="container">
    
    <div class="card" style="margin-bottom: 20px; background-color: #e9ecef; border-left: 5px solid #007bff;">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
            <h3 style="margin: 0; color: #333;">Export Laporan</h3>
            <div style="margin-top: 5px;">
                <a href="cetak_pdf.php" target="_blank" class="btn primary" style="background-color: #dc3545; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; margin-right: 5px;">
                    PDF
                </a>
                <a href="cetak_excel.php" target="_blank" class="btn primary" style="background-color: #28a745; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px; margin-right: 5px;">
                    Excel
                </a>
                <a href="cetak.php" target="_blank" class="btn secondary" style="background-color: #6c757d; color: white; padding: 8px 15px; text-decoration: none; border-radius: 4px;">
                    Print
                </a>
            </div>
        </div>
    </div>

    <div class="card">
        <h2>Riwayat Pesanan Masuk</h2>
        <table>
            <tr>
                <th>No</th>
                <th>User</th>
                <th>Nomor HP</th>
                <th>Item</th>
                <th>Harga</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
            <?php
            // Pastikan koneksi sudah di-load di bagian atas file admin.php
            $query = mysqli_query($conn, "SELECT r.*, u.username FROM riwayat_pembelian r JOIN users u ON r.user_id = u.id ORDER BY r.tanggal DESC");
            $no = 1;
            while($row = mysqli_fetch_assoc($query)) {
                $statusColor = ($row['status'] == 'sukses') ? 'green' : 'orange';
                echo "<tr>
                    <td>$no</td>
                    <td>{$row['username']}</td>
                    <td>{$row['nomor_hp']}</td>
                    <td>{$row['item_beli']}</td> <td>Rp " . number_format($row['total_harga']) . "</td>
                    <td style='color:$statusColor; font-weight:bold;'>".strtoupper($row['status'])."</td>
                    <td>
                        <a href='admin.php?terima={$row['id']}' class='btn primary' style='padding:5px 10px; font-size:12px;'>Terima</a>
                        <a href='admin.php?hapus={$row['id']}' class='btn secondary' style='background:red; padding:5px 10px; font-size:12px; color:white;' onclick='return confirm(\"Yakin hapus?\")'>Hapus</a>
                    </td>
                </tr>";
                $no++;
            }
            ?>
        </table>
    </div>
</main>
</body>
</html>