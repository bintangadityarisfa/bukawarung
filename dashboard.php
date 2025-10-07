<?php
   session_start();
   if($_SESSION['status_login'] != true){
    echo'<script>window.location="login.php"</script>';
   }
   
   
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukawarung</title>
  

    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
</head>
<body>
<header>
        <div class="container">
            <h1><img src="img/broccoli.png" width="50px" height="50px"><a href="dashboard.php">Greeny Greenland</a></h1>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="profil.php">Profil</a></li>
            <li><a href="data-kategori.php">Data kategori</a></li>
            <li><a href="data-produk.php">Data produk</a></li>
            <li><a href="index.php">Halaman utama</a></li>
            <li><a href="keluar.php" onclick="return confirm('Yakin Mau Keluar ?')">Keluar</a></li>
        </ul>
 </div>
        
    </header>
    <div class="section">
        <div class="container">
            <h3>Dashboard</h3>
            <div class="box">
                <h4>Selamat datang <?php echo$_SESSION['a_global']-> admin_name?> di Greeny Greenland</h4>
            </div>
        </div>
    </div>  
    

    <footer>
        <div class="container">
            <small>Copyright Greenygreenland-2025</small>
        </div>
    </footer>
   

</body>
</html>