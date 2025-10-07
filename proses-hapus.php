<?php
session_start();
include 'db.php';

if (isset($_GET['idk'])) {
    // Hapus kategori
    $delete = mysqli_query($conn, "DELETE FROM tb_category WHERE category_id = '".$_GET['idk']."'");
    if ($delete) {
        echo '<script>window.location="data-kategori.php"</script>';
    } else {
        echo '<script>alert("Data Gagal Dihapus")</script>';
    }
}

if (isset($_GET['idp'])) {
    // Hapus produk
    $produk = mysqli_query($conn, "SELECT product_image FROM tb_product WHERE product_id='".$_GET['idp']."'");
    $p = mysqli_fetch_object($produk);

    unlink('./produk/'.$p->product_image);  // Hapus gambar produk

    // Hapus produk dari tb_product
    $delete = mysqli_query($conn, "DELETE FROM tb_product WHERE product_id='".$_GET['idp']."'");
    if ($delete) {
        echo '<script>window.location="data-produk.php"</script>';
    } else {
        echo '<script>alert("Data Gagal Dihapus")</script>';
    }
}

if (isset($_GET['idkr'])) {
    // Menghapus berdasarkan id_keranjang, bukan id_product
    $id_keranjang = $_GET['idkr'];

    // Hapus produk dari keranjang
    $delete = mysqli_query($conn, "DELETE FROM tb_keranjang WHERE id_keranjang = '$id_keranjang'");

    if ($delete) {
        echo "<script>alert('Produk berhasil dihapus dari keranjang');</script>";
        echo "<script>window.location='keranjang.php'</script>";
    } else {
        echo "<script>alert('Data gagal dihapus dari keranjang');</script>";
        echo "<script>window.location='keranjang.php'</script>";
    }
}
?>
