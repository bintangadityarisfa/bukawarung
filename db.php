<?php
// $hostname = "localhost";
// $username = "root";
// $password = "";
// $dbname = "db_bukawarung";

// $conn = mysqli_connect($hostname,$username,$password,$dbname) or die ("Gagal memuat ke database");

$hostname = "shuttle.proxy.rlwy.net";
$username = "root";
$password = "VMHDyWnMEPARaYInrkpEPtiwLholifke";
$dbname   = "railway";
$port     = 19644; // port dari connection string

// Buat koneksi (perhatikan parameter port di akhir)
$conn = mysqli_connect($hostname, $username, $password, $dbname, $port);

if (!$conn) {
    // Lebih informatif daripada die()
    die("Koneksi gagal: (" . mysqli_connect_errno() . ") " . mysqli_connect_error());
}

// Set charset agar aman untuk teks UTF-8
mysqli_set_charset($conn, 'utf8mb4');

// Sekarang $conn siap dipakai

?>
