<?php
include 'db.php';
$gambar=mysqli_query($conn,"SELECT product_image FROM tb_keranjang WHERE id_product ='".$_GET['idg']."'");

$g=mysqli_fetch_array($gambar);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Tampil gambar</title>
</head>
<body>
    <div class="section">
        <div class="container">
          
                <div class="col">
                    <img src="produk/<?php echo $g['product_image'];?>" alt="">
                    <a href="keranjang.php" class="btn-hapus">Kembali</a>
         
            </div>
        </div>
    </div>
    
</body>
</html>