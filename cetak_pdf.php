<?php
// --- PENTING: SESUAIKAN JALUR INI DENGAN LOKASI FILE FPDF ANDA ---
require('vendor/autoload.php'); // Atau require('fpdf/fpdf.php'); tergantung folder anda
require 'koneksi.php';

class PDF extends FPDF
{
    // Header Halaman
    function Header()
    {
        $this->SetFont('Arial','B',14);
        $this->Cell(0,10,'LAPORAN PENJUALAN TEVFIQ CELL',0,1,'C');
        $this->SetFont('Arial','',10);
        $this->Cell(0,5,'Data Riwayat Transaksi Seluruh User',0,1,'C');
        $this->Ln(10); // Spasi baris

        // Judul Kolom Tabel
        $this->SetFont('Arial','B',9);
        $this->SetFillColor(200,220,255); // Warna latar biru muda
        
        // Lebar tiap kolom (Total harus sekitar 190 untuk A4 Portrait)
        $this->Cell(10, 8, 'No', 1, 0, 'C', true);
        $this->Cell(35, 8, 'Tanggal', 1, 0, 'C', true);
        $this->Cell(30, 8, 'User', 1, 0, 'C', true);
        $this->Cell(30, 8, 'Nomor HP', 1, 0, 'C', true);
        $this->Cell(45, 8, 'Item', 1, 0, 'C', true);
        $this->Cell(25, 8, 'Harga', 1, 0, 'C', true);
        $this->Cell(15, 8, 'Status', 1, 1, 'C', true);
    }

    // Footer Halaman
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,'Halaman '.$this->PageNo().'/{nb}',0,0,'C');
    }
}

// Inisialisasi PDF (Portrait, mm, A4)
$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',9);

// Ambil Data
$query = mysqli_query($conn, "SELECT r.*, u.username FROM riwayat_pembelian r JOIN users u ON r.user_id = u.id ORDER BY r.tanggal DESC");
$no = 1;

while($row = mysqli_fetch_assoc($query)){
    $pdf->Cell(10, 8, $no, 1, 0, 'C');
    $pdf->Cell(35, 8, date('d/m/Y H:i', strtotime($row['tanggal'])), 1, 0, 'L');
    $pdf->Cell(30, 8, $row['username'], 1, 0, 'L');
    $pdf->Cell(30, 8, $row['nomor_hp'], 1, 0, 'L');
    // Gunakan MultiCell atau potong teks jika item terlalu panjang (opsional)
    // Di sini kita pakai Cell biasa
    $item_pendek = substr($row['item_beli'], 0, 22); // Potong biar tidak kepanjangan
    $pdf->Cell(45, 8, $item_pendek, 1, 0, 'L');
    
    $pdf->Cell(25, 8, number_format($row['total_harga']), 1, 0, 'R');
    
    // Status (Singkat jika perlu)
    $st = strtoupper($row['status']);
    if($st == 'SUKSES') $pdf->SetTextColor(0,100,0);
    else if($st == 'BATAL') $pdf->SetTextColor(150,0,0);
    else $pdf->SetTextColor(0,0,0);
    
    $pdf->Cell(15, 8, $st, 1, 1, 'C');
    $pdf->SetTextColor(0,0,0); // Reset warna hitam

    $no++;
}

$pdf->Output();
?>