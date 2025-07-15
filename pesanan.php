<?php
require 'ceklogin.php';

//Hitung jumlah pesanan 
$h1 = mysqli_query($c, "select * from pesanan");
$h2 = mysqli_num_rows($h1); //jumlah pesanan

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
            function printReport() {
            var printContent = document.getElementById('reportTable');
            var win = window.open('', '', 'height=800,width=1200');
            win.document.write('<html><head><title>Struk Pesanan</title></head><body>');
            win.document.write(printContent.innerHTML);
            win.document.write('</body></html>');
            win.document.close();
            win.print();
            }
            button.addEventListener('click', function () {
            const idPesanan = this.getAttribute('data-id');
            
            // Mengambil data pesanan melalui AJAX
            fetch(`get_struk.php?id_pesanan=${idPesanan}`)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('struk-detail').innerHTML = data;
                });
            
            // Buka modal cetak
            const cetakModal = new bootstrap.Modal(document.getElementById('cetak'));
            cetakModal.show();
            });
        </script>
        <style>
            .custom-nav-link {
                position: fixed;
                top: 10px;
                right: 45px;
                font-size: 18px;
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
                        <h1 class="mt-4">Data Pesanan</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Selamat Datang</li>
                        </ol>
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Jumlah Pesanan: <?=$h2;?></div>
                                </div>
                            </div>
                        </div>
                            
                        <button type="button" class="btn btn-info mb-4" data-bs-toggle="modal" data-bs-target="#myModal">
                            Tambah Pesanan Baru
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
                                            <th>ID Pesanan</th>
                                            <th>Tanggal</th>
                                            <th>Nama Pelanggan</th>
                                            <th>Jumlah</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                    $get = mysqli_query($c, "select * from pesanan p, pelanggan pl where p.id_pelanggan=pl.id_pelanggan");

                                    while($p=mysqli_fetch_array($get)){
                                    $id_pesanan = $p['id_pesanan'];
                                    $tanggal = $p['tanggal'];
                                    $namapelanggan = $p['namapelanggan'];
                                    $alamat = $p['alamat'];

                                    //hitung alamat 
                                    $hitungjumlah = mysqli_query($c, "select * from detailpesanan where id_pesanan='$id_pesanan'");
                                    $jumlah = mysqli_num_rows($hitungjumlah);
                                    ?>
                                        <tr>
                                            <td><?=$id_pesanan;?></td>
                                            <td><?=$tanggal;?></td>
                                            <td><?=$namapelanggan;?> - <?=$alamat;?></td>
                                            <td><?=$jumlah;?></td>
                                            <td>
                                                <a href="view.php?idp=<?=$id_pesanan;?>" class="btn btn-primary" target="blank">Tampilkan</a>                                                
                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete<?=$id_pesanan;?>">Delete</button>                        
                                                <button type="button" class="btn btn-warning" onclick="window.location.href='cetak.php?id=<?=$p['id_pesanan'];?>'"><i class="fa-solid fa-print"></i> Cetak Struk</button>                        
                                            </td>
                                            
                                        </tr>

                                         <!-- Modal Delete -->
                                         <div class="modal fade" id="delete<?=$id_pesanan;?>">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Hapus Data Pesanan</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>


                                            <form method="post">
                                            <!-- Modal body -->
                                                <div class="modal-body">
                                                    Apakah Anda Yakin Ingin Menghapus Data Pesanan Ini?
                                                    <input type="hidden" name="idps" value="<?=$id_pesanan;?>">
                                                </div>

                                            <!-- Modal footer -->
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success" name="hapuspesanan">Submit</button>
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
        <h4 class="modal-title">Tambah Pesanan Baru</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>


    <form method="post">
      <!-- Modal body -->
        <div class="modal-body">
            Pilih Pelanggan
            <select name="id_pelanggan" class="form-control">
            
            <?php
            $getpelanggan = mysqli_query($c, "select * from pelanggan");

            while($pl=mysqli_fetch_array($getpelanggan)){
                $namapelanggan = $pl['namapelanggan'];
                $id_pelanggan = $pl['id_pelanggan'];
                $alamat = $pl['alamat'];
            
            ?>

            <option value="<?=$id_pelanggan;?>"><?=$namapelanggan;?> - <?=$alamat;?></option>

            <?php
            }
            ?>
            </select> 
        </div>

      <!-- Modal footer -->
        <div class="modal-footer">
            <button type="submit" class="btn btn-success" name="tambahpesanan">Submit</button>
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        </div>
    </form>

    </div>
  </div>
</div>

</html>