<?php
session_start();
require 'koneksi.php';

// Cek Login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi - Tevfiq Cell</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* CSS Tambahan Khusus Tabel */
        .table-responsive {
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
        }
        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:hover { background-color: #f1f1f1; }
        
        .badge {
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 0.85em;
            font-weight: bold;
            color: white;
        }
        .bg-success { background-color: #28a745; }
        .bg-warning { background-color: #ffc107; color: #333; }
        .bg-danger { background-color: #dc3545; }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>Tevfiq Cell 導</h1>
            <nav>
                <ul>
                    <li><a href="index.php">猪 Kembali Belanja</a></li>
                    <li><a href="logout.php" style="color: #ffcccc;">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="card">
            <h2>Riwayat Pembelian Saya</h2>
            <p>Berikut adalah daftar transaksi yang pernah Anda lakukan:</p>
            
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Item</th>
                            <th>Nomor HP</th>
                            <th>Harga</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Query Khusus User Ini Saja
                        $query = mysqli_query($conn, "SELECT * FROM riwayat_pembelian WHERE user_id = '$id_user' ORDER BY tanggal DESC");
                        
                        // Cek jika belum ada transaksi
                        if(mysqli_num_rows($query) == 0){
                            echo "<tr><td colspan='6' style='text-align:center;'>Belum ada riwayat transaksi.</td></tr>";
                        }

                        $no = 1;
                        while ($row = mysqli_fetch_assoc($query)) {
                            // Warna status
                            $statusClass = 'bg-warning'; // Default pending
                            if ($row['status'] == 'sukses') {
                                $statusClass = 'bg-success';
                            } elseif ($row['status'] == 'batal') {
                                $statusClass = 'bg-danger';
                            }
                            
                            // Format Tanggal
                            $tanggal = date('d-m-Y H:i', strtotime($row['tanggal']));
                            
                            echo "<tr>
                                <td>{$no}</td>
                                <td>{$tanggal}</td>
                                <td>{$row['item_beli']}</td> 
                                <td>{$row['nomor_hp']}</td>
                                <td>Rp " . number_format($row['total_harga']) . "</td>
                                <td><span class='badge $statusClass'>" . strtoupper($row['status']) . "</span></td>
                            </tr>";
                            $no++;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 Tevfiq Cell.</p>
        </div>
    </footer>
</body>
</html>