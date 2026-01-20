<?php
include '../config/database.php';

// Ambil data kategori untuk dropdown
$kategori_result = $conn->query("SELECT * FROM kategori");

if (isset($_POST['submit'])) {
    $kode       = $_POST['kode_produk'];
    $nama       = $_POST['nama_produk'];
    $kategori   = $_POST['id_kategori'];
    $beli       = $_POST['harga_beli'];
    $jual       = $_POST['harga_jual'];
    $stok       = $_POST['stok'];

    // LOGIKA UPLOAD GAMBAR
    $gambar = $_FILES['gambar']['name'];
    $tmp_name = $_FILES['gambar']['tmp_name'];
    
    if($gambar != "") {
        $ekstensi_diperbolehkan = array('png', 'jpg', 'jpeg');
        $x = explode('.', $gambar);
        $ekstensi = strtolower(end($x));
        $nama_gambar_baru = date('dmYHis') . '-' . $gambar; // Rename agar unik
        
        if(in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
            move_uploaded_file($tmp_name, '../uploads/' . $nama_gambar_baru);
        } else {
            echo "<script>alert('Format gambar harus JPG/PNG!');</script>";
            exit;
        }
    } else {
        $nama_gambar_baru = 'default.png';
    }

    // QUERY DENGAN PREPARED STATEMENT (AMAN DARI HACKER)
    $stmt = $conn->prepare("INSERT INTO produk (kode_produk, nama_produk, id_kategori, harga_beli, harga_jual, stok, gambar) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiddis", $kode, $nama, $kategori, $beli, $jual, $stok, $nama_gambar_baru);

    if ($stmt->execute()) {
        $status = "success";
        $pesan = "Produk berhasil ditambahkan ke Database!";
    } else {
        $status = "error";
        $pesan = "Gagal: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - Tevfiq Cell</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { background-color: #f8f9fa; }
        .card { border: none; shadow: 0 4px 8px rgba(0,0,0,0.1); border-radius: 12px; }
        .preview-img { max-width: 100%; height: 200px; object-fit: cover; border-radius: 8px; display: none; margin-top: 10px; border: 2px dashed #ccc;}
    </style>
</head>
<body>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card p-4">
                <h3 class="text-center text-primary mb-4 fw-bold">📦 Tambah Produk Tevfiq Cell</h3>
                
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Kode Produk (SKU)</label>
                                <input type="text" name="kode_produk" class="form-control" placeholder="Cth: TSEL-10K" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Produk</label>
                                <input type="text" name="nama_produk" class="form-control" placeholder="Cth: Telkomsel 10.000" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Kategori</label>
                                <select name="id_kategori" class="form-select" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <?php while($row = $kategori_result->fetch_assoc()): ?>
                                        <option value="<?= $row['id_kategori'] ?>"><?= $row['nama_kategori'] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <label class="form-label">Harga Beli (Modal)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" name="harga_beli" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <label class="form-label">Harga Jual</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" name="harga_jual" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Stok Awal</label>
                                <input type="number" name="stok" class="form-control" value="0" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Foto Produk</label>
                                <input type="file" name="gambar" id="inputGambar" class="form-control" accept="image/*" onchange="previewImage()">
                                <img id="preview" class="preview-img">
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" name="submit" class="btn btn-primary btn-lg">💾 Simpan Produk</button>
                        <a href="index.php" class="btn btn-outline-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Preview Gambar sebelum upload
    function previewImage() {
        const input = document.getElementById('inputGambar');
        const preview = document.getElementById('preview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Tampilkan Alert jika PHP mengirim status sukses/gagal
    <?php if(isset($status)): ?>
        Swal.fire({
            title: '<?= ($status == "success") ? "Berhasil!" : "Gagal!" ?>',
            text: '<?= $pesan ?>',
            icon: '<?= $status ?>',
            confirmButtonText: 'OK'
        });
    <?php endif; ?>
</script>

</body>
</html>