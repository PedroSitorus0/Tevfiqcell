<?php
  require 'koneksi.php';

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tevfiq Cell - Layanan Pulsa & Data</title>
  <link rel="stylesheet" href="style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
  <header>
    <div class="container">
      <h1>Tevfiq Cell 📱</h1>
      <nav>
        <ul>
          <li><a href="#pulsa">Pulsa</a></li>
          <li><a href="#data">Paket Data</a></li>
          <li><a href="#pembayaran">Pembayaran</a></li>
          <li><a href="#kontak">Kontak</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <main class="container">
    
    <section id="pulsa" class="card">
      <h2>Pembelian Pulsa Cepat ⚡</h2>
      <form id="pulsa-form">
        <div class="form-group">
          <label for="nomor-pulsa">Nomor HP:</label>
          <input type="tel" id="nomor-pulsa" name="nomor" placeholder="Cth: 081234567890" required>
        </div>
        <div class="form-group">
          <label for="nominal-pulsa">Nominal Pulsa:</label>
          <select id="nominal-pulsa" name="nominal" required>
            <option value="">-- Pilih Nominal --</option>
            <option value="5000">Rp 5.000</option>
            <option value="10000">Rp 10.000</option>
            <option value="20000">Rp 20.000</option>
            <option value="50000">Rp 50.000</option>
            <option value="100000">Rp 100.000</option>
          </select>
        </div>
        <button type="submit" class="btn primary">Beli Pulsa</button>
        <p id="pulsa-message" class="message"></p>
      </form>
    </section>

    <hr>

    <section id="data" class="card">
      <h2>Beli Paket Data Hemat 📶</h2>
      <form id="data-form">
        <div class="form-group">
          <label for="nomor-data">Nomor HP:</label>
          <input type="tel" id="nomor-data" name="nomor" placeholder="Masukkan Nomor HP" required>
        </div>
        <div class="form-group">
          <label for="paket-data">Pilihan Paket:</label>
          <select id="paket-data" name="paket" required>
            <option value="">-- Pilih Paket Data --</option>
            <option value="1GB">1 GB / 7 Hari (Rp 25.000)</option>
            <option value="5GB">5 GB / 30 Hari (Rp 55.000)</option>
            <option value="10GB">10 GB / 30 Hari (Rp 90.000)</option>
          </select>
        </div>
        <button type="submit" class="btn secondary">Beli Paket</button>
        <p id="data-message" class="message"></p>
      </form>
    </section>

    <hr>

    <section id="pembayaran" class="card">
      <h2>Layanan Pembayaran Lain 💰</h2>
      <div class="feature-grid">
        <div class="feature-item">
          <h3>Listrik PLN</h3>
          <p>Bayar tagihan listrik pascabayar/prabayar.</p>
          <button class="btn info">Bayar Sekarang</button>
        </div>
        <div class="feature-item">
          <h3>PDAM</h3>
          <p>Pembayaran tagihan air bersih bulanan.</p>
          <button class="btn info">Bayar Sekarang</button>
        </div>
        <div class="feature-item">
          <h3>BPJS</h3>
          <p>Bayar iuran BPJS Kesehatan Anda.</p>
          <button class="btn info">Bayar Sekarang</button>
        </div>
      </div>
    </section>
  </main>

  <footer>
    <div class="container" id="kontak">
      <p>&copy; 2025 Tevfiq Cell. Layanan Digital Terpercaya.</p>
      <p>Hubungi Kami: <a href="mailto:info@tevfiqcell.com">info@tevfiqcell.com</a> | Telp: (021) 123-456</p>
    </div>
  </footer>

  <script src="script.js"></script>
</body>
</html>
