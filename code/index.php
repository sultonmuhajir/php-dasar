<?php
   session_start();
   require "functions.php";

   if(!isset($_SESSION["login"])) {
      header("Location: login.php");
      exit;
   }
   
   $limit  = 2;
   $result = $conn -> query("SELECT * FROM mahasiswa");
   $data   = $result -> num_rows;
   $page   = ceil($data / $limit);
   $aktif  = (isset($_GET["p"])) ? $_GET["p"] : 1;
   $awal   = ($limit * $aktif) - $limit;
   $menu   = $conn -> query("SELECT * FROM mahasiswa LIMIT $awal, $limit");

   if (isset($_POST["search"]) ) {
      $menu = search($_POST["key"]);
   }
?>



<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title> Home </title>
   <style>
      .pagee a {
         float: left;
         padding: 10px;
      }
   </style>
</head>

<body>
   <h1>Tabel Mahasiswa</h1><br>
   <a href="insert.php">Insert Data</a><br><br>

   <form action="" method="POST">
      <input type="text" name="key" autocomplete="off">
      <button type="submit" name="search">Search</button>
   </form><br>

   <table border="1" cellpadding="10" cellspacing="0" id="myTable">
      <tr>
         <th>No</th>
         <th>Gambar</th>
         <th>Nama</th>
         <th>Prodi</th>
         <th>Fakultas</th>
         <th>Aksi</th>
      </tr>
      <?php $i = 1 ?>
      <?php while($row = $menu -> fetch_assoc()) : ?>
         <tr>
            <td><?= $i++ ?></td>
            <td>
               <img src="img/<?= $row['gambar'] ?>" alt="Gambar" width="60">
            </td>
            <td><?= $row["nama"] ?></td>
            <td><?= $row["prodi"] ?></td>
            <td><?= $row["fakultas"] ?></td>
            <td>
               <a href="update.php?id=<?= $row['id'] ?>">Update</a> -
               <a href="delete.php?id=<?= $row['id'] ?>" 
                  onclick="return confirm('Yakin?')">Delete</a>
            </td>
         </tr>
      <?php endwhile ?>
   </table>

   <div class="pagee">
      <!-- First -->
      <?php if($aktif > 1) : ?>
         <div><a href="?p=<?= 1; ?>">First</a></div>
      <?php endif ?>


      <!-- Previous -->
      <?php if($aktif > 1) : ?>
         <div><a href="?p=<?= $aktif - 1; ?>">&laquo;</a></div>
      <?php endif ?>


      <!-- Pagination -->
      <?php for ($i = 1; $i <= $page; $i++) : ?>
         <?php if ($i == $aktif) : ?>
            <div><a href="?p=<?= $i; ?>" style="color: red;"><?= $i; ?></a></div>
         <?php else : ?>
            <div><a href="?p=<?= $i; ?>"><?= $i; ?></a></div>
         <?php endif ?>
      <?php endfor ?>


      <!-- Next -->
      <?php if($aktif < $page) : ?>
         <div><a href="?p=<?= $aktif + 1; ?>">&raquo;</a></div>
      <?php endif ?>


      <!-- Last -->
      <?php if($aktif < $page) : ?>
         <div><a href="?p=<?= $page; ?>">Last</a></div>
      <?php endif ?>
   </div><br><br><br>
   <a href="logout.php">Logout</a>
</body>

</html>