<?php
require 'ceklogin.php';

// Ambil bulan dan tahun dari parameter GET (default ke bulan dan tahun sekarang)
$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');

// Query data pesanan berdasarkan bulan dan tahun
$query = "SELECT p.id_pesanan, p.tanggal, pl.namapelanggan, 
                 SUM(dp.qty * pr.harga) AS total_bayar
          FROM pesanan p
          JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
          JOIN detailpesanan dp ON p.id_pesanan = dp.id_pesanan
          JOIN produkk pr ON dp.id_produk = pr.id_produk
          WHERE MONTH(p.tanggal) = '$bulan' AND YEAR(p.tanggal) = '$tahun'
          GROUP BY p.id_pesanan";

$result = mysqli_query($c, $query);

// Keterangan laporan
$keterangan_laporan = "$tahun";
if (!empty($_GET['bulan'])) {
    $nama_bulan = date('F', mktime(0, 0, 0, $bulan, 10)); // Konversi bulan ke nama bulan
    $keterangan_laporan = "$nama_bulan, $tahun";
}

// Hitung total transaksi dan pendapatan
$total_transaksi = mysqli_num_rows($result);
$total_pendapatan = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Kid Chic</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <script>
            function printReport() {
    var printContent = document.getElementById('reportTable').outerHTML; // Ambil HTML tabel
    var keteranganLaporan = `<?= $keterangan_laporan ?>`; // Keterangan laporan dari PHP

    var win = window.open('', '', 'height=800,width=1200');
    win.document.write('<html><head><title>Laporan Pesanan</title>');
    // Tambahkan link ke CSS Bootstrap atau gaya manual
    win.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">');
    // Tambahkan gaya inline khusus untuk garis tabel
    win.document.write('<style>');
    win.document.write('table { border-collapse: collapse; width: 100%; }');
    win.document.write('th, td { border: 1px solid black; text-align: left; padding: 8px; }');
    win.document.write('th { background-color: #f2f2f2; }');
    win.document.write('</style>');
    win.document.write('</head><body>');
    win.document.write('<h2 style="text-align:center;">Laporan Pesanan</h2>'); // Judul laporan
    win.document.write('<p style="text-align:center;">' + keteranganLaporan + '</p>'); // Tambahkan keterangan laporan
    win.document.write(printContent); // Tampilkan tabel
    win.document.write('</body></html>');
    win.document.close();
    win.print();
}



        </script>
        <style>
        .custom-nav-link {
                position: fixed;
                top: 10px;
                right: 45px;
                font-size: 18px;
        }
        #layoutSidenav {
            display: flex;
            flex-direction: row;
        }

        #layoutSidenav_nav {
            width: 250px; /* Lebar sidebar */
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 1040; /* Tingkatkan z-index jika diperlukan */
            background-color: #343a40; /* Warna sidebar */
        }

        #layoutSidenav_content {
            margin-left: 250px; /* Harus sesuai dengan lebar sidebar */
            width: calc(100% - 250px); /* Sesuaikan lebar konten */
            overflow-x: hidden;
            padding: 20px;
        }
        </style>
</head>
<body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="haladmin.php">Kid Chic</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link custom-nav-link" id="navbarDropdown" href="admin.php" role="button">Admin<i class="fas fa-user fa-fw"></i></a>
            </ul>
        </nav>
<div id="layoutSidenav">
    <!-- Sidebar -->
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading">Menu</div>
                    <a class="nav-link" href="laporan.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                        Laporan
                    </a>
                    <a class="nav-link" href="masuk.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-box-open"></i></div>
                        Barang Masuk
                    </a>
                    <a class="nav-link" href="setting.php">
                        <div class="sb-nav-link-icon"><i class="fas fa-cog"></i></div>
                        Pengaturan
                    </a>
                    <a class="nav-link" href="logout.php">
                        Logout
                    </a>
                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">Logged in as:</div>
                Admin
            </div>
        </nav>
    </div>
    <!-- Main Content -->
    <div id="layoutSidenav_content">
        <main>
            <div class="container mt-4">
                <h2 class="mb-4">Laporan Bulanan</h2>
                <!-- Filter Form -->
                <form method="GET" class="mb-4">
                    <div class="row">
                        <!-- Form filter bulan dan tahun -->
                        <div class="col-md-3">
                            <label for="bulan" class="form-label">Bulan</label>
                            <select name="bulan" id="bulan" class="form-select">
                                <?php for ($i = 1; $i <= 12; $i++): ?>
                                    <option value="<?= $i ?>" <?= $i == $bulan ? 'selected' : '' ?>><?= date('F', mktime(0, 0, 0, $i, 10)) ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="tahun" class="form-label">Tahun</label>
                            <select name="tahun" id="tahun" class="form-select">
                                <?php for ($i = 2020; $i <= date('Y'); $i++): ?>
                                    <option value="<?= $i ?>" <?= $i == $tahun ? 'selected' : '' ?>><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">&nbsp;</label>
                            <button type="submit" class="btn btn-primary w-100">Filter</button>
                        </div>
                    </div>
                </form>
                <!-- Tombol Cetak -->
                <button class="btn btn-success mb-3" onclick="printReport()"><i class="fa-solid fa-print"></i> Cetak Laporan</button>
                <!-- Tabel Laporan -->
                <p><strong>Keterangan Laporan:</strong> <?= $keterangan_laporan ?></p>
                <table class="table table-bordered" id="reportTable">
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Tanggal</th>
                        <th>Nama Pelanggan</th>
                        <th>Total Bayar</th>
                    </tr>
                </thead>
                    <!-- Tabel data -->
                    <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $row['id_pesanan'] ?></td>
                    <td><?= $row['tanggal'] ?></td>
                    <td><?= $row['namapelanggan'] ?></td>
                    <td>Rp<?= number_format($row['total_bayar'], 0, ',', '.') ?></td>
                </tr>
                <?php $total_pendapatan += $row['total_bayar']; ?>
                <?php endwhile; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total Transaksi</th>
                    <th><?= $total_transaksi ?></th>
                </tr>
                <tr>
                    <th colspan="3">Total Pendapatan</th>
                    <th>Rp<?= number_format($total_pendapatan, 0, ',', '.') ?></th>
                </tr>
            </tfoot>
                </table>
            </div>
        </main>
    </div>
</div>

<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
