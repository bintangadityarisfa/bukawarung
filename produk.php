<?php
include"db.php";
error_reporting(0);
$kontak =mysqli_query($conn,"SELECT admin_telp,admin_email,admin_addres FROM tb_admin ");

$kt=mysqli_fetch_array($kontak);
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
            <h1><img src="img/broccoli.png" width="50px" height="50px"><a href="index.php">Greeny Greenland</a></h1>
        <ul>
        <li><a href="index.php">Dashboard</a></li>
            <li><a href="produk.php">Produk</a></li>
           
            <li><a href="keranjang.php">Keranjang</a></li>
            
            
        </ul>
 </div>
        
    </header>
    <!--search-->
    <div class="search">
        <div class="container">
            <form action="produk.php">
                <input type="text" name="search" placeholder="Cari produk"
                value="<?php echo $_GET['search'];?>"
                >
                <input type="hidden" name="kat" value="<?php echo $_GET['kat'];?>">
                <input type="submit" name="submit" value="Cari">
            </form>
        </div>
    </div>
   
 <!--new product-->
 <div class="section">
    <div class="container">
        <h3>Produk </h3>
        <div class="box">
            <?php 
            $where='';
            if($_GET['search'] != ''||$_GET['kat'] != ''){
                $where ="AND product_name LIKE '%".$_GET['search']."%' AND category_id LIKE '%".$_GET['kat']."%'";
            }

            $produk=mysqli_query($conn,"SELECT * FROM tb_product WHERE product_status= 1 $where ORDER BY product_id DESC ");
            if(mysqli_num_rows($produk) > 0){
                while($p=mysqli_fetch_array($produk)){
            
            ?>
            <a href="detail-produk.php?id=<?php echo $p['product_id'];?>">
                 <div class="col-4">
                <img src="produk/<?php echo $p['product_image'];?>" alt="Gambar <?php $p['product_name'];?>"
                width="100%">

                <p class="nama"><?php echo $p['product_name'];?></p>

              <td>
  <?php
$harga_asli = $p['product_price'];
$diskon = $p['product_discount'];

if ($diskon > 0) {
    $harga_diskon = $harga_asli - ($harga_asli * $diskon / 100);
    echo "<p class='harga'>
            <del>Rp. " . number_format($harga_asli, 0, ',', '.') . "</del><br>
            <strong style='color:red;'>Rp. " . number_format($harga_diskon, 0, ',', '.') . " (" . $diskon . "% off)</strong>
          </p>";
} else {
    echo "<p class='harga'>Rp. " . number_format($harga_asli, 0, ',', '.') . "</p>";
}
?>


            </td>
            


               
            </div>
        </a>
           
            <?php } }else{?>
                <p>Tidak ada data</p>
                <?php }?>
        </div>
    </div>
 </div>

 <!-- footer -->
  <div class="footer">
    <div class="container">
        <h4>Alamat Admin</h4>
        <p><?php echo $kt['admin_addres'];?></p>
        <h4>Email Admin</h4>
        <p><?php echo $kt['admin_email'];?></p>
        <h4>Nomor Hp Admin</h4>
        <p><?php echo $kt['admin_telp'];?></p><br>
    <small>Copyright bintang-2025</small>

    </div>
  </div>
</body>
</html>