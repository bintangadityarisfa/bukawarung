<?php
   session_start();
   include "db.php";
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
            <h3>Data Kategori</h3>
            <div class="box">
                <p><a href="tambah-kategori.php" class="btn-tambah">Tambah kategori</a></p>
             <table border="1" cellspacing="0" class="table kategori">
                <thead>
                    <tr>
                        <th width="60px">No</th>
                        <th>Kategori</th>
                        <th width="150px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no=1;
                    $kategori=mysqli_query($conn,"SELECT * FROM tb_category ORDER BY category_id DESC");
                    if(mysqli_num_rows($kategori) > 0){
                    while($row=mysqli_fetch_array($kategori)){
                    ?>
                    
                    <tr>
                        <td><?php echo $no++?></td>
                        <td><?php echo $row['category_name'] ?></td>
                        <td><a href='edit-kategori.php?id=<?php echo $row['category_id']?>' class="btn-edit">Edit</a><a href='proses-hapus.php?idk=<?php echo $row['category_id'] ?>' onclick="return confirm('Yakin mau dihapus ?')" class="btn-hapus">Hapus</a></td>
                        
                    </tr>
                     <?php }}else{?>
                        <tr>
                            <td colspan="3">Tidak ada data kategori</td>
                        </tr>
                        <?php }?>
                </tbody>
             </table>
            </div>
        </div>
    </div>
    <footer>
        <div class="container">
            <small>Copyright bintang-2025</small>
        </div>
    </footer>
</body>
</html>