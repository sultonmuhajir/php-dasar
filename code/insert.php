<?php
   session_start();
   require "functions.php";
   
   if(!isset($_SESSION["login"])) {
      header("Location: login.php");
      exit;
   }

   if (isset($_POST["insert"]) ) {
      if (insert($_POST) === TRUE ) {
         header("Location: index.php");
      } else {
         echo $conn -> error;
      }
   }
?>



<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title> Insert Data </title>
</head>

<body>
   <h2>Insert Data</h2><br>
   <form action="" method="POST" enctype="multipart/form-data">
      <label for="nama">Nama</label><br>
      <input type="text" name="nama" id="nama" autocomplete="off" required><br><br>

      <label for="prodi">Prodi</label><br>
      <input type="text" name="prodi" id="prodi" autocomplete="off" required><br><br>

      <label for="fakultas">Fakultas</label><br>
      <input type="text" name="fakultas" id="fakultas" autocomplete="off" required><br><br>

      <label for="gambar">Gambar</label><br>
      <input type="file" name="gambar" id="gambar" required><br><br>

      <button type="submit" name="insert"> Submit </button>&emsp;

      <?php if(isset($errName)) : ?>
         <i>Nama Sudah Ada</i>
      <?php endif ?>
      <?php if(isset($errImg)) : ?>
         <i>Hanya Menerima File .jpg .png .jpeg</i>
      <?php endif ?>
      <?php if(isset($errSize)) : ?>
         <i>Maksimal Ukuran Gambar 1MB</i>
      <?php endif ?>
   </form>
</body>

</html>