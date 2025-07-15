<?php 

session_start();

//bikin koneksi
$c = mysqli_connect('localhost','root','','kasir');

//function login
if(isset($_POST['login'])){
    //initiate variabel
    $username = $_POST['username'];
    $password = $_POST['password'];

    $check = mysqli_query($c, "SELECT * FROM user WHERE username='$username' and password='$password' ");
    $hitung = mysqli_num_rows($check);

    //cek apakah username dan pw ada di database
    if($hitung>0){

        $data = mysqli_fetch_assoc($check);

        //cek jika user login sebagai kasir
        if(strtolower($data['level'])=="kasir"){

        //buat session login dan username
        $_SESSION['login'] = $username;
        $_SESSION['level'] = "kasir";
        //alihkan ke halaman dashboard kasir
        header('location:index.php');
        exit;

        //cek jika user login sebagai admin
        } else if (strtolower($data['level'])=="admin"){

        //buat session login dan username 
        $_SESSION['login'] = $username;
        $_SESSION['level'] = "admin";
        //alihkan ke halaman dahsboard admin
        header('location:haladmin.php');
        //data tidak ditemukan, maka gagal login
        exit;
        } else {
            //alihkan ke halaman login lagi 
            echo '
            <script>alert("User Tidak Ditemukan");
            window.location.href="login.php"
            </script>
            ';
        }
    } else {
        echo '
        <script>alert("Username atau Password Salah");
        window.location.href="login.php"
        </script>
        ';
    }
}



