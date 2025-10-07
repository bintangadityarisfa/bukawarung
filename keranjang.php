<?php
include "db.php";
error_reporting(0);

// Ambil data kontak admin
$kontak = mysqli_query($conn, "SELECT admin_telp, admin_email, admin_addres FROM tb_admin");
$kt = mysqli_fetch_array($kontak);

// Ambil data keranjang + produk
$keranjang = mysqli_query($conn, "
    SELECT k.id_keranjang, k.product_id, k.product_amount, p.product_name, p.product_price, p.product_discount, p.product_image
    FROM tb_keranjang k
    JOIN tb_product p ON k.product_id = p.product_id
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukawarung</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="container">
            <h1><img src="img/broccoli.png" width="50px" height="50px" id="brokoli"><a href="dashboard.php">Greeny Greenland</a></h1>
         <ul>
        <li><a href="index.php">Dashboard</a></li>   

        <li><a href="produk.php">Produk</a></li>
            
            <li><a href="keranjang.php">Keranjang</a></li>

           
        </ul>
 </div>
        
    </header>

<div class="section">
    <div class="container">
        <h3>Barang di Keranjang</h3>

       <form action="validasi.php" method="POST">
    <div class="box">
        <?php while ($kr = mysqli_fetch_array($keranjang)) {
            $harga_awal = $kr['product_price'];
            $diskon = $kr['product_discount'];
            $harga_diskon = $harga_awal - ($harga_awal * ($diskon / 100));
            $total = $harga_diskon * $kr['product_amount'];
        ?>
        <div class="keranjang-item">
            <input type="checkbox" name="pilih[]" value="<?php echo $kr['id_keranjang']; ?>" style="margin-bottom: 10px;">
            <img src="produk/<?php echo $kr['product_image']; ?>" width="70%">
            <h3><?php echo $kr['product_name']; ?></h3>
            <h4>Harga Satuan: Rp.<?php echo number_format($harga_diskon, 0, ',', '.'); ?></h4>
            <p><b>Total: Rp.<?php echo number_format($total, 0, ',', '.'); ?></b></p>
            <h3>Jumlah: <?php echo $kr['product_amount']; ?></h3><br>
            <a href="proses-hapus.php?idkr=<?php echo $kr['id_keranjang']; ?>" class="btn-hapus">Hapus</a>
            <a href="edit-keranjang.php?id=<?php echo $kr['id_keranjang']; ?>" class="btn-edit">Edit</a>
        </div>
        <?php } ?>
        
        <!-- Tombol beli khusus, di akhir semua produk -->
        <div style="text-align:right; margin-top: 20px;">
            <input type="submit" value="Beli yang Dipilih" class="btn-beli">
        </div>
    </div>
</form>

    </div>
</div>

<!-- Footer -->
<div class="footer">
    <div class="container">
        <h4>Alamat Admin</h4>
        <p><?php echo $kt['admin_addres']; ?></p>
        <h4>Email Admin</h4>
        <p><?php echo $kt['admin_email']; ?></p>
        <h4>Nomor Hp Admin</h4>
        <p><?php echo $kt['admin_telp']; ?></p><br>
        <small>&copy; bintang-2025</small>
    </div>
</div>

</body>
</html>
