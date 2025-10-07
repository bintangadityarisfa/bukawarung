<?php
include 'db.php';
session_start();

if (!isset($_GET['id'])) {
    echo '<script>window.location="keranjang.php"</script>';
    exit;
}

$id_keranjang = $_GET['id'];

// Ambil data keranjang dan produk yang terkait berdasarkan id_keranjang
$data = mysqli_query($conn, "
    SELECT k.*, p.product_name, p.product_price, p.product_image, p.product_discount 
    FROM tb_keranjang k
    JOIN tb_product p ON k.product_id = p.product_id
    WHERE k.id_keranjang = '$id_keranjang'
");

if (mysqli_num_rows($data) == 0) {
    echo '<script>window.location="keranjang.php"</script>';
    exit;
}

$d = mysqli_fetch_assoc($data);

// Tentukan harga berdasarkan diskon, jika ada
$harga = $d['product_price'];
if ($d['product_discount'] > 0) {
    $harga_diskon = $harga - (($harga * $d['product_discount']) / 100);
} else {
    $harga_diskon = $harga;
}
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

<div class="section">
    <div class="container">
        <h3>Edit Jumlah Produk</h3>
        <div class="box">
            <!-- Form untuk edit jumlah produk -->
            <form action="" method="POST">
                <p><strong><?php echo $d['product_name']; ?></strong></p>
                <!-- Menampilkan harga diskon jika ada -->
                <p>Harga: Rp <?php echo number_format($harga_diskon, 0, ',', '.'); ?></p>
                <p>Jumlah:</p>
                <input type="number" name="jumlah" class="input-control" value="<?php echo $d['product_amount']; ?>" min="1" required>
                <input type="submit" name="submit" value="Update" class="btn">
            </form>

            <?php
            if (isset($_POST['submit'])) {
                // Ambil jumlah dari form
                $jumlah = $_POST['jumlah'];

                // Query untuk memperbarui jumlah produk di keranjang
                $update = mysqli_query($conn, "
                    UPDATE tb_keranjang 
                    SET product_amount = '$jumlah' 
                    WHERE id_keranjang = '$id_keranjang'
                ");

                if ($update) {
                    echo '<script>alert("Jumlah berhasil diperbarui")</script>';
                    echo '<script>window.location="keranjang.php"</script>';
                } else {
                    echo '<script>alert("Gagal memperbarui jumlah")</script>';
                }
            }
            ?>
        </div>
    </div>
</div>

<footer>
    <div class="container">
        <small>Copyright bintang-2025</small>
    </div>
</footer>
</body>
</html>
