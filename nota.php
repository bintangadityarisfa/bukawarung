<?php
include "db.php";
session_start();

// Redirect jika sesi nota tidak ada atau kosong
if (!isset($_SESSION['nota']) || empty($_SESSION['nota'])) {
    echo "<script>alert('Nota tidak ditemukan atau kosong.'); window.location='produk.php';</script>";
    exit;
}

$items_for_nota = $_SESSION['nota'];
unset($_SESSION['nota']); // Hapus sesi setelah ditampilkan agar nota tidak muncul lagi jika di-refresh

// Ambil informasi admin/toko (dari tb_admin)
$q_admin = mysqli_query($conn, "SELECT admin_telp, admin_email, admin_addres FROM tb_admin LIMIT 1");
// Periksa apakah query berhasil
if (!$q_admin) {
    // Jika query gagal, tampilkan pesan error dan hentikan eksekusi
    die("Query error (admin info): " . mysqli_error($conn)); // Ini SANGAT PENTING untuk debugging
}

$data_admin = mysqli_fetch_assoc($q_admin);
// Periksa apakah data admin ditemukan
if (!$data_admin) {
    echo "<script>alert('Informasi toko tidak ditemukan. Pastikan ada data admin di tabel tb_admin.'); window.location='index.php';</script>";
    exit;
}

// Mendapatkan tanggal transaksi terbaru dari tb_transaksi
// Ini adalah asumsi bahwa semua item di nota berasal dari transaksi yang baru saja dicatat
// Jika Anda memiliki ID transaksi spesifik yang ingin ditampilkan, Anda perlu menyimpannya di sesi juga.
$q_transaksi_date = mysqli_query($conn, "SELECT tanggal FROM tb_transaksi ORDER BY tanggal DESC LIMIT 1");
// Periksa apakah query berhasil
if (!$q_transaksi_date) {
    // Jika query gagal, tampilkan pesan error dan gunakan tanggal saat ini
    echo "Query error (transaction date): " . mysqli_error($conn) . ". Using current date."; // Pesan error, tapi tidak menghentikan eksekusi
    $tanggal_transaksi = date('d F Y H:i:s');
} else {
    $data_transaksi_date = mysqli_fetch_assoc($q_transaksi_date);
    $tanggal_transaksi = $data_transaksi_date ? date('d F Y H:i:s', strtotime($data_transaksi_date['tanggal'])) : date('d F Y H:i:s'); // Format tanggal dan waktu
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Nota Pembelian</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px; /* Padding lebih kecil untuk simulasi cetak */
            background: #f7fff5;
            color: #333;
        }
        .nota-container {
            width: 100%;
            max-width: 700px; /* Lebar maksimum untuk nota */
            margin: 20px auto;
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            line-height: 1.6;
        }
        .nota-header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #5CB338; /* Garis bawah header */
            padding-bottom: 15px;
        }
        .nota-header h2 {
            margin: 0;
            color: #5CB338; /* Warna hijau toko */
            font-size: 2.2em;
        }
        .nota-header p {
            margin: 5px 0;
            font-size: 0.9em;
            color: #555;
        }
        .nota-info {
            margin-bottom: 20px;
            font-size: 0.95em;
        }
        .nota-info p {
            margin: 5px 0;
        }
        .nota-info strong {
            display: inline-block;
            width: 120px; /* Lebar tetap untuk label */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
        }
        th, td {
            padding: 12px 15px; /* Padding lebih besar */
            border: 1px solid #ddd;
            text-align: left;
            font-size: 0.95em;
        }
        th {
            background-color: #5CB338; /* Warna hijau toko */
            color: white;
            font-weight: bold;
        }
        .table tfoot th {
            background-color: #eee;
            color: #333;
            text-align: right;
            border-top: 2px solid #5CB338;
        }
        .table tfoot th:last-child {
            text-align: left; /* Biarkan total di kolom terakhir rata kiri */
            background-color: #5CB338;
            color: white;
            font-size: 1.1em;
        }
        .nota-footer {
            margin-top: 30px;
            text-align: center;
            padding-top: 20px;
            border-top: 1px dashed #ccc; /* Garis putus-putus */
            font-size: 0.9em;
            color: #666;
        }
        .btn-lanjut {
            display: block;
            width: fit-content;
            margin: 30px auto 0 auto;
            text-align: center;
            background-color: #56a037;
            color: white;
            padding: 12px 25px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1em;
            transition: background-color 0.3s ease;
        }
        .btn-lanjut:hover {
            background-color: #5bd328;
        }

        /* Gaya untuk print */
        @media print {
            body {
                background: none;
                padding: 0;
                margin: 0;
            }
            .nota-container {
                box-shadow: none;
                border: none;
                margin: 0;
                width: 100%;
                max-width: none;
            }
            .btn-lanjut {
                display: none; /* Sembunyikan tombol saat dicetak */
            }
        }
    </style>
</head>
<body>
    <div class="nota-container">
        <div class="nota-header">
            <h2>Greeny Greenland</h2>
            <p>Toko Sayur & Buah Segar</p>
            <p><?php echo $data_admin['admin_addres']; ?></p>
            <p>Telp: <?php echo $data_admin['admin_telp']; ?> | Email: <?php echo $data_admin['admin_email']; ?></p>
        </div>

        <div class="nota-info">
            <p><strong>Tanggal:</strong> <?php echo $tanggal_transaksi; ?></p>
            <p><strong>No. Transaksi:</strong> TRX-<?php echo date('YmdHis'); // Contoh nomor transaksi unik ?></p>
            </div>

        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Produk</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>Diskon</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $no = 1;
            $total_keseluruhan = 0;
            foreach ($items_for_nota as $item) {
                $harga_awal = $item['product_price'];
                $diskon_persen = $item['product_discount'];
                $diskon_nominal = $harga_awal * $diskon_persen / 100;
                $harga_setelah_diskon = $harga_awal - $diskon_nominal;
                $subtotal_item = $harga_setelah_diskon * $item['jumlah'];
                $total_keseluruhan += $subtotal_item;

                echo "<tr>
                        <td>{$no}.</td>
                        <td>{$item['product_name']}</td>
                        <td>{$item['jumlah']}</td>
                        <td>Rp. " . number_format($harga_awal, 0, ',', '.') . "</td>
                        <td>{$diskon_persen}% (Rp. " . number_format($diskon_nominal, 0, ',', '.') . ")</td>
                        <td>Rp. " . number_format($subtotal_item, 0, ',', '.') . "</td>
                      </tr>";
                $no++;
            }
            ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5" style="text-align:right;">TOTAL PEMBAYARAN</th>
                    <th>Rp. <?php echo number_format($total_keseluruhan, 0, ',', '.'); ?></th>
                </tr>
            </tfoot>
        </table>

        <div class="nota-footer">
            <p>Terima kasih telah berbelanja di Greeny Greenland!</p>
            <p>Barang yang sudah dibeli tidak dapat dikembalikan.</p>
            <p>Silakan kunjungi kami lagi.</p>
        </div>
    </div>
    <a href="berhasil.php" class="btn-lanjut">Selesai</a>
</body>
</html>