📱 Tevfiq Cell - Sistem Penjualan Pulsa & Paket Data Web Base

Selamat datang di Tevfiq Cell! 👋

Project ini adalah aplikasi web sederhana yang dibangun menggunakan PHP Native (tanpa framework) dan database MySQL/MariaDB. Aplikasi ini mensimulasikan sistem penjualan pulsa dan paket data (kuota internet) dengan fitur lengkap mulai dari sisi Pelanggan hingga Admin.

Project ini sangat cocok untuk kamu yang sedang belajar:

    PHP Dasar & Lanjutan (Session, CRUD, Logic).

    Database Relasional (Menghubungkan tabel User, Transaksi, dan Barang).

    Pelaporan (Export data ke PDF & Excel).

    Manajemen User (Login, Register, Level Akses Admin vs User).

🚀 Fitur Utama
👤 Halaman Pengguna (User)

    Registrasi & Login: Pengguna bisa membuat akun sendiri.

    Dashboard Belanja: Tampilan antarmuka yang bersih untuk memilih produk.

    Pembelian Pulsa: Input nomor HP dan pilih nominal.

    Pembelian Paket Data: Pilihan paket dinamis yang diambil langsung dari database.

    Riwayat Transaksi: Pengguna bisa melihat status pembelian mereka (Pending/Sukses/Batal).

👮 Halaman Admin (Administrator)

    Dashboard Monitoring: Melihat semua pesanan yang masuk dari seluruh user.

    Verifikasi Transaksi: Admin bisa menyetujui (Terima) atau menolak (Hapus) pesanan.

    Manajemen Paket Data (CRUD): Admin bisa menambah, mengedit, dan menghapus produk paket data tanpa menyentuh kodingan.

    Cetak Laporan: Fitur canggih untuk mengunduh laporan penjualan dalam format .PDF dan .XLS (Excel).

🛠️ Teknologi yang Digunakan

    Bahasa Pemrograman: PHP (Native / Procedural style).

    Database: MySQL / MariaDB.

    Frontend: HTML5, CSS3 (Custom Style, Responsif).

    Server Lokal: Apache (via XAMPP di Windows atau LAMPP di Linux).

    Library Tambahan: FPDF (untuk generate laporan PDF).

💻 Persiapan Instalasi (Prerequisites)

Sebelum menjalankan aplikasi ini, pastikan di komputer kamu sudah terinstall:

    Web Server & Database:

        Untuk pengguna Windows: Install XAMPP.

        Untuk pengguna Linux/Mac: Bisa menggunakan LAMPP, MAMP, atau install Apache & MariaDB secara manual.

    Web Browser: Google Chrome, Firefox, atau Edge.

    Text Editor (Opsional): VS Code atau Sublime Text jika ingin melihat kodingannya.

⚙️ Cara Instalasi (Step-by-Step)

Ikuti langkah ini dengan teliti agar aplikasi berjalan lancar.
Langkah 1: Simpan File Project

    Download atau Clone repository ini.

    Pindahkan folder tevfiq_cell ke dalam folder server lokal kamu:

        Windows (XAMPP): C:\xampp\htdocs\

        Linux (LAMPP): /opt/lampp/htdocs/ atau /var/www/html/

Langkah 2: Persiapan Database (PENTING!)

Aplikasi ini tidak akan jalan tanpa database. Kita harus membuatnya secara manual.

    Buka browser, akses phpMyAdmin (biasanya di http://localhost/phpmyadmin).

    Buat database baru dengan nama: tevfiq_cell.

    Klik tab SQL pada database tersebut, lalu COPY & PASTE kode di bawah ini seluruhnya, lalu klik GO/Kirim:

SQL

-- 1. Membuat Tabel Users
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user'
);

-- 2. Membuat Tabel Paket Data
CREATE TABLE paket_data (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama_paket VARCHAR(100),
    harga INT,
    deskripsi VARCHAR(255)
);

