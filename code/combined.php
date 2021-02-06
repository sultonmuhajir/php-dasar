<?php
   require "functions.php";
   $result = $conn -> query("SELECT * FROM mahasiswa");
?>



<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title> Combined </title>
   
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" 
   rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
   <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
</head>

<body>
   <!-- Insert Data -->
   <div class="container mt-4">
      <h2 class="text-center">Tabel Mahasiswa</h2><br>

      <button type="button" class="btn btn-success mx-auto" data-bs-toggle="modal" data-bs-target="#create"
         style="display: block;">
         <i class="fas fa-plus-circle"></i>&nbsp;Insert Data
      </button>
      <?php
         if (isset($_POST["insert"]) ) {
            if (insert($_POST) === TRUE ) {
               echo "<script>document.location.href='combined.php';</script>";
            } else {
               echo $conn -> error;
            }
         }
      ?>
      <div class="modal fade" id="create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
               <form action="" method="POST" enctype="multipart/form-data">
                  <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLabel">Insert Data</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                     <label for="nama" class="form-label">Nama</label>
                     <input type="text" class="form-control mb-3" name="nama" id="nama" autocomplete="off" required>

                     <label for="prodi" class="form-label">Prodi</label>
                     <input type="text" class="form-control mb-3" name="prodi" id="prodi" autocomplete="off" required>

                     <label for="fakultas" class="form-label">Fakultas</label>
                     <input type="text" class="form-control mb-3" name="fakultas" id="fakultas" autocomplete="off"
                        required>

                     <label for="gambar" class="form-label">Gambar</label>
                     <input type="file" class="form-control mb-3" name="gambar" id="gambar" required>
                  </div>
                  <div class="modal-footer">
                     <button type="submit" name="insert" class="btn btn-primary">Submit</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
      <?php if(isset($errName)) : ?>
         <script>
            alert("Nama Sudah Ada");
         </script>
      <?php endif ?>
      <?php if(isset($errImg)) : ?>
         <script>
            alert("Hanya Menerima File .jpg .png .jpeg");
         </script>
      <?php endif ?>
      <?php if(isset($errSize)) : ?>
         <script>
            alert("Maksimal Ukuran Gambar 1MB");
         </script>
      <?php endif ?>


      <!-- Read Data -->
      <table class="table table-striped table-borderless" id="myTable" style="padding: 20px 0;">
         <thead class="table-dark">
            <tr>
               <th>No</th>
               <th>Gambar</th>
               <th>Nama</th>
               <th>Prodi</th>
               <th>Fakultas</th>
               <th>Aksi</th>
            </tr>
         </thead>

         <tbody>
            <?php $i = 1 ?>
            <?php while($row = $result -> fetch_assoc()) : ?>
               <tr>
                  <td><?= $i++ ?></td>
                  <td><img src="img/<?= $row['gambar'] ?>" alt="Gambar" width="60"></td>
                  <td><?= $row["nama"] ?></td>
                  <td><?= $row["prodi"] ?></td>
                  <td><?= $row["fakultas"] ?></td>
                  <td width="100">
                     <a href="" data-bs-toggle="modal" data-bs-target="#id<?= $row["id"] ?>" style="text-decoration: none">
                        <i class="fas fa-edit" style="color: blue"></i>
                     </a> &emsp;
                     <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin?')"
                        style="text-decoration: none">
                        <i class="fas fa-trash-alt" style="color: red"></i>
                     </a>
                  </td>
               </tr>


               <!-- Update Data -->
               <?php
                  if (isset($_POST["update"]) ) {
                     if (update($_POST) === TRUE ) {
                        echo "<script>document.location.href='combined.php';</script>";
                     } else {
                        echo $conn -> error;
                     }
                  }
               ?>
               <div class="modal fade" id="id<?= $row["id"] ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
                  aria-hidden="true">
                  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
                     <div class="modal-content">
                        <form action="" method="POST" enctype="multipart/form-data">
                           <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Update Data</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                           </div>
                           <div class="modal-body">
                              <input type="hidden" name="id" value="<?= $row["id"] ?>">
                              <input type="hidden" name="gambarLama" value="<?= $row["gambar"] ?>">

                              <label for="nama" class="form-label">Nama</label>
                              <input type="text" class="form-control mb-3" name="nama" id="nama" autocomplete="off"
                                 required value="<?= $row["nama"] ?>">

                              <label for="prodi" class="form-label">Prodi</label>
                              <input type="text" class="form-control mb-3" name="prodi" id="prodi" autocomplete="off"
                                 required value="<?= $row["prodi"] ?>">

                              <label for="fakultas" class="form-label">Fakultas</label>
                              <input type="text" class="form-control mb-3" name="fakultas" id="fakultas" autocomplete="off"
                                 required value="<?= $row["fakultas"] ?>">

                              <label for="gambar" class="form-label">Gambar</label><br>
                              <img src="img/<?= $row['gambar'] ?>" alt="Gambar" width="100" class="mb-2">
                              <input type="file" class="form-control mb-3" name="gambar" id="gambar">
                           </div>
                           <div class="modal-footer">
                              <button type="submit" name="update" class="btn btn-primary">Submit</button>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            <?php endwhile ?>
            <?php if(isset($errImg)) : ?>
               <script>
                  alert("Hanya Menerima File .jpg .png .jpeg");
               </script>
            <?php endif ?>
            <?php if(isset($errSize)) : ?>
               <script>
                  alert("Maksimal Ukuran Gambar 1MB");
               </script>
            <?php endif ?>
         </tbody>
      </table>
   </div>

   <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" 
   crossorigin="anonymous"></script>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" 
   integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
   <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
   <script>
      $(document).ready( function () {
         $('#myTable').DataTable();
      } );
   </script>
</body>

</html>