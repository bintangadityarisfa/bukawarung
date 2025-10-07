<?php
$host = 'shuttle.proxy.rlwy.net';
$db   = 'railway';
$user = 'root';
$pass = 'VMHDyWnMEPARaYInrkpEPtiwLholifke';
$port = 19644;

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=utf8mb4";
    $pdo = new PDO($dsn, $user, $pass);
    // Set error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Siap dipakai
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>
