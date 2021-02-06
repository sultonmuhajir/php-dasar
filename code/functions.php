<?php 
   $conn = new mysqli("localhost", "root", "", "mydb");

   if ($conn -> connect_error) {
      die($conn -> connect_error);
   }



   function search($key) {
      global $conn;
      $search = "SELECT * FROM mahasiswa WHERE 
                     nama LIKE '%$key%' OR
                     prodi LIKE '%$key%' OR
                     fakultas LIKE '%$key%' ";

      return $conn -> query($search);
   }



   function insert($data) {
      global $conn;
      $nama     = htmlspecialchars($data["nama"]);
      $prodi    = htmlspecialchars($data["prodi"]);
      $fakultas = htmlspecialchars($data["fakultas"]);
      $gambar   = upload();

      if (!$gambar) {
         return false;
      }

      $cek = $conn -> query("SELECT nama FROM mahasiswa WHERE nama='$nama' ");
      if ($cek -> num_rows >= 1) {
         global $errName; $errName = true;
         return false;
      }

      $insert = "INSERT INTO mahasiswa VALUES 
                  (NULL, '$gambar', '$nama', '$prodi', '$fakultas' )";
      return $conn -> query($insert);
   }



   function update($data){
      global $conn;
      $id       = $data["id"];
      $nama     = htmlspecialchars($data["nama"]);
      $prodi    = htmlspecialchars($data["prodi"]);
      $fakultas = htmlspecialchars($data["fakultas"]);

      $gambarLama = ($data["gambarLama"]);
      if ($_FILES["gambar"]["error"] === 4 ) {
         $gambar = $gambarLama;
      } else {
         $gambar = upload();
         if (!$gambar) {
            return false;
         }
      }

      $update = "UPDATE mahasiswa SET 
                        nama     = '$nama',
                        gambar   = '$gambar',
                        prodi    = '$prodi',
                        fakultas = '$fakultas'
                     WHERE id=$id";
      return $conn -> query($update);
   }



   function upload() {
      // $id         = $_POST["id"];
      $namaFile   = $_FILES["gambar"]["name"];
      $ukuranFile = $_FILES["gambar"]["size"];
      $tmpName    = $_FILES["gambar"]["tmp_name"];

      $ekstensiGambarValid = ["jpg", "png", "jpeg"];
      $ekstensiGambar = explode(".", $namaFile);
      $ekstensiGambar = strtoLower(end($ekstensiGambar));
      if(!in_array($ekstensiGambar, $ekstensiGambarValid)) {
         global $errImg; $errImg = true;
         return false;
      }

      if($ukuranFile > 1000000) {
         global $errSize; $errSize = true;
         return false;
      }

      // $gambar = "id".$id.".".$ekstensiGambar;
      $gambar = uniqid().".".$ekstensiGambar;

      move_uploaded_file($tmpName, "img/".$gambar);
      return $gambar;
   }



   function register($data) {
      global $conn;
      $username  = htmlspecialchars($data["username"]);
      $password  = htmlspecialchars($data["password"]);
      $password2 = htmlspecialchars($data["password2"]);

      $cek = $conn -> query("SELECT username FROM user WHERE username='$username' ");
      if ($cek -> num_rows >= 1 ) {
         global $errUname; $errUname = true;
         return false;
      }

      if ($password !== $password2) {
         global $errPw; $errPw = true;
         return false;
      }

      $password = password_hash($password, PASSWORD_DEFAULT);

      $register = "INSERT INTO user VALUE (NULL, '$username', '$password')";
      return $conn -> query($register);
   }



   function login($data) {  
      global $conn;
      $username = $data["username"];
      $password = $data["password"];

      $cek = $conn -> query("SELECT * FROM user WHERE username='$username'");
      if($cek -> num_rows >= 1) {
         $row = $cek -> fetch_assoc();
         if (password_verify($password, $row["password"])) {
            $_SESSION["login"] = true;
            $_SESSION["username"] = $username;
            if(isset($_POST["remember"])) {
               setcookie("num", $row["id_user"], time()+3600);
               setcookie("key", hash("sha256", $row["username"]), time()+3600);
            }
         } else {
            global $errPw; $errPw = true;
            return false;
         }
      }
      global $errAcc; $errAcc = true;
      return $conn -> affected_rows;
   }
?>