<?php
include 'db.php';
session_start();

if (isset($_POST['keranjang'])) {
    $id_keranjangs = $_POST['keranjang'];

    foreach ($id_keranjangs as $id_keranjang) {
        // Ambil data dari keranjang
        $data = mysqli_query($conn, "SELECT * FROM tb_keranjang WHERE id_keranjang = '$id_keranjang'");
        $d = mysqli_fetch_assoc($data);

        // Simpan ke tabel transaksi atau apapun sistemmu
        mysqli_query($conn, "INSERT INTO tb_transaksi (product_id, jumlah, tanggal) VALUES ('$d[product_id]', '$d[product_amount]', NOW())");

        // Hapus dari keranjang
        mysqli_query($conn, "DELETE FROM tb_keranjang WHERE id_keranjang = '$id_keranjang'");
    }

    echo "<script>alert('Pembelian berhasil!'); window.location='keranjang.php';</script>";
} else {
    echo "<script>alert('Tidak ada produk yang dipilih!'); window.location='keranjang.php';</script>";
}
?>
