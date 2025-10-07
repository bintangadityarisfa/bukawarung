<?php
session_start();
include "db.php";
if ($_SESSION['status_login'] != true) {
    echo '<script>window.location="login.php"</script>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Bukawarung</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
</head>
<body>
<header>
    <div class="container">
        <h1><img src="img/broccoli.png" width="50px" height="50px"><a href="dashboard.php">Greeny Greenland</a></h1>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="profil.php">Profil</a></li>
            <li><a href="data-kategori.php">Data kategori</a></li>
            <li><a href="data-produk.php">Data produk</a></li>
            <li><a href="index.php">Halaman utama</a></li>
            <li><a href="keluar.php" onclick="return confirm('Yakin Mau Keluar ?')">Keluar</a></li>
        </ul>
    </div>
</header>

<div class="section">
    <div class="container">
        <h3>Data Produk</h3>
        <div class="box">
            <p style="margin-bottom:20px;"><a href="tambah-produk.php" class="btn-tambah">Tambah Produk</a></p>

            <?php
            $batas = 5; // jumlah data per halaman
            $hal = isset($_GET['hal']) ? (int)$_GET['hal'] : 1;
            $posisi = ($hal - 1) * $batas;

            $produk = mysqli_query($conn, "SELECT * FROM tb_product 
                                            LEFT JOIN tb_category USING (category_id) 
                                            ORDER BY product_id DESC 
                                            LIMIT $posisi, $batas");

            ?>

            <table border="1" cellspacing="0" class="table">
                <thead>
                    <tr>
                        <th width="60px">No</th>
                        <th>Kategori</th>
                        <th>Nama produk</th>
                        <th>Harga</th>
                        <th>Gambar</th>
                        <th>Status</th>
                        <th>Diskon</th>

                        <th width="150px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if (mysqli_num_rows($produk) > 0) {
                    $no = $posisi + 1; // supaya nomor tetap urut
                    while ($row = mysqli_fetch_array($produk)) {
                ?>
                    <tr>
                        <td><?php echo $no++ ?></td>
                        <td><?php echo $row['category_name'] ?></td>
                        <td><?php echo $row['product_name'] ?></td>
                        <td>Rp. <?php echo number_format($row['product_price'],0,',','.') ?></td>
                        <td><a href="produk/<?php echo $row['product_image'] ?>" target="_blank"><img src="produk/<?php echo $row['product_image'] ?>" width="50px"></a></td>
                        <td><?php echo ($row['product_status'] == 0) ? 'Tidak aktif' : 'Aktif'; ?></td>
                        <td><?php echo $row['product_discount'] ?>%</td>

                        <td>
                            <a href="edit-produk.php?id=<?php echo $row['product_id'] ?>" class="btn-edit">Edit</a> 
                            <a href="proses-hapus.php?idp=<?php echo $row['product_id'] ?>" onclick="return confirm('Yakin mau dihapus?')" class="btn-hapus">Hapus</a>
                        </td>
                    </tr>
                <?php 
                    }
                } else {
                ?>
                    <tr>
                        <td colspan="8">Tidak ada data</td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>

            <!-- PAGINATION -->
            <div class="pagination" style="margin-top:20px;">
                <?php
                $jumlah_produk = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tb_product"));
                $total_halaman = ceil($jumlah_produk / $batas);

                echo '<div style="text-align:center;">';
                if ($hal > 1) {
                    echo '<a href="?hal='.($hal-1).'" class="btn-page">« Prev</a> ';
                }
                for ($i=1; $i<=$total_halaman; $i++) {
                    if ($i == $hal) {
                        echo '<strong style="margin:0 5px;">'.$i.'</strong> ';
                    } else {
                        echo '<a href="?hal='.$i.'" class="btn-page">'.$i.'</a> ';
                    }
                }
                if ($hal < $total_halaman) {
                    echo '<a href="?hal='.($hal+1).'" class="btn-page">Next »</a>';
                }
                echo '</div>';
                ?>
            </div>

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
