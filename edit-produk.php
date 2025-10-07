<?php
   session_start();
   include 'db.php';
   if($_SESSION['status_login'] != true){
    echo'<script>window.location="login.php"</script>';
   }
  
   $produk=mysqli_query($conn,"SELECT * FROM tb_product WHERE product_id='".$_GET['id']."' ");
   if(mysqli_num_rows($produk) == 0){
    echo'<script>window.location="data-produk.php"</script>';
   }
   $p=mysqli_fetch_object($produk);
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
            <h3>Edit Data Produk</h3>
            <div class="box">
                <form action="" method="POST" enctype="multipart/form-data">
                    <select class="input-control" name="kategori" required>
                        <option value="" >Pilih</option>
                        <?php
                        $kategori=mysqli_query($conn,"SELECT * FROM tb_category ORDER BY category_id DESC");
                        while($r = mysqli_fetch_array($kategori)){
                        ?>
                        <option value="<?php echo $r['category_id']?>" <?php echo ($r['category_id'] == $p->category_id)?'selected':'';?>><?php echo $r['category_name']?></option>
                        <?php }?>
                    </select>
                    <input type="text" name="nama" class="input-control" 
                    value="<?php echo $p->product_name;?>"
                    placeholder="Nama product" required>

                    <input type="text" name="harga" class="input-control" 
                     value="<?php echo $p->product_price;?>"
                    placeholder="Harga product" required>

                   <input type="number" name="diskon" class="input-control" 
                   placeholder="Diskon (%)" min="0" max="100"
                   value="<?php echo $p->product_discount; ?>" required>
                                    
                    <img src="produk/<?php echo $p->product_image?>" alt="Gambar <?php echo $p->product_name?>" width="100px" >

                    <input type="hidden" name="foto" value="<?php echo$p->product_image?>">
                  
                    <input type="file" name="gambar" class="input-control" >
                    
                    <textarea name="deskripsi" class="input-control" 
                    
                    placeholder="Deskripsi"><?php echo $p->product_description;?></textarea>

                    <select class="input-control" name="status">
                        <option value="">Pilih</option>
                        <option value="1" <?php echo($p->product_status==1)?'selected':'';?>>Aktif</option>
                        <option value="0" <?php echo($p->product_status==0)?'selected':'';?>>Tidak Aktif</option>
                    </select>

                    <input type="submit" name="submit"
                    class="btn"
                    value="Submit" >
                </form>
               <?php
               if(isset($_POST['submit'])){
               //data inputan dari form
               $kategori=$_POST['kategori'];
            $nama=ucwords($_POST['nama']);
            $harga=$_POST['harga'];
            $deskripsi=ucwords($_POST['deskripsi']);
            $status=$_POST['status'];
            $foto=$_POST['foto'];
            $diskon = $_POST['diskon'];

               //tampung data gambar yang baru
               $filename=$_FILES['gambar']['name'];
               $tmp_name=$_FILES['gambar']['tmp_name'];
   
               $type1=explode('.',$filename);
   
               $type2=$type1[1];
               
               $newname='produk'.time().'.'.$type2;

               //menampung data format file yang diizinkan
               $tipe_diizinkan = array('jpg','jpeg','png','gif');

              
               if($filename != ''){
                 //jika admin ganti gambar
                 
                //validasi format

                if(!in_array($type2,$tipe_diizinkan)){
                    //jika format file tidak sesuai dengan yang ada dalam array tipe diizinkan
    
                    echo' <script>alert ("Format file tidak diizinkan")</script>';
    
                }else{
                    unlink('./produk/'.$foto);
                   
                    move_uploaded_file($tmp_name,'./produk/'.$newname);

                    $namagambar =$newname;

                }
               }else{
                 //jika admin tidak ganti gambar
                $namagambar = $foto;
               }
              
                 //query update produk
                $update=mysqli_query($conn,"UPDATE tb_product SET
                category_id='".$kategori."',
                product_name='".$nama."',
                product_price='".$harga."',
                product_description='".$deskripsi."',
                product_image='".$namagambar."',
                product_status='".$status."',
                product_discount='".$diskon."'
                WHERE product_id='".$p->product_id."'
            ");
                    
                 if($update){
                    echo'<script>alert("Berhasil megubah data")</script>';
                    echo'<script>window.location="data-produk.php"</script>';

                 
                    
                   
                }else{
                    echo'Gagal mengubah data';
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