-- 3. Membuat Tabel Riwayat Pembelian
CREATE TABLE riwayat_pembelian (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    nomor_hp VARCHAR(20),
    item_beli VARCHAR(100),
    total_harga INT,
    tanggal TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending', 'sukses', 'batal') DEFAULT 'pending',
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- 4. Mengisi Data Awal (Seeding)
-- Akun Admin (Password: admin123)
INSERT INTO users (username, password, role) VALUES 
('admin', 'admin123', 'admin');

-- Paket Data Default
INSERT INTO paket_data (nama_paket, harga, deskripsi) VALUES 
('Internet Hemat 1GB', 10000, 'Kuota Utama 1GB, Masa Aktif 7 Hari'),
('Internet Seru 3GB', 20000, 'Kuota Utama 3GB, Masa Aktif 14 Hari'),
('Internet Mantap 4GB', 25000, 'Kuota Utama 4GB, Masa Aktif 30 Hari'),
('Internet Ngebut 5GB', 30000, 'Kuota Utama 5GB, Masa Aktif 30 Hari'),
('Internet Jumbo 20GB', 50000, 'Kuota Utama 20GB, Masa Aktif 30 Hari'),
('Internet Sultan 100GB', 100000, 'Kuota Utama 100GB, Masa Aktif 30 Hari');

Langkah 3: Konfigurasi Koneksi (Jika Perlu)

Buka file koneksi.php di text editor. Pastikan settingannya sesuai dengan komputer kamu.

    Default XAMPP: User root, Password (kosong).

    Default LAMPP (Linux): User root, Password (kosong) atau sesuaikan jika ada password.

PHP

$host = "localhost"; // Atau "127.0.0.1" jika error socket
$user = "root";
$pass = ""; 
$db   = "tevfiq_cell";

📖 Cara Menggunakan Aplikasi
1. Masuk Sebagai Admin

Untuk mengatur toko, kamu harus login sebagai bos (Admin).

    Buka browser: http://localhost/tevfiq_cell/login.php

    Username: admin

    Password: admin123

    Apa yang bisa dilakukan?

        Masuk ke menu Kelola Paket Data untuk menambah produk jualan.

        Lihat pesanan masuk di dashboard.

        Klik Terima pada pesanan user agar statusnya berubah jadi "SUKSES".

        Klik Download PDF/Excel untuk laporan bulanan.

2. Masuk Sebagai User (Pelanggan)

Gunakan browser lain atau Incognito Mode untuk simulasi sebagai pembeli.

    Buka http://localhost/tevfiq_cell/register.php untuk daftar akun baru.

    Login dengan akun yang baru dibuat.

    Pilih menu Pulsa atau Paket Data.

    Setelah beli, cek menu Riwayat Transaksi. Status awal pasti PENDING.

    Status baru berubah SUKSES jika Admin sudah mengklik "Terima".

📂 Struktur Folder & Penjelasan File

Buat kamu yang ingin belajar kodingannya, berikut fungsinya:

    koneksi.php: Jantung aplikasi. Menghubungkan PHP ke Database.

    index.php: Halaman utama User (Dashboard Belanja).

    admin.php: Dashboard utama Admin (List Pesanan).

    login.php & register.php: Gerbang masuk autentikasi.

    proses_beli.php: "Mesin" di balik layar yang memproses inputan user ke database.

    kelola_paket.php: Halaman CRUD (Create, Read, Delete) paket data.

    edit_paket.php: Halaman khusus untuk mengedit harga/nama paket (Update).

    riwayat.php: Halaman khusus user melihat belanjaannya sendiri.

    cetak_pdf.php: Script generate laporan menggunakan library FPDF.

    cetak_excel.php: Script hack header untuk download file .xls.

    style.css: File CSS agar tampilan web cantik dan responsif.

    vendor/: Folder berisi library FPDF (Jangan dihapus!).

❓ Troubleshooting (Masalah Umum)

Q: Muncul Error Fatal error: Uncaught Error: Call to undefined function mysqli_connect()

    Solusi: Pastikan ekstensi mysqli di PHP kamu aktif. Jika di Linux, install dengan sudo dnf install php-mysqli.

Q: Muncul Error 500 saat Login

    Solusi: Cek file koneksi.php. Coba ganti $host = "localhost" menjadi $host = "127.0.0.1".

Q: Saat print PDF error failed to open stream

    Solusi: Pastikan folder vendor ada di dalam folder proyek kamu. Jika hilang, kamu harus mendownload library FPDF dan menaruhnya di sana.

Q: Gambar/CSS tidak muncul?

    Solusi: Pastikan kamu membuka lewat localhost/folder, BUKAN klik kanan file -> Open with Browser.
