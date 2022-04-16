<?php

session_start();

if (!isset($_SESSION["login"])){
  header("Location: login.php");
  exit;
}

require 'functions.php';


// Konfigurasi Pagination
$batas = 5;
$halaman = isset($_GET['halaman'])?(int)$_GET['halaman'] : 1;
$halaman_awal = ($halaman>1) ? ($halaman * $batas) - $batas : 0;	
 
$previous = $halaman - 1;
$next = $halaman + 1;
				
$data = mysqli_query($conn,"SELECT * FROM tb_mahasiswa");
$jumlah_data = mysqli_num_rows($data);
$total_halaman = ceil($jumlah_data / $batas);
 
$mahasiswa = mysqli_query($conn,"SELECT * FROM tb_mahasiswa LIMIT $halaman_awal, $batas");
$nomor = $halaman_awal+1;

// Tombol Cari Ditekan
if(isset($_POST["cari"])){
  $mahasiswa = cari($_POST["keyword"]);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/cc01aa3928.js" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
  <div class="container-fluid">

    <a class="navbar-brand" href="index.php">Kampus.com</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Home</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="logout.php">Logout</a>
        </li>
      </ul>

      <form class="d-flex" action="" method="post">
        <input class="form-control me-2" type="text" name="keyword" value="<?php if(isset($_GET['keyword'])) { echo $_GET['keyword']; } ?>" autocomplete="off" placeholder="Search" autofocus>
        <button class="btn btn-outline-light" name="cari" type="submit">Search</button>
      </form>

    </div>
  </div>
</nav>

  <div class="judul ps-5 mt-2">
  <h1 class="display-5 ps-4 mb-3">Daftar Mahasiswa</h1>

  <a href="tambah.php" class="h6 ps-4"> <i class="fa-solid fa-circle-plus"></i> Tambah Mahasiswa </a>
  </div>

  <br>
  <div class="container mt-1 pt-1">
            <div class="row">
                <div class=" m-auto">
                    <div class="card">
                        <div class="card-body">
                            <table class="table align-middle table-hover" cellpadding="10" cellspacing="0">
                            <caption>Total Mahasiswa: <?= $jumlah_data ?></caption>
                                    <tr>
                                        <th>No.</th>
                                        <th>Aksi</th>
                                        <th>Gambar</th>
                                        <th>NRP</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Jurusan</th>
                                    </tr>
                                      <?php $i = 1; ?>
                                      <?php foreach ($mahasiswa as $row) : ?>
                                    <tr>
                                      <td><?= $i; ?></td>
                                      <td>
                                      <a href="ubah.php?id=<?= $row["id"];?>"><i class="fa-solid fa-pen-to-square"></i></a> |
                                      <a href="hapus.php?id=<?= $row["id"]; ?>" onclick="return confirm('Yakin Ingin Mengahpus Data Ini?');"><i class="fa-solid fa-eraser"></i></a>
                                      </td>
                                      <td><img  src="img/<?= $row["foto"]; ?>" width="50" height=""> </td>
                                      <td><?= $row["nrp"]; ?></td>
                                      <td><?= $row["nama"]; ?></td>
                                      <td><?= $row["email"]; ?></td>
                                      <td><?= $row["jurusan"]; ?></td>
                                    </tr>
                                    <?php $i++ ?>
                                    <?php endforeach ?> 
                            </table>
                            
    <nav>
			<ul class="pagination justify-content-center">
				<li class="page-item">
					<a class="page-link" <?php if($halaman > 1){ echo "href='?halaman=$previous'"; } ?>>Previous</a>
				</li>
				<?php 
				for($x=1;$x<=$total_halaman;$x++){
					?> 
					<li class="page-item"><a class="page-link" href="?halaman=<?php echo $x ?>"><?php echo $x; ?></a></li>
					<?php
				}
				?>				
				<li class="page-item">
					<a  class="page-link" <?php if($halaman < $total_halaman) { echo "href='?halaman=$next'"; } ?>>Next</a>
				</li>
			</ul>
		</nav>
                        </div>
                    </div>
                </div>
            </div>
  </div>
  <?php include 'footer.php';?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>