<?php
// Tampilkan error agar tidak hanya blank 500
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Gunakan IP, bukan localhost untuk memaksa jalur TCP
$host = "127.0.0.1"; 
$user = "pedro";
$pass = "Pedr0.@21";     // Pastikan password root kosong atau sesuaikan
$db   = "tevfiqcell_cell";
$port = 3306;

$conn = mysqli_connect($host, $user, $pass, $db, $port);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
} else {
    // Hapus baris ini nanti jika sudah berhasil
    // echo "Koneksi Berhasil!"; 
}
?>