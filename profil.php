<?php
   session_start();
   include 'db.php';
   if($_SESSION['status_login'] != true){
    echo'<script>window.location="login.php"</script>';
   }
   $query=mysqli_query($conn,"SELECT * FROM tb_admin WHERE admin_id = '".$_SESSION['id']."'");
   $d=mysqli_fetch_object($query);
   
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
            <h1><img src="img/broccoli.png" width="50px" height="50px" id="brokoli"><a href="dashboard.php">Greeny Greenland</a></h1>
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
            <h3>Profil</h3>
            <div class="box">
                <form action="" method="POST">
                    <input type="text" name="nama" placeholder="Nama lengkap" 
                    value="<?php echo $d->admin_name?>"
                    class="input-control" required>
                    <input type="text" name="user"
                    value="<?php echo $d->username?> "
                    placeholder="Username" class="input-control" required>

                    <input type="text" name="hp" 
                    value="<?php echo $d->admin_telp?>"
                    placeholder="No hp" class="input-control" required>
                    <input type="text" name="email" 
                    value="<?php echo $d->admin_email?>"
                    placeholder="Email"class="input-control" required>
                    <input type="text" name="alamat" 
                    value="<?php echo $d->admin_addres?>"
                    placeholder="Alamat" class="input-control" required>
                    <input type="submit" name="submit"
                    class="btn"
                    value="Ubah profil" >
                </form>
                <?php
                if(isset($_POST['submit'])){
                    $nama= ucwords($_POST['nama']);
                    $user= $_POST['user'];
                    $hp= $_POST['hp'];
                    $email= $_POST['email'];
                    $alamat= ucwords($_POST['alamat']);

                    $update=mysqli_query($conn,"UPDATE tb_admin SET
                    admin_name='".$nama."',
                    username='".$user."',
                    admin_telp='".$hp."',
                    admin_email='".$email."',
                    admin_addres='".$alamat."' WHERE admin_id='".$d->admin_id."' ");
              
                if($update){
                    echo'<script>alert("Ubah data berhasil")</script>';
                    echo'<script>
                    const brokoli=document.getElementById("brokoli");
                    brokoli.classList.add("brokoli-anim");
                    setTimeOut(()=>{
                    brokoli.classList.remove("brokoli-anim")});
                    </script>';
                }else{
                    echo'gagal'.mysqli_error($conn);
                }
              
                }
                ?>
            </div>

            <h3>Ubah password</h3>
            <div class="box">
                <form action="" method="POST">
                    <input type="password" name="pass1" placeholder="Password baru" 
                   
                    class="input-control" required>
                    <input type="password" name="pass2"
                    
                    placeholder="Konfirmasi password baru" class="input-control" required>
                    
                    <input type="submit" name="ubah_password"
                    class="btn"
                    value="Ubah password" >
                </form>
                <?php
                if(isset($_POST['ubah_password'])){
                    
                    $pass1= $_POST['pass1'];
                    $pass2= $_POST['pass2'];
                   
                    if($pass2 != $pass1){
                    echo'<script>alert("Konfirmasi password baru tidak sesuai")</script>';
                    }else{
                       
                        $u_pass=mysqli_query($conn,"UPDATE tb_admin SET 
                    
                    password='".MD5($pass1)."' WHERE admin_id='".$d->admin_id."' ");

                    if($u_pass){
                        echo'<script>alert("Ubah password berhasil")</script>';
                        echo'<script>
                        const kentang=document.getElementById("brokoli");
                        kentang.classList.add("brokoli-anim");
                        setTimeOut(()=>{
                        kentang.classList.remove("brokoli-anim")
                        });
                        </script>';
                    }else{
                        echo'gagal'.mysqli_error($conn);
                    }
                    }

                  
              
                }
                ?>
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