<?php
require 'ceklogin.php';

if(isset($_GET['idp'])){
    $idp = $_GET['idp'];

    $ambilnamapelanggan = mysqli_query($c, "select * from pesanan p, pelanggan pl where p.id_pelanggan=pl.id_pelanggan and p.id_pesanan='$idp'");
    $np = mysqli_fetch_array($ambilnamapelanggan);
    $namapel = $np['namapelanggan'];
} else {
    header('location:index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Data Pesanan</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <script>

const form = document.getElementById('formNominal');
        const nominalInput = document.getElementById('nominal');
        const submitBtn = document.getElementById('submitBtn');
        const nominalResult = document.getElementById('nominalResult');

        // Menangani aksi klik pada tombol OK
        submitBtn.addEventListener('click', function() {
            const nominalValue = nominalInput.value; // Mengambil nilai dari input

            // Memastikan input nominal tidak kosong
            if (nominalValue !== '') {
                // Menampilkan nilai nominal di bawah form
                nominalResult.textContent = nominalValue;
                // Menyimpan nilai nominal dalam input, supaya tidak hilang
                localStorage.setItem('nominal', nominalValue);
            }
        });

        // Menyimpan nilai dari localStorage jika ada saat halaman dimuat
        window.addEventListener('load', function() {
            const savedNominal = localStorage.getItem('nominal');
            if (savedNominal) {
                nominalResult.textContent = savedNominal; // Menampilkan nilai yang tersimpan
                nominalInput.value = savedNominal; // Menyimpan nilai input dalam form
            }
        });

        let totalbayar = <?= $totalbayar; ?>; // Total bayar dari PHP
    $nominalResult = document.getElementById('nominalResult');
    $bayarSelect = document.getElementById('bayar');
    $formNominal = document.getElementById('formNominal');

    // Fungsi untuk cek metode pembayaran yang dipilih
    function checkPaymentMethod() {
        const pembayaran = bayarSelect.value;

        // Jika memilih QRIS, langsung tampilkan pop-up berhasil
        if (pembayaran === 'qris') {
            alert("Pembayaran Berhasil");
            formNominal.style.display = 'none'; // Sembunyikan input nominal untuk QRIS
            kembalianInput.value = ''; // Kosongkan kembalian
        } else {
            formNominal.style.display = 'block'; // Tampilkan form nominal jika pilih Tunai
        }
    }

     // Fungsi untuk menghitung kembalian
     function hitungKembalian() {
        $nominalInput = document.getElementById('nominal');
        $kembalianInput = document.getElementById('kembalian');
        $totalbayar = <?=$totalbayar;?>;

        // Konversi nilai input menjadi angka
        $dibayarkan = parseFloat(nominalInput.value);

        if (!isNaN(dibayarkan)) {
            if (dibayarkan >= totalBayar) {
                const kembalian = dibayarkan - totalBayar;
                kembalianInput.value = kembalian.toLocaleString('id-ID'); // Format angka sesuai format Indonesia
            } else {
                kembalianInput.value = "Jumlah kurang!";
            }
        } else {
            kembalianInput.value = "";
        }

        nominalInput.addEventListener('input', hitungKembalian);


        event.preventDefault(); // Mencegah form submit
        const nominal = parseFloat(nominalInput.value);
        if (nominal >= totalbayar) {
            const kembalian = nominal - totalbayar;
            kembalianInput.value = kembalian.toFixed(0); // Menampilkan kembalian
            nominalResult.textContent = nominal.toLocaleString(); // Menampilkan nominal yang dimasukkan
            alert("Pembayaran Berhasil! Kembalian: Rp" + kembalian.toFixed(0)); // Tampilkan pesan berhasil
        } else {
            alert("Nominal yang dibayarkan kurang.");
        }
    }
    
    // Menyembunyikan input nominal jika QRIS dipilih
    formNominal.style.display = 'none';
    const totalBayar = <?= $totalbayar; ?>;

    /// Fungsi untuk menghitung kembalian
    function hitungKembalian() {
        const dibayarkan = parseFloat(document.getElementById("dibayarkan").value);
        const kembalianField = document.getElementById("kembalian");

        // Reset kembalian jika input kosong
        if (!dibayarkan) {
            kembalianField.value = "";
            return;
        }

        // Validasi input Dibayarkan
        if (dibayarkan < totalBayar) {
            kembalianField.value = "Jumlah kurang!";
            return;
        }

        // Hitung kembalian
        const kembalian = dibayarkan - totalBayar;

        // Update input kembalian
        kembalianField.value = kembalian.toLocaleString('id-ID');
    }

    // Event listener untuk menghitung kembalian otomatis
    document.getElementById("dibayarkan").addEventListener("input", hitungKembalian);
</script>

        <style>
            .custom-nav-link {
                position: fixed;
                top: 10px;
                right: 45px;
                font-size: 18px;
            }
            .container {
                text-align: right;
            }
        </style>
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php">Kid Chic</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link custom-nav-link" id="navbarDropdown" href="kasir.php" role="button">Kasir<i class="fas fa-user fa-fw"></i></a>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                        <div class="sb-sidenav-menu-heading">Menu</div>
                            <a class="nav-link" href="pesanan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-clipboard-list"></i></div>
                                Order
                            </a>
                            <a class="nav-link" href="stok.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tags"></i></div>
                                Stok Barang
                            </a>
                            <a class="nav-link" href="pelanggan.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></i></div>
                                Kelola Pelanggan
                            </a>
                            <a class="nav-link" href="logout.php">
                                Logout
                            </a>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <div class="small">Logged in as:</div>
                        Kasir
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Data Pesanan: <?=$idp;?></h1>
                        <h4 class="mt-4">Nama Pelanggan: <?=$namapel;?></h4>

                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Selamat Datang</li>
                        </ol>
                            
                        <button type="button" class="btn btn-info mb-4" data-bs-toggle="modal" data-bs-target="#myModal">
                            Tambah Barang
                        </button>

                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Data Pesanan
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Produk</th>
                                            <th>Harga Satuan</th>
                                            <th>Jumlah</th>
                                            <th>Sub-total</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                    $get = mysqli_query($c, "select * from detailpesanan p, produkk pr where p.id_produk=pr.id_produk and id_pesanan='$idp'");
                                    $i =1;
                                    $totalbayar = 0;

                                    while($p=mysqli_fetch_array($get)){
                                    $idpr = $p['id_produk'];
                                    $iddp = $p['id_detailpesanan'];
                                    $qty = $p['qty'];
                                    $harga = $p['harga'];
                                    $namaproduk = $p['namaproduk'];
                                    $desc = $p['deskripsi'];
                                    $subtotal = $qty*$harga;
                                    $totalbayar += $subtotal;

                                    ?>
                                        <tr>
                                            <td><?=$i++;?></td>
                                            <td><?=$namaproduk;?> (<?=$desc;?>)</td>
                                            <td>Rp<?=number_format($harga, 0, ',','.');?></td>
                                            <td><?=$qty;?></td>
                                            <td>Rp<?=number_format($subtotal, 0, ',','.');?></td>
                                            <td>
                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?=$idpr;?>">Edit</button>
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?=$idpr;?>">Hapus</button>
                                            </td>
                                        </tr>

                                        <!-- Modal Edit -->
                                        <div class="modal fade" id="edit<?=$idpr;?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Ubah Data Detail Pesanan</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>


                                            <form method="post">
                                            <!-- Modal body -->
                                                <div class="modal-body">
                                                    <input type="text" name="namaproduk" class="form-control mt-2" placeholder="Nama Produk" value="<?=$namaproduk;?>: <?=$desc;?>" disabled>
                                                    <input type="number" name="qty" class="form-control mt-2" placeholder="Jumlah" min="1" value="<?=$qty;?>">
                                                    <input type="hidden" name="iddp" value="<?=$iddp;?>">
                                                    <input type="hidden" name="idp" value="<?=$idp;?>">
                                                    <input type="hidden" name="idpr" value="<?=$idpr;?>">
                                                </div>

                                            <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success" name="editdetailpesanan">Submit</button>
                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </form>

                                            </div>
                                        </div>
                                        </div>

                                            <!-- Modal Delete -->
                                            <div class="modal fade" id="delete<?=$idpr;?>">
                                                <div class="modal-dialog">
                                                <div class="modal-content">

                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Apakah Anda Yakin Ingin Menghapus Barang Ini?</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>


                                            <form method="post">

                                            <!-- Modal body -->
                                                <div class="modal-body">                                        
                                                    Apakah Anda Ingin Menghapus Barang Ini?
                                                    <input type="hidden" name="idp" value="<?=$iddp;?>">
                                                    <input type="hidden" name="idpr" value="<?=$idpr;?>">
                                                    <input type="hidden" name="id_pesanan" value="<?=$idp;?>">
                                                </div>

                                            <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success" name="hapusprodukpesanan">Ya</button>
                                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </form>
                                            </div>
                                        </div>
                                    </div>

                                <?php
                                    }; //end of while
                                    ?>
                                    </tbody>
                                </table>

                                <div class="container">
                                    <strong>Total Bayar:</strong> Rp<?=number_format($totalbayar, 0, ',','.');?><br>                                    
                                </div>

                            </div>
                        </div>
                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>

<!-- The Modal -->
<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Tambah Barang</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>


    <form method="post">
      <!-- Modal body -->
        <div class="modal-body">
            Pilih Barang
            <select name="id_produk" class="form-control">
            
            <?php
            $getproduk = mysqli_query($c, "select * from produkk where id_produk not in(select id_produk from detailpesanan where id_pesanan='$idp')");

            while($pl=mysqli_fetch_array($getproduk)){
                $id_produk = $pl['id_produk'];
                $namaproduk = $pl['namaproduk'];
                $stok = $pl['stok'];
                $deskripsi = $pl['deskripsi'];
            
            ?>

            <option value="<?=$id_produk;?>"><?=$namaproduk;?> - <?=$deskripsi;?> (Stok: <?=$stok;?>)</option>

            <?php
            }
            ?>
            </select> 

            <input type="number" name="qty" class="form-control mt-4" placeholder="Jumlah" min="1" required>
            <input type="hidden" name="idp" value="<?=$idp;?>">

        </div>

      <!-- Modal footer -->
        <div class="modal-footer">
            <button type="submit" class="btn btn-success" name="addproduk">Submit</button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        </div>
    </form>

    </div>
  </div>
</div>

</html>
