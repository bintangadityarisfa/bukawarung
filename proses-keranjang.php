<?php
include 'db.php';
session_start();

if (isset($_POST['tambah_keranjang']) && isset($_POST['product_id'])) {
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    // Ambil jumlah dari input hidden yang baru, default ke 1 jika tidak ada
    $jumlah_ditambah = isset($_POST['jumlah_keranjang']) ? intval($_POST['jumlah_keranjang']) : 1;

    // Pastikan jumlah minimal 1
    if ($jumlah_ditambah < 1) {
        $jumlah_ditambah = 1;
    }

    // Cek apakah produk sudah ada di keranjang
    $cek_keranjang = mysqli_query($conn, "SELECT id_keranjang, product_amount FROM tb_keranjang WHERE product_id = '$product_id'");
    
    if (mysqli_num_rows($cek_keranjang) > 0) {
        // Produk sudah ada, update jumlahnya
        $data_keranjang = mysqli_fetch_assoc($cek_keranjang);
        $current_amount = $data_keranjang['product_amount'];
        $id_keranjang = $data_keranjang['id_keranjang'];
        
        $new_amount = $current_amount + $jumlah_ditambah;
        
        $update = mysqli_query($conn, "UPDATE tb_keranjang SET product_amount = '$new_amount' WHERE id_keranjang = '$id_keranjang'");
        
        if ($update) {
            echo "<script>alert('Jumlah produk di keranjang berhasil diperbarui.'); window.location='keranjang.php';</script>";
        } else {
            echo "<script>alert('Gagal memperbarui jumlah produk di keranjang: " . mysqli_error($conn) . "'); window.location='detail-produk.php?id=$product_id';</script>";
        }
    } else {
        // Produk belum ada, tambahkan baru
        $insert = mysqli_query($conn, "INSERT INTO tb_keranjang (product_id, product_amount) VALUES ('$product_id', '$jumlah_ditambah')");
        
        if ($insert) {
            echo "<script>alert('Produk berhasil ditambahkan ke keranjang.'); window.location='keranjang.php';</script>";
        } else {
            echo "<script>alert('Gagal menambahkan produk ke keranjang: " . mysqli_error($conn) . "'); window.location='detail-produk.php?id=$product_id';</script>";
        }
    }
} else {
    echo "<script>alert('Akses tidak valid.'); window.location='produk.php';</script>";
}
exit;
?>