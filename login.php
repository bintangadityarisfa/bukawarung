<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Bukawarung</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
</head>
<body id="bg-login">
    <div class="box-login">
        <h2>login</h2>
        <form action="" method="POST">

        <input type="text" name="user" placeholder="username" class="input-control">

        <input type="password" name="pass" placeholder="password" class="input-control">

        <input type="submit" name="submit" value="login" class="btn">
    </form>
       <?php
       session_start();
       include "db.php";
       if(isset($_POST['submit'])){
        $user = mysqli_real_escape_string($conn,$_POST['user']);
        $pass = mysqli_real_escape_string($conn,$_POST['pass']);

        $cek =mysqli_query ($conn , "SELECT * FROM tb_admin WHERE username = '".$user."' AND password ='".MD5($pass)."'");
        if(mysqli_num_rows($cek) > 0){
            $d=mysqli_fetch_object($cek);
            $_SESSION['status_login']=true;
            $_SESSION['a_global']=$d;
            $_SESSION['id']=$d->admin_id;

          echo'<script>window.location="dashboard.php"</script>';
          
        }else{
            echo'<script>alert("Password atau username anda salah")</script>';
        }
       }
       ?>
    </div>
</body>
</html>