if(isset($_POST['tambahbarang'])){
    $namaproduk = $_POST['namaproduk'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    
    //soal gambar
    $allwoed_extension = array('png','jpg');
    $nama = $_FILES['file']['name']; //ngambil nama foto 
    $dot = explode('.',$nama);
    $ekstensi = strtolower(end($dot)); //ngambil ekstensi nya
    $ukuran = $_FILES['file']['size']; //ngambil size file nya
    $file_tmp = $_FILES['file']['tmp_name']; //ngambil lokasi file nya

    //penamaan file --> enkripsi 
    $image = md5(uniqid($nama,true) . time().'.'.$ekstensi); //menggabungkan nama file yg dienkripsi dengan ekstensinya 
    $cek = mysqli_query($c, "select * from produkk where namaproduk='$namaproduk'");
    $hitung = mysqli_num_rows($cek);

    if($hitung<1){

        //proses upload gambar  
        if(in_array($ekstensi, $allwoed_extension) === true){
            //validasi ukuran file 
            if($ukuran < 15000000){
                move_uploaded_file($file_tmp, 'img/'.$image);

                $insert = mysqli_query($c,"insert into produkk (namaproduk, deskripsi, harga, stok, image) values ('$namaproduk','$deskripsi','$harga','$stok','$image')");
                if($insert){
                header('location:stok.php');
                } else {
                    echo 'Gagal';
                    header('location:stok.php');
                }
            } else {
                //kalo file nya lebih dari 15mb
                echo '
                <script>
                    alert("Ukuran Terlalu Besar");
                    window.location.href:"stok.php";
                </script>
                ';
            }
        } else {
            //kalo gambar nya ga .png/.jgp
            echo '
            <script>
                alert("File Harus .png atau .jpg");
                window.location.href:"stok.php";
            </script>
            ';
        }
    }

    $insert = mysqli_query($c,"insert into produkk (namaproduk, deskripsi, harga, stok, images) values ('$namaproduk','$deskripsi','$harga','$stok','$image')");

    if($insert){
        header('location:stok.php');
    } else {
        echo '
        <script>alert("Gagal Menambah Barang Baru");
        window.location.href="stok.php"
        </script>
        ';
    }
}

if(isset($_POST['tambahpelanggan'])){
    $namapelanggan = $_POST['namapelanggan'];
    $notelp = $_POST['notelp'];
    $alamat = $_POST['alamat'];

    $insert = mysqli_query($c,"insert into pelanggan (namapelanggan, notelp, alamat) values ('$namapelanggan','$notelp','$alamat')");

    if($insert){
        header('location:pelanggan.php');
    } else {
        echo '
        <script>alert("Gagal Menambah Pelanggan Baru");
        window.location.href="pelanggan.php"
        </script>
        ';
    }
}

if(isset($_POST['tambahpesanan'])){
    $id_pelanggan = $_POST['id_pelanggan'];

    $insert = mysqli_query($c,"insert into pesanan (id_pelanggan) values ('$id_pelanggan')");

    if($insert){
        header('location:pesanan.php');
    } else {
        echo '
        <script>alert("Gagal Menambah Pesanan Baru");
        window.location.href="pesanan.php"
        </script>
        ';
    }
}

//produk dipilih di pesanan
if(isset($_POST['addproduk'])){
    $id_produk = $_POST['id_produk'];
    $idp = $_POST['idp'];
    $qty = $_POST['qty'];

    //hitung stok sekarang 
    $hitung1 = mysqli_query($c, "select * from produkk where id_produk='$id_produk'");
    $hitung2 = mysqli_fetch_array($hitung1);
    $stoksekarang = $hitung2['stok']; //stok barang saat ini

    if($stoksekarang>=$qty){

        //kurangi stok dengan jumlah yang akan dikeluarkan 
        $selisih = $stoksekarang - $qty;

        //stok nya cukup
        $insert = mysqli_query($c,"insert into detailpesanan (id_pesanan, id_produk, qty) values ('$idp','$id_produk','$qty')");
        $update = mysqli_query($c, "update produkk set stok='$selisih' where id_produk='$id_produk'");

        if($insert&&$update){
            header('location:view.php?idp='.$idp);
        } else {
            echo '
            <script>alert("Gagal Menambah Pesanan Baru");
            window.location.href="view.php?idp='.$idp.'"
            </script>
            ';
        } 
    } else {
        //stok ga cukup 
        echo '
        <script>alert("Stok Barang Tidak Cukup");
        window.location.href="view.php?idp='.$idp.'"
        </script>
        ';
    }

}

if(isset($_POST['barangmasuk'])){
    $id_produk = $_POST['id_produk'];
    $qty = $_POST['qty'];

    //cari tau stok sekarang 
    $caristok = mysqli_query($c, "select * from produkk where id_produk='$id_produk' ");
    $caristok2 = mysqli_fetch_array($caristok);
    $stoksekarang = $caristok2 ['stok'];

    //hitung 
    $newstok = $stoksekarang+$qty; 

    $insertb = mysqli_query($c,"insert into masuk (id_produk, qty) values ('$id_produk','$qty')");
    $updateb = mysqli_query($c, "update produkk set stok='$newstok' where id_produk='$id_produk' ");

    if($insertb&&$updateb){
        header('location:masuk.php');
    } else {
        echo '
        <script>alert("Gagal");
        window.location.href="masuk.php"
        </script>
        ';
    }
}

if(isset($_POST['hapusprodukpesanan'])){
    $idp = $_POST['idp'];
    $idpr = $_POST['idpr'];
    $id_pesanan = $_POST['id_pesanan'];

    //cek qty sekarang
    $cek1 = mysqli_query($c, "select * from detailpesanan where id_detailpesanan='$idp'");
    $cek2 = mysqli_fetch_array($cek1);
    $qtysekarang = $cek2['qty'];

    //cek stok sekarang
    $cek3 = mysqli_query($c, "select * from produkk where id_produk='$idpr'");
    $cek4 = mysqli_fetch_array($cek3);
    $stoksekarang = $cek4['stok'];

    //hitung
    $hitung = $stoksekarang + $qtysekarang;

    $update = mysqli_query($c, "update produkk set stok='$hitung' where id_produk='$idpr'"); // update stok
    $hapus = mysqli_query($c, "delete from detailpesanan where id_produk='$idpr' and id_detailpesanan='$idp'");

    if($update&&$hapus){
        header('location:view.php?idp='.$id_pesanan);
    } else {
        echo '
        <script>alert("Gagal Menghapus Barang");
        window.location.href="view.php?idp='.$id_pesanan.'"
        </script>
        ';
    }
}

if(isset($_POST['editbarang'])){
    $np = $_POST['namaproduk'];
    $desc = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $idp = $_POST['idp'];

    $query = mysqli_query($c,"update produkk set namaproduk='$np', deskripsi='$desc', harga='$harga' where id_produk='$idp' ");

    if($query){
        header('location:stok.php');
    } else {
        echo '
        <script>alert("Gagal");
        window.location.href="stok.php"
        </script>
        ';
    }
}

if(isset($_POST['hapusbarang'])){
    $idp = $_POST['idp'];

    $gambar = mysqli_query($c, "select * from produkk where id_produk='$idp'");
    $get = mysqli_fetch_array($gambar);
    $img = 'image/'.$get['image'];
    unlink($img);

    $query = mysqli_query($c,"delete from produkk where id_produk='$idp' ");

    if($query){
        header('location:stok.php');
    } else {
        echo '
        <script>alert("Gagal");
        window.location.href="stok.php"
        </script>
        ';
    }
}

if(isset($_POST['editpelanggan'])){
    $np = $_POST['namapelanggan'];
    $nt = $_POST['notelp'];
    $a = $_POST['alamat'];
    $id = $_POST['idpl'];

    $query = mysqli_query($c,"update pelanggan set namapelanggan='$np', notelp='$nt', alamat='$a' where id_pelanggan='$id' ");

    if($query){
        header('location:pelanggan.php');
    } else {
        echo '
        <script>alert("Gagal");
        window.location.href="pelanggan.php"
        </script>
        ';
    }
}

if(isset($_POST['hapuspelanggan'])){
    $idpl = $_POST['idpl'];

    $query = mysqli_query($c,"delete from pelanggan where id_pelanggan='$idpl' ");

    if($query){
        header('location:pelanggan.php');
    } else {
        echo '
        <script>alert("Gagal");
        window.location.href="pelanggan.php"
        </script>
        ';
    }
}

//hapus data barang masuk
if(isset($_POST['editdatabarangmasuk'])){
    $idm = $_POST['idm'];
    $qty = $_POST['qty'];
    $idp = $_POST['idp'];

    //cari tau qty sekarang 
    $caritau = mysqli_query($c, "select * from masuk where id_masuk='$idm'");
    $caritau2 = mysqli_fetch_array($caritau);
    $qtysekarang = $caritau2['qty'];
    
    //cari tau stok sekarang
    $caristok = mysqli_query($c, "select * from produkk where id_produk='$idp' ");
    $caristok2 = mysqli_fetch_array($caristok);
    $stoksekarang = $caristok2['stok'];


    if($qty >= $qtysekarang){
        //kalo inputan user lebih besar dari qty yg tercatat
        //hitung selisih 
        $selisih = $qty-$qtysekarang;
        $newstok = $stoksekarang+$selisih;

        $query1 = mysqli_query($c,"update masuk set qty='$qty' where id_masuk='$idm' ");
        $query2 = mysqli_query($c,"update produkk set stok='$newstok' where id_produk='$idp' ");

        if($query1&&$query2){
            header('location:masuk.php');
        } else {
            echo '
            <script>alert("Gagal");
            window.location.href="masuk.php"
            </script>
            ';
        }

    } else {
        //kalo inputan user lebih kecil dari qty yg tercatat
        //hitung selisih 
        $selisih = $qtysekarang-$qty;
        $newstok = $stoksekarang-$selisih;

        $query1 = mysqli_query($c,"update masuk set qty='$qty' where id_masuk='$idm' ");
        $query2 = mysqli_query($c,"update produkk set stok='$newstok' where id_produk='$idp' ");


        if($query1&&$query2){
            header('location:masuk.php');
        } else {
            echo '
            <script>alert("Gagal");
            window.location.href="masuk.php"
            </script>
            ';
        }
    } 
}

if(isset($_POST['hapusdatabarangmasuk'])){
    $idm = $_POST['idm'];
    $idp = $_POST['idp'];

    //cari tau qty sekarang 
    $caritau = mysqli_query($c, "select * from masuk where id_masuk='$idm'");
    $caritau2 = mysqli_fetch_array($caritau);
    $qtysekarang = $caritau2['qty'];
    
    //cari tau stok sekarang
    $caristok = mysqli_query($c, "select * from produkk where id_produk='$idp' ");
    $caristok2 = mysqli_fetch_array($caristok);
    $stoksekarang = $caristok2['stok'];

    //hitung selisih 
    $newstok = $stoksekarang-$qtysekarang;

    $query1 = mysqli_query($c,"delete from masuk where id_masuk='$idm' ");
    $query2 = mysqli_query($c,"update produkk set stok='$newstok' where id_produk='$idp' ");

        if($query1&&$query2){
            header('location:masuk.php');
        } else {
            echo '
            <script>alert("Gagal");
            window.location.href="masuk.php"
            </script>
            ';
        }
    }

if(isset($_POST['hapuspesanan'])){
    $idps = $_POST['idps'];

    $cekdata = mysqli_query($c, "select * from detailpesanan dp where id_pesanan='$idps' ");

    $querydelete = true;
    $queryupdate = true;

    while($ok=mysqli_fetch_array($cekdata)){
        //balikin stok
        $qty = $ok['qty'];
        $id_produk = $ok['id_produk'];
        $iddpt = $ok['id_detailpesanan'];

        //cari tau stok sekarang
        $caristok = mysqli_query($c, "select * from produkk where id_produk='$id_produk' ");
        $caristok2 = mysqli_fetch_array($caristok);
        $stoksekarang = $caristok2['stok'];

        //hitung selisih 
        $newstok = $stoksekarang+$qty;

        $queryupdate = mysqli_query($c,"update produkk set stok='$newstok' where id_produk='$id_produk' ");

        //hapus data
        $querydelete = mysqli_query($c, "delete from detailpesanan where id_detailpesanan='$iddp' ");
    }

    $query = mysqli_query($c,"delete from pesanan where id_pesanan='$idps' ");

    if($queryupdate && $querydelete && $query){
        header('location:pesanan.php');
    } else {
        echo '
        <script>alert("Gagal");
        window.location.href="pesanan.php"
        </script>
        ';
        }
    }

//edit data detail pesanan
if(isset($_POST['editdetailpesanan'])){
        $qty = $_POST['qty'];
        $iddp = $_POST['iddp'];
        $idpr = $_POST['idpr'];
        $idp = $_POST['idp'];
    
        //cari tau qty sekarang 
        $caritau = mysqli_query($c, "select * from detailpesanan where id_detailpesanan='$iddp'");
        $caritau2 = mysqli_fetch_array($caritau);
        $qtysekarang = $caritau2['qty'];
        
        //cari tau stok sekarang
        $caristok = mysqli_query($c, "select * from produkk where id_produk='$idpr' ");
        $caristok2 = mysqli_fetch_array($caristok);
        $stoksekarang = $caristok2['stok'];
    
    
        if($qty >= $qtysekarang){
            //kalo inputan user lebih besar dari qty yg tercatat
            //hitung selisih 
            $selisih = $qty-$qtysekarang;
            $newstok = $stoksekarang-$selisih;
    
            $query1 = mysqli_query($c,"update detailpesanan set qty='$qty' where id_detailpesanan='$iddp' ");
            $query2 = mysqli_query($c,"update produk set stok='$newstok' where id_produk='$idpr' ");
    
            if($query1&&$query2){
                header('location:view.php?idp='.$idp);
            } else {
                echo '
                <script>alert("Gagal");
                window.location.href="view.php?idp='.$idp.'"
                </script>
                ';
            }
    
        } else {
            //kalo inputan user lebih kecil dari qty yg tercatat
            //hitung selisih 
            $selisih = $qtysekarang-$qty;
            $newstok = $stoksekarang+$selisih;
    
            $query1 = mysqli_query($c,"update detailpesanan set qty='$qty' where id_detailpesanan='$iddp' ");
            $query2 = mysqli_query($c,"update produkk set stok='$newstok' where id_produk='$idp' ");
    
    
            if($query1&&$query2){
                header('location:view.php?idp='.$idp);
            } else {
                echo '
                <script>alert("Gagal");
                window.location.href="view.php?idp='.$idp.'"
                </script>
                ';
            }
        } 
    }

if(isset($_POST['cart'])){
    $id_pelanggan = $_POST['id_pelanggan'];
    
    $insert = mysqli_query($c,"insert into pesanan (id_pelanggan) values ('$id_pelanggan')");
    
    if($insert){
        header('location:cart.php');
    } else {
        echo '
        <script>alert("Gagal Menambahkan Produk");
        window.location.href="cart.php"
        </script>
        ';
    }
}

if(isset($_POST['hitungKembalian'])){
    $id_pelanggan = $_POST['id_pelanggan'];
    $dibayarkan = $_POST['dibayarkan'];
    $total_bayar = $_POST['total_bayar'];

    //hitung kembalian 
    $kembalian = $dibayarkan - $totalbayar;
        
    if($kembalian >= 0){
        $insert = mysqli_query($c, "INSERT INTO pesanan (id_pelanggan, total_bayar, dibayarkan, kembalian) VALUES ('$id_pelanggan', '$total_bayar', '$dibayarkan', '$kembalian')");

        if($insert) {
        header('location:view.php');
        } else {
        echo "error";
        } 
    } else {
        echo "error";
    }
}

if(isset($_POST['cetak'])){
    $id_pesanan = $_POST['id_pesanan'];
    $totalbayar = 0;

    $ambilnamapelanggan = mysqli_query($c, "SELECT * FROM pesanan p, pelanggan pl WHERE p.id_pelanggan=pl.id_pelanggan AND p.id_pesanan='$id_pesanan'");
    $np = mysqli_fetch_array($ambilnamapelanggan);
    
    echo "
    <div class='mb-3'>
        <strong>Nomor Transaksi:</strong> {$np['id_pesanan']}<br>
        <strong>Customer:</strong> {$np['namapelanggan']}<br>
        <strong>Tanggal:</strong> {$np['tanggal']}<br>
        <strong>Kasir:</strong> Budi
    </div>
    ";

    $get2 = mysqli_query($c, "SELECT * FROM detailpesanan dp, produk pr WHERE dp.id_produk=pr.id_produk AND dp.id_pesanan='$id_pesanan'");

    while ($p = mysqli_fetch_array($get2)) {
        $qty = $p['qty'];
        $harga = $p['harga'];
        $namaproduk = $p['namaproduk'];
        $subtotal = $qty * $harga;
        $totalbayar += $subtotal;
        $i =1;
    
        echo "
        <div class='mb-3'>
            <p><?=$i++;?></p>
            <p>{$namaproduk} - {$qty} - Rp" . number_format($subtotal, 0, ',', '.') . "</p>
        </div>";
    }
    // Tampilkan total pembayaran
    echo "
    <div class='mb-3'>
        <strong>Total Bayar:</strong> Rp" . number_format($totalbayar, 0, ',', '.') . "<br>
    </div>";
}

?>