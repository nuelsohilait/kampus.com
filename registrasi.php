<?php
require 'functions.php';

if (isset($_POST["register"])){

    if(registrasi($_POST) > 0 ){
        echo "<script>
                alert('User Baru Berhasil Ditambahkan')
                document.location.href = 'login.php';
                </script>";

    } else {
        echo mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Registrasi</title>
</head>
<body>

    <div class="container mt-4 pt-5">
        <div class="row">
            <div class="col-12 col-sm-8 m-auto">
                <div class="card">
                    <div class="card-body">
                    <h2 class="text-center display-6">Register</h2>
    <form action="" method="post">
    <div class="col">
    <label for="username" class="form-label">Username</label>
    <input type="text" name="username" class="form-control" id="username" required>
  </div>
  <div class="col pt-2">
    <label for="password" class="form-label">Password</label>
    <input type="text" name="password" class="form-control" id="password" required>
  </div>
  <div class="col pt-2">
    <label for="password2" class="form-label">Konfirmasi Password</label>
    <input type="text" name="password2" class="form-control" id="password2" required>
  </div>
  <div class="col-12 pt-3">
    <button class="btn btn-primary" name="register" type="submit">Register</button>
  </div>
    </form>
    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>