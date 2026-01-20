<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "tevfiqcell_db";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi Database Gagal: " . $conn->connect_error);
}
?>