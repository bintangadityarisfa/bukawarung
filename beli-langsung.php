<?php
include 'db.php';
session_start();

if (isset($_GET['product_id'])) { // Pastikan mengambil 'product_id'
    $product_id = mysqli_real_escape_string($conn, $_GET['product_id']);
    // Pastikan 'jumlah' diambil dari GET dan divalidasi
    $jumlah = isset($_GET['jumlah']) ? intval($_GET['jumlah']) : 1;

    // Redirect ke validasi.php dengan membawa product_id dan jumlah
    // Ini adalah kunci agar jumlah diteruskan
    header("Location: validasi.php?beli_langsung=" . $product_id . "&jumlah=" . $jumlah);
    exit;
} else {
    // Jika tidak ada ID produk, kembali ke halaman produk
    echo "<script>alert('Produk tidak ditemukan.'); window.location='produk.php';</script>";
    exit;
}
?>