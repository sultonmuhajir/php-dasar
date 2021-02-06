<?php
   session_start();
   require "functions.php";

   if (isset($_COOKIE["num"]) && isset($_COOKIE["key"])) {
      $num = $_COOKIE["num"];
      $key = $_COOKIE["key"];

      $result = $conn -> query("SELECT username FROM user WHERE id_user=$num");
      $row    = $result -> fetch_assoc();

      if ($key === hash("sha256", $row["username"])) {
         $_SESSION["login"]    = true;
         $_SESSION["username"] = $row["username"];
      }
   }

   if(isset($_SESSION["login"])) {
      header ("Location: index.php");
      exit;
   }

   if (isset($_POST["login"])) {
      if (login($_POST) > 0) {
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
   <title>Login</title>
</head>

<body>
   <h2>Login</h2><br>
   <form action="" method="POST" enctype="multipart/form-data">
      <label for="username">Username</label><br>
      <input type="text" name="username" id="username" autocomplete="off" required><br><br>

      <label for="password">Password</label><br>
      <input type="password" name="password" id="password" required><br><br>

      <input type="checkbox" name="remember" id="remember">
      <label for="remember">Remeber Me</label><br><br>

      <button type="submit" name="login"> Submit </button>&emsp;
      <?php if(isset($errAcc)) : ?>
         <i style="color: red;">Akun Belum Terdaftar</i>
      <?php endif ?>
      <?php if(isset($errPw)) : ?>
         <i style="color: red;">Password Salah</i>
      <?php endif ?>

      <p>Belum punya akun? <a href="register.php">Buat Akun</a></p>
   </form>
</body>

</html>