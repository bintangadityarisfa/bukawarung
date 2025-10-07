<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Transaksi Berhasil</title>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      text-align: center;
      padding: 100px 20px;
      background: #f0fff0;
    }

    .checkmark {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      display: inline-block;
      border: 5px solid #4CAF50;
      position: relative;
      animation: pop 0.4s ease-in-out;
    }

    .checkmark::after {
      content: '';
      position: absolute;
      left: 32px;
      top: 15px;
      width: 25px;
      height: 50px;
      border-right: 5px solid #4CAF50;
      border-bottom: 5px solid #4CAF50;
      transform: rotate(45deg);
      animation: draw 0.4s ease forwards;
    }

    @keyframes draw {
      0% {
        height: 0;
        width: 0;
      }
      100% {
        height: 50px;
        width: 25px;
      }
    }

    @keyframes pop {
      0% {
        transform: scale(0.5);
        opacity: 0;
      }
      100% {
        transform: scale(1);
        opacity: 1;
      }
    }

    h2 {
      color: #4CAF50;
      margin-top: 30px;
      font-size: 28px;
    }

    p {
      color: #555;
      margin-top: 10px;
    }

   
  </style>
</head>
<body>

  <div class="checkmark"></div>
  <h2>Transaksi Berhasil!</h2>
  <p>Terima kasih telah melakukan pembelian.</p>



  <script>
    setTimeout(()=>window.location="produk.php",2000)
  </script>

</body>
</html>
