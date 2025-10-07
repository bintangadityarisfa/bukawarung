<?php
include "db.php";
session_start();

// Handle direct purchase (beli_langsung) logic from product page
if (isset($_GET['beli_langsung'])) {
    $produk_id = mysqli_real_escape_string($conn, $_GET['beli_langsung']);
    $jumlah = isset($_GET['jumlah']) ? intval($_GET['jumlah']) : 1; // Pastikan jumlah diambil dan divalidasi

    // Validasi jumlah harus minimal 1
    if ($jumlah < 1) {
        echo "<script>alert('Jumlah produk harus minimal 1 untuk pembelian langsung.'); window.location='produk.php';</script>";
        exit;
    }

    // Ambil data produk LENGKAP untuk pembelian langsung dari tb_product
    $query_produk = mysqli_query($conn, "SELECT product_id, product_name, product_price, product_discount, product_image FROM tb_product WHERE product_id = '$produk_id'");
    $data_produk = mysqli_fetch_assoc($query_produk);

    if (!$data_produk) {
        echo "<script>alert('Produk tidak ditemukan.'); window.location='produk.php';</script>";
        exit;
    }

    // Format data untuk nota agar konsisten dengan format keranjang
    // Disimpan sebagai array of arrays karena nota bisa berisi banyak item (dari keranjang)
    $_SESSION['beli_langsung_data'] = [
        [
            'product_id'        => $data_produk['product_id'],
            'product_name'      => $data_produk['product_name'],
            'product_price'     => $data_produk['product_price'],
            'product_discount'  => $data_produk['product_discount'],
            'product_image'     => $data_produk['product_image'],
            'jumlah'            => $jumlah // Ini adalah jumlah yang diambil dari input GET
        ]
    ];

    header("Location: validasi.php"); // Redirect ke diri sendiri untuk konfirmasi
    exit;
}

// Handle selected cart items from keranjang.php via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pilih'])) {
    $_SESSION['produk_dipilih_data'] = []; // Menyimpan detail produk dari keranjang

    foreach ($_POST['pilih'] as $id_keranjang) {
        $id_keranjang_sanitized = mysqli_real_escape_string($conn, $id_keranjang);

        // Ambil product_id, product_amount dari tb_keranjang DAN detail produk dari tb_product
        $q = mysqli_query($conn, "
            SELECT k.id_keranjang, k.product_id, k.product_amount, p.product_name, p.product_price, p.product_discount, p.product_image
            FROM tb_keranjang k
            JOIN tb_product p ON k.product_id = p.product_id
            WHERE k.id_keranjang = '$id_keranjang_sanitized'
        ");
        $data = mysqli_fetch_assoc($q);

        if ($data) {
            $_SESSION['produk_dipilih_data'][] = [
                'id_keranjang'      => $data['id_keranjang'], // Tetap sertakan id_keranjang untuk penghapusan nanti
                'product_id'        => $data['product_id'],
                'product_name'      => $data['product_name'],
                'product_price'     => $data['product_price'],
                'product_discount'  => $data['product_discount'],
                'product_image'     => $data['product_image'],
                'jumlah'            => $data['product_amount'] // Jumlah dari keranjang
            ];
        }
    }

    header("Location: validasi.php"); // Redirect ke diri sendiri untuk konfirmasi
    exit;
}

// Handle confirmation of purchase via POST (triggered by the 'Ya, Konfirmasi Pembelian' button)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['konfirmasi'])) {
    $nota_items = []; // Array untuk menampung semua item yang akan masuk ke nota

    // Prioritaskan 'beli_langsung_data' jika ada (dari pembelian langsung)
    if (isset($_SESSION['beli_langsung_data'])) {
        foreach ($_SESSION['beli_langsung_data'] as $item) {
            $nota_items[] = $item; // Tambahkan item ke array nota
            // Masukkan ke tb_transaksi untuk pembelian langsung
            $product_id_trans = mysqli_real_escape_string($conn, $item['product_id']);
            $jumlah_trans = intval($item['jumlah']);
            mysqli_query($conn, "INSERT INTO tb_transaksi (product_id, jumlah, tanggal) VALUES ('$product_id_trans', '$jumlah_trans', NOW())");
        }
        unset($_SESSION['beli_langsung_data']); // Hapus sesi setelah diproses
    }
    // Lalu cek untuk 'produk_dipilih_data' (dari pilihan keranjang)
    elseif (isset($_SESSION['produk_dipilih_data'])) {
        foreach ($_SESSION['produk_dipilih_data'] as $item) {
            $nota_items[] = $item; // Tambahkan item ke array nota
            // Masukkan ke tb_transaksi untuk item keranjang
            $product_id_trans = mysqli_real_escape_string($conn, $item['product_id']);
            $jumlah_trans = intval($item['jumlah']);
            mysqli_query($conn, "INSERT INTO tb_transaksi (product_id, jumlah, tanggal) VALUES ('$product_id_trans', '$jumlah_trans', NOW())");

            // Hapus dari keranjang setelah transaksi
            $id_keranjang_del = mysqli_real_escape_string($conn, $item['id_keranjang']);
            mysqli_query($conn, "DELETE FROM tb_keranjang WHERE id_keranjang = '$id_keranjang_del'");
        }
        unset($_SESSION['produk_dipilih_data']); // Hapus data sesi keranjang
        unset($_SESSION['produk_dipilih']); // Hapus juga variabel sesi lama jika masih ada
    }

    // Simpan semua item yang dikonfirmasi ke sesi untuk halaman nota
    $_SESSION['nota'] = $nota_items; // $_SESSION['nota'] sekarang selalu berisi array detail produk
    header("Location: nota.php");
    exit;
}

// Jika tidak ada data pembelian di sesi, arahkan dengan alert
if (!isset($_SESSION['beli_langsung_data']) && !isset($_SESSION['produk_dipilih_data'])) {
    echo "<script>alert('Tidak ada produk yang dipilih untuk pembelian.'); window.location='produk.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Konfirmasi Pembelian</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body { font-family: sans-serif; padding: 30px; background: #fffef2; }
        h2 { text-align: center; color: green; }
        .btn { display: inline-block; margin-top: 20px; padding: 10px 20px; background: green; color: white; text-decoration: none; border-radius: 5px; }
        .btn:hover { background: darkgreen; }
    </style>
</head>
<body>
    <h2>Konfirmasi Pembelian</h2>
    <p>Apakah Anda yakin ingin melanjutkan pembelian?</p>
    <form method="POST">
        <button type="submit" name="konfirmasi" class="btn">Ya, Konfirmasi Pembelian</button>
        <a href="produk.php" class="btn">Batal</a>
    </form>
</body>
</html>