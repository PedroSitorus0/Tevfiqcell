<?php
require 'koneksi.php';

// Fungsi header dengan mengirimkan raw data excel
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan_TevfiqCell.xls");

?>

<h3>Laporan Penjualan Tevfiq Cell</h3>
<table border="1">
    <tr>
        <th>No</th>
        <th>Tanggal Transaksi</th>
        <th>User (Pembeli)</th>
        <th>Nomor HP</th>
        <th>Item Dibeli</th>
        <th>Harga</th>
        <th>Status</th>
    </tr>
    <?php
    // Ambil data dari database
    $query = mysqli_query($conn, "SELECT r.*, u.username FROM riwayat_pembelian r JOIN users u ON r.user_id = u.id ORDER BY r.tanggal DESC");
    $no = 1;
    while($row = mysqli_fetch_assoc($query)){
        $status = strtoupper($row['status']);
        echo "<tr>
            <td>$no</td>
            <td>{$row['tanggal']}</td>
            <td>{$row['username']}</td>
            <td>'{$row['nomor_hp']}</td> <td>{$row['item_beli']}</td>
            <td>Rp " . number_format($row['total_harga']) . "</td>
            <td>$status</td>
        </tr>";
        $no++;
    }
    ?>
</table>