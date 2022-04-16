<?php
session_start();

    // Cek Cookie
    if(isset($_COOKIE['id']) && isset($_COOKIE['key'])  ){
    $id = $_COOKIE['id'];
    $key = $_COOKIE['key'];

    // Ambil Username Berdasarkan ID
    $result = mysqli_query($conn, "SELECT username FROM user WHERE id = $id");
    $row = mysqli_fetch_assoc($result);

    // Cek Cookie dan Username
    if( $key == hash('sha256', $row['username'])){
        $_SESSION['login'] = true;
    }
}

if(isset($_SESSION["login"])){
    header("Location: index.php");
    exit;
}

require 'functions.php';

if(isset($_POST["login"])){

    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

    // Cek Username
    if(mysqli_num_rows($result) === 1){

        // Cek Password
        $row = mysqli_fetch_assoc($result);
        if(password_verify($password, $row["password"])){

            // Set Session
            $_SESSION["login"] = true;

            // Cek Remember Me
            if(isset($_POST['remember'])){
                
                // Buat Cookie

                setcookie('id', $row['id'], time() + 60);
                setcookie('key', hash('sha256', $row['username']), time() + 60);
            }

            header("Location: index.php");
            exit;
        }
    }

    $error = true;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
</head>
<body>

    <?php if (isset($error)): ?>
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
        </symbol>
    </svg>

    <div class="alert alert-danger d-flex align-items-center" role="alert">
    
    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
    
    <div>
    Username / Password Salah
    </div>
    </div>

    <?php endif; ?>
    
    <section>
        <div class="container mt-4 pt-5">
            <div class="row">
                <div class="col-12 col-sm-8 col-md-6 m-auto">
                    <div class="card">
                        <div class="card-body">

                            <h2 class="text-center">Sign in!</h2>

                            <form action="" method="post">

                            <!-- Email input -->
                            <div class="form-floating mb-3">
                                <input type="username" class="form-control my-4" name="username" id="username" placeholder="Username...">
                                <label for="floatingInput">Username</label>
                            </div>

                            <!-- Password input -->
                            <div class="form-floating">
                                <input type="password" class="form-control my-4" name="password" id="password" placeholder="Password...">
                                <label for="floatingPassword">Password</label>
                            </div> 
                            
                            <!-- Checkbox -->
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" name="remember" id="remember" checked />
                                <label class="form-check-label" for="form2Example31"> Remember me </label>
                            </div>
                               
                            <!-- Submit button -->
                            <div class="text-center mt-2">
                            <button type="submit" name="login" class="btn btn-primary btn-block mb-3">Sign in</button>

                            <!-- Register buttons -->
                            <div class="text-center">
                                <p>Belum Daftar? <a href="registrasi.php">Register</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</form> 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>