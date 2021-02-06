<?php
   session_start();
   require "functions.php";

   if(isset($_SESSION["login"])) {
      header ("Location: index.php");
      exit;
   }

   if (isset($_POST["register"])) {
      if (register($_POST) === TRUE ) {
         header("Location: login.php");
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
   <title>Register</title>
</head>

<body>
   <h2>Register</h2><br>
   <form action="" method="POST" enctype="multipart/form-data">
      <label for="username">Username</label><br>
      <input type="text" name="username" id="username" autocomplete="off" required><br><br>

      <label for="password">Password</label><br>
      <input type="password" name="password" id="password" required><br><br>

      <label for="password2">Confirm Pasword</label><br>
      <input type="password" name="password2" id="password2" required><br><br>

      <button type="submit" name="register"> Submit </button>&emsp;
      <?php if(isset($errUname)) : ?>
         <i style="color: red;">Username Sudah Terdaftar</i>
      <?php endif ?>
      <?php if(isset($errPw)) : ?>
         <i style="color: red;">Password Tidak Sesuai</i>
      <?php endif ?>

      <p>Sudah punya akun? <a href="login.php">Masuk</a></p>
   </form>
</body>

</html>