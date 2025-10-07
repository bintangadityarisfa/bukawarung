<?php
   session_start();
   include 'db.php';
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
            <h3>Tambah Data Produk</h3>
            <div class="box">
                <form action="" method="POST" enctype="multipart/form-data">
                    <select class="input-control" name="kategori" required>
                        <option value="" >Pilih</option>
                        <?php
                        $kategori=mysqli_query($conn,"SELECT * FROM tb_category ORDER BY category_id DESC");
                        while($r = mysqli_fetch_array($kategori)){
                        ?>
                        <option value="<?php echo $r['category_id']?>"><?php echo $r['category_name']?></option>
                        <?php }?>
                    </select>
                    <input type="text" name="nama" class="input-control" placeholder="Nama product" required>

                    <input type="text" name="harga" class="input-control" placeholder="Harga product" required>

                    <input type="number" name="diskon" class="input-control" placeholder="Diskon (%)" value="0" min="0" max="100" required>


                    <input type="file" name="gambar" class="input-control"  required>
                    
                    <textarea name="deskripsi" class="input-control" placeholder="Deskripsi"></textarea>

                    <select class="input-control" name="status">
                        <option value="">Pilih</option>
                        <option value="1">Aktif</option>
                        <option value="0">Tidak Aktif</option>
                    </select>

                    <input type="submit" name="submit"
                    class="btn"
                    value="Submit" >
                </form>
               <?php
               if(isset($_POST['submit'])){
            //    print_r($_FILES['gambar']);
            //menampung input dari form
            $kategori=$_POST['kategori'];
            $nama=ucwords($_POST['nama']);
            $harga=$_POST['harga'];
            $deskripsi=ucwords($_POST['deskripsi']);
            $status=$_POST['status'];
            $diskon = $_POST['diskon'];

            //menampung data file yang diupload
            $filename=$_FILES['gambar']['name'];
            $tmp_name=$_FILES['gambar']['tmp_name'];

            $type1=explode('.',$filename);

            $type2=$type1[1];
            
            $newname='produk'.time().'.'.$type2;

            //menampung data format yang diizinkan
            $tipe_diizinkan = array('jpg','jpeg','png','gif');

            //validasi format file
            if(!in_array($type2,$tipe_diizinkan)){
                //jika format file tidak sesuai dengan yang ada dalam array tipe diizinkan

                echo' <script>alert ("Format file tidak diizinkan")</script>';

            }else{
            //jika format file sesuai dengan yang ada dalamarray tipe diizinkan

            //proses upload file sekaligus insert ke database

                move_uploaded_file($tmp_name,'./produk/'.$newname);

                $insert=mysqli_query($conn,"INSERT INTO tb_product VALUES (null,
                '".$kategori."',
                '".$nama."',
                '".$harga."',
                '".$deskripsi."',
                '".$newname."',
                '".$status."',
                null,
                '".$diskon."'
            )");
                        

                if($insert){
                    echo'<script>alert("Berhasil menambah produk")</script>';
                    echo'  <script>
                        const brokoli = document.getElementById("brokoli");
                        brokoli.classList.add("brokoli-anim");
                        setTimeout(() => {
                            brokoli.classList.remove("brokoli-anim");
                        }, 2000);
                    </script>';
                    
                   
                }else{
                    echo'Gagal menambah data';
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