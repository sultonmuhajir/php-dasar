<?php 
   require "functions.php";

   $id     = $_GET["id"];
   $delete = "DELETE FROM mahasiswa WHERE id = $id";

   if ($conn -> query($delete) === TRUE ) {
      header("Location: index.php");
   } else {
      echo $conn -> error;
   }
?>