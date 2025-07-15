<?php
require 'ceklogin.php';

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Informasi Akun</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <style>
        .custom-nav-link {
            position: fixed;
            top: 10px;
            right: 45px;
            font-size: 18px;
        }
        .layoutSidenav {
            display: flex;
            flex-direction: row;
        }
        .layoutSidenav_nav {
            width: 250px; /* Lebar sidebar */
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 1040; /* Tingkatkan z-index jika diperlukan */
            background-color: #343a40; /* Warna sidebar */
        }
        .layoutSidenav_content {
            margin-left: 250px; /* Harus sesuai dengan lebar sidebar */
            width: calc(100% - 250px); /* Sesuaikan lebar konten */
            overflow-x: hidden;
            padding: 20px;
        }
        .header {
            text-align: center; /* Pusatkan teks */
            margin-top: 40px; /* Tambahkan jarak dari atas */
            margin-bottom: 30px; /* Jarak dengan elemen berikutnya */
        }
        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .hero-right img { 
        max-width: 80%;
        height: auto;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba;
        }

        .hero-right {
        display: flex;
        justify-content: center;
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
<!-- Main Content -->
<div id="layoutSidenav_content">
        <main>
        <div class="header">
            <h2 class="mb-4">Informasi Kasir</h2>
        </div>            
    
        <div class="container mt-4">
                <div class="hero-right">
                    <img src="./img/1.jpg" alt="saya">
                </div>
                <!-- Filter Form -->
                <form method="GET" class="mb-4">
                    <div class="row">    
                <?php
                $get = mysqli_query($c, "select * from kasirr where level ='kasir'");

                while($p=mysqli_fetch_array($get)){
                    $namapengguna = $p['nama'];
                    $email = $p['email'];
                    $notelp = $p['telepon'];
                    $alamat = $p['alamat'];
                    $username = $p['username'];

                ?>
                <form class="mt-4">
                    <div class="mb-3">
                        <label for="namaPengguna" class="form-label">Nama Pengguna</label>
                        <input type="text" class="form-control" id="namaPengguna" value="<?=$namapengguna;?>" readonly>                    
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="email" value="<?=$email;?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="telepon" class="form-label">Telepon</label>
                        <input type="text" class="form-control" id="telepon" value="<?=$notelp;?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="alamat" rows="2" value="<?=$alamat;?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" value="<?=$username;?>" readonly>
                    </div>                     
                <?php
                };
                ?>
                <form class="mt-4">
                    <button type="submit" class="btn btn-warning me-2" style="width: auto;">Edit</button>
                    <button type="submit" class="btn btn-primary" style="width: auto;">Simpan</button>              
                </form>
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

</html>