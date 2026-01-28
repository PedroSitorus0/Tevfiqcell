<?php
require 'koneksi.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; }
    </style>
</head>
<body onload="window.print()">
    <center>
        <h2>Laporan Penjualan Tevfiq Cell</h2>
    </center>
    <table>
        <tr>
            <th>Tanggal</th>
            <th>Item</th>
            <th>Nomor HP</th>
            <th>Harga</th>
            <th>Status</th>
        </tr>
        <?php
        $data = mysqli_query($conn, "SELECT * FROM riwayat_pembelian WHERE status='sukses'");
        while($d = mysqli_fetch_assoc($data)){
            echo "<tr>
                <td>{$d['tanggal']}</td>
                <td>{$d['item_pembelian']}</td>
                <td>{$d['nomor_hp']}</td>
                <td>Rp ".number_format($d['total_harga'])."</td>
                <td>{$d['status']}</td>
            </tr>";
        }
        ?>
    </table>
</body>
</html>