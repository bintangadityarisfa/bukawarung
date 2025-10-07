<?php
$hostname = "shuttle.proxy.rlwy.net";
$username = "root";
$password = "VMHDyWnMEPARaYInrkpEPtiwLholifke";
$dbname   = "db_bukawarung";
$port     = 19644;

// Membuat koneksi mysqli dengan port khusus
$conn = mysqli_connect($hostname, $username, $password, $dbname, $port);

// Cek koneksi
if (!$conn) {
    die("Gagal memuat ke database: " . mysqli_connect_error());
}

// Set charset agar aman untuk UTF-8
mysqli_set_charset($conn, "utf8mb4");

// Sekarang koneksi $conn siap digunakan
?>
