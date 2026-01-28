<?php
session_start();
require 'koneksi.php';

// Pastikan ada data yang dikirim via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $nomor = $_POST['nomor'];
    $tipe = $_POST['tipe_transaksi'];
    
    $item_pembelian = "";
    $total_harga = 0;

    // Logika jika beli PULSA
    if ($tipe == 'pulsa') {
        $total_harga = $_POST['nominal'];
        $item_pembelian = "Pulsa Rp " . number_format($total_harga);
    } 
    // Logika jika beli PAKET DATA
    elseif ($tipe == 'paket_data') {
        $paket_id = $_POST['paket_id'];
        
        // Ambil info paket dari database biar harganya akurat (anti curang)
        $cek_paket = mysqli_query($conn, "SELECT * FROM paket_data WHERE id='$paket_id'");
        $data_paket = mysqli_fetch_assoc($cek_paket);
        
        if ($data_paket) {
            $item_pembelian = $data_paket['nama_paket'];
            $total_harga = $data_paket['harga'];
        } else {
            echo "<script>alert('Paket tidak ditemukan!'); window.location='index.php';</script>";
            exit;
        }
    }

    // Masukkan ke Database
// Sesuaikan nama kolom dengan database: 'item_beli'
    $query_insert = "INSERT INTO riwayat_pembelian (user_id, nomor_hp, item_beli, total_harga, status) 
                      VALUES ('$user_id', '$nomor', '$item_pembelian', '$total_harga', 'pending')";
    if (mysqli_query($conn, $query_insert)) {
        echo "<script>
                alert('Transaksi Berhasil! Silakan tunggu konfirmasi Admin.');
                window.location='index.php';
              </script>";
    } else {
        echo "Gagal: " . mysqli_error($conn);
    }
} else {
    // Kalau orang coba buka file ini langsung tanpa lewat form
    header("Location: index.php");
}
?>