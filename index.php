<?php
session_start();
require 'koneksi.php';

// Cek apakah user sudah login, jika belum lempar ke login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tevfiq Cell - Dashboard</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
  <header>
    <div class="container">
      <h1>Tevfiq Cell 導</h1>
     <nav>
        <ul>
            <li><a href="index.php#pulsa">Pulsa</a></li>
            <li><a href="index.php#data">Paket Data</a></li>
            <li><a href="riwayat.php">Riwayat Transaksi</a></li> 
    
            <li><a href="logout.php" style="color: #ffcccc;">Logout (<?= $_SESSION['username']; ?>)</a></li>
        </ul>
    </nav>
    </div>
  </header>

  <main class="container">
    
    <section id="pulsa" class="card">
      <h2>Beli Pulsa</h2>
      <form action="proses_beli.php" method="POST">
        <input type="hidden" name="tipe_transaksi" value="pulsa">
        <div class="form-group">
          <label>Nomor HP:</label>
          <input type="tel" name="nomor" placeholder="081234567890" required>
        </div>
        <div class="form-group">
          <label>Nominal:</label>
          <select name="nominal" required>
            <option value="5000">Rp 5.000</option>
            <option value="10000">Rp 10.000</option>
            <option value="20000">Rp 20.000</option>
            <option value="50000">Rp 50.000</option>
          </select>
        </div>
        <button type="submit" class="btn primary">Beli Sekarang</button>
      </form>
    </section>

    <section id="data" class="card">
      <h2>Beli Paket Data</h2>
      <form action="proses_beli.php" method="POST">
        <input type="hidden" name="tipe_transaksi" value="paket_data">
        <div class="form-group">
          <label>Nomor HP:</label>
          <input type="tel" name="nomor" placeholder="081234567890" required>
        </div>
        <div class="form-group">
          <label>Pilih Paket:</label>
          <select name="paket_id" required>
            <option value="">-- Pilih Paket Dari Database --</option>
            <?php
            // MENGAMBIL DATA PAKET DARI TABEL 'paket_data'
            $query_paket = mysqli_query($conn, "SELECT * FROM paket_data");
            while ($row = mysqli_fetch_assoc($query_paket)) {
                echo "<option value='{$row['id']}'>{$row['nama_paket']} - Rp " . number_format($row['harga']) . "</option>";
            }
            ?>
          </select>
        </div>
        <button type="submit" class="btn secondary">Beli Paket</button>
      </form>
    </section>

  </main>
</body>
</html>