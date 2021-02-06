<?php
   session_start();
   require "functions.php";
   
   if(!isset($_SESSION["login"])) {
      header("Location: login.php");
      exit;
   }

   $id = $_GET["id"];
   $result = $conn -> query("SELECT * FROM mahasiswa WHERE id=$id");

   if (isset($_POST["update"]) ) {
      if (update($_POST) === TRUE ) {
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
   <title>Update Data</title>
</head>

<body>
   <h2>Update Data</h2><br>
   <form action="" method="POST" enctype="multipart/form-data">
      <?php while($row = $result -> fetch_assoc()) : ?>
         <input type="hidden" name="id" value="<?= $row["id"] ?>">
         <input type="hidden" name="gambarLama" value="<?= $row["gambar"] ?>">

         <label for="nama">Nama</label><br>
         <input type="text" name="nama" id="nama" autocomplete="off" required 
                value="<?= $row["nama"] ?>"><br><br>

         <label for="prodi">Prodi</label><br>
         <input type="text" name="prodi" id="prodi" autocomplete="off" required 
                value="<?= $row["prodi"] ?>"><br><br>

         <label for="fakultas">Fakultas</label><br>
         <input type="text" name="fakultas" id="fakultas" autocomplete="off" required
                value="<?= $row["fakultas"] ?>"><br><br>

         <label for="gambar">Gambar</label><br>
         <img src="img/<?= $row["gambar"] ?>" alt="Gambar" width="60"><br>
         <input type="file" name="gambar" id="gambar"><br><br>
      <?php endwhile ?>

      <button type="submit" name="update"> Submit </button>&emsp;
      <?php if(isset($errImg)) : ?>
         <i>Hanya Menerima File .jpg .png .jpeg</i>
      <?php endif ?>
      <?php if(isset($errSize)) : ?>
         <i>Maksimal Ukuran Gambar 1MB</i>
      <?php endif ?>
   </form>
</body>

</html>