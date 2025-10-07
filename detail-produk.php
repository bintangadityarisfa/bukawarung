<?php
include "db.php";
error_reporting(0);

$kontak =mysqli_query($conn,"SELECT admin_telp,admin_email,admin_addres FROM tb_admin ");
$kt=mysqli_fetch_array($kontak);

$produk = mysqli_query($conn, "SELECT * FROM tb_product WHERE product_id = '".$_GET['id']."' ");
$p = mysqli_fetch_array($produk);

// Redirect jika produk tidak ditemukan
if (!$p) {
    echo "<script>alert('Produk tidak ditemukan.'); window.location='produk.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk - Greeny Greenland</title>
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

    <div class="search">
        <div class="container">
            <form action="produk.php">
                <input type="text" name="search" placeholder="Cari produk"
                value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                <input type="hidden" name="kat" value="<?php echo isset($_GET['kat']) ? $_GET['kat'] : ''; ?>">
                <input type="submit" name="submit" value="Cari">
            </form>
        </div>
    </div>

    <div class="section">
        <div class="container">
            <h3>Detail Produk</h3>
            <div class="box">
                <div class="col-2">
                    <img src="produk/<?php echo $p['product_image'];?>" width="100%">
                </div>
                <div class="col-2">
                    <h3><?php echo $p['product_name'];?></h3>
                    <?php
                        $harga_asli = $p['product_price'];
                        $diskon = $p['product_discount'];

                        if ($diskon > 0) {
                            $harga_diskon = $harga_asli - ($harga_asli * $diskon / 100);
                            echo "<h4 class='harga-asli'><del>Rp. " . number_format($harga_asli, 0, ',', '.') . "</del></h4>";
                            echo "<h4 class='harga-diskon'>Rp. " . number_format($harga_diskon, 0, ',', '.') . " (" . $diskon . "% off)</h4>";
                        } else {
                            echo "<h4>Rp. " . number_format($harga_asli, 0, ',', '.') . "</h4>";
                        }
                    ?>
                    <p>Deskripsi :<br><?php echo $p['product_description'];?></p>

                    <div class="input-group">
                        <label for="jumlah_beli">Jumlah:</label>
                        <input type="number" id="jumlah_beli" value="1" min="1" class="input-control">
                    </div>

                    <form action="beli-langsung.php" method="GET" class="form-beli-keranjang" id="formBeliLangsung">
                        <input type="hidden" name="product_id" value="<?php echo $p['product_id']; ?>">
                        <input type="hidden" name="jumlah" id="jumlah_beli_hidden_beli">
                        <button type="submit" class="btn-beli">Beli Sekarang</button>
                    </form>

                    <form action="proses-keranjang.php" method="POST" class="form-beli-keranjang" id="formTambahKeranjang" style="margin-top: 15px;">
                        <input type="hidden" name="product_id" value="<?php echo $p['product_id']; ?>">
                        <input type="hidden" name="jumlah_keranjang" id="jumlah_beli_hidden_keranjang">
                        <button type="submit" name="tambah_keranjang" class="btn-keranjang">Tambah ke Keranjang</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const jumlahInput = document.getElementById('jumlah_beli');
            const jumlahBeliHidden = document.getElementById('jumlah_beli_hidden_beli');
            const jumlahKeranjangHidden = document.getElementById('jumlah_beli_hidden_keranjang');

            // Set nilai awal
            jumlahBeliHidden.value = jumlahInput.value;
            jumlahKeranjangHidden.value = jumlahInput.value;

            // Update nilai hidden input saat jumlahInput berubah
            jumlahInput.addEventListener('change', function() {
                jumlahBeliHidden.value = this.value;
                jumlahKeranjangHidden.value = this.value;
            });

            // Pastikan nilai terupdate juga saat di-klik
            jumlahInput.addEventListener('input', function() {
                jumlahBeliHidden.value = this.value;
                jumlahKeranjangHidden.value = this.value;
            });
        });
    </script>
</body>
</html>