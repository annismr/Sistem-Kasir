<?php
// Koneksi ke database
require 'ceklogin.php';// Pastikan file koneksi benar

// Validasi parameter `id`
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "ID Pesanan tidak ditemukan.";
    exit;
}

$idp = $_GET['id'];

// Ambil data pesanan dan pelanggan
$ambilnamapelanggan = mysqli_query($c, "SELECT p.id_pesanan, p.tanggal, pl.namapelanggan FROM pesanan p JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan 
                                    WHERE p.id_pesanan = '$idp'");
$np = mysqli_fetch_array($ambilnamapelanggan);

if (!$np) {
    echo "Pesanan tidak ditemukan.";
    exit;
}

$id_pesanan = $np['id_pesanan'];
$namapel = $np['namapelanggan'];
$tanggal = $np['tanggal'];

// Ambil detail pesanan
$get2 = mysqli_query($c, "SELECT dp.qty, pr.namaproduk, pr.harga 
                             FROM detailpesanan dp 
                             JOIN produkk pr ON dp.id_produk = pr.id_produk 
                             WHERE dp.id_pesanan = '$idp'");

$totalbayar = 0;
$items = [];
while ($p = mysqli_fetch_array($get2)) {
    $p['subtotal'] = $p['qty'] * $p['harga'];
    $totalbayar += $p['subtotal'];
    $items[] = $p;
}

// Ambil ID kasir dari sesi
$ambilkasir = mysqli_query($c, "SELECT nama FROM kasirr WHERE level = 'kasir' LIMIT 1");
$kasir = mysqli_fetch_array($ambilkasir);

$namakasir = $kasir ? $kasir['nama'] : 'Tidak Diketahui';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Struk</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { 
        font-family: Arial, sans-serif; 
        background-color: #f8f9fa;
        }
        .struk-container { 
            width: 400px; margin: 20px; padding: 15px; border: 1px solid; background-color: #fff; }
        .text-center { text-align: center; }
        .struk-container p {
        margin: 5px 0; /* Mengurangi jarak antar paragraf */
        }
        @media print {
        .no-print {
            display: none; /* Sembunyikan elemen dengan class 'no-print' saat mencetak */
        }
        }
    </style>
</head>
<body>
    <div class="struk-container">
        <div class="text-center">
            <h4>Struk Pesanan</h4>
            <strong>Kid Chic</strong><br>
            <strong>Jl. Mawar No. 123, Jakarta</strong><br>
            <strong>08123456789</strong><br>
        </div>
        <hr>
        <p><strong>Nomor Transaksi:</strong> <?= $id_pesanan; ?></p>
        <p><strong>Customer:</strong> <?= $namapel; ?></p>
        <p><strong>Tanggal:</strong> <?= $tanggal; ?></p>
        <p><strong>Kasir:</strong> <?= $namakasir; ?></p>
        <hr>
        <strong>Detail Pesanan</strong>
        <?php foreach ($items as $item): ?>
            <p><?= $item['namaproduk']; ?> - <?= $item['qty']; ?> @ Rp<?= number_format($item['harga'], 0, ',', '.'); ?> = Rp<?= number_format($item['subtotal'], 0, ',', '.'); ?></p>
        <?php endforeach; ?>
        <hr>
        <p><strong>Metode Pembayaran:</strong> Tunai</p>
        <p><strong>Total Bayar:</strong> Rp<?= number_format($totalbayar, 0, ',', '.'); ?></p>
        <p><strong>Dibayarkan:</strong> Rp<?= number_format($totalbayar, 0, ',', '.'); ?></p>
        <p><strong>Kembalian:</strong> Rp0</p>
        <hr>
        <div class="text-center no-print">
            <button class="btn btn-primary" onclick="window.print()">Cetak</button>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</body>
</html>
