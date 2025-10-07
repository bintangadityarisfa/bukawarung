<?php
// $hostname = "localhost";
// $username = "root";
// $password = "";
// $dbname = "db_bukawarung";

// $conn = mysqli_connect($hostname,$username,$password,$dbname) or die ("Gagal memuat ke database");

$hostname = "shuttle.proxy.rlwy.net";
$username = "root";
$password = "VMHDyWnMEPARaYInrkpEPtiwLholifke";
$dbname   = "db_bukawarung";
$port     = 19644; // port dari connection string

// Buat koneksi (perhatikan parameter port di akhir)
$conn = mysqli_connect($hostname, $username, $password, $dbname, $port);


?>

