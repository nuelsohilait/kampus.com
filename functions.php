<?php
// koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "mahasiswa");

function query($query){

    global $conn;

    $result = mysqli_query($conn, $query);
    $rows = [];
    while( $row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }
    return $rows;
}

function tambah($data){
    
    global $conn;
    
    $nrp = htmlspecialchars($data["nrp"]);
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data["jurusan"]);
    
    // Upload Foto
    $foto = upload();
    if(!$foto){
        return false;   
    }

    $query = "INSERT INTO tb_mahasiswa VALUES
             ('','$nrp', '$nama', '$email', '$jurusan', '$foto')";
                
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function upload(){
    
    $namafile = $_FILES['foto']['name'];
    $ukuranfile = $_FILES['foto']['size'];
    $error = $_FILES['foto']['error'];
    $tmpName = $_FILES['foto']['tmp_name'];

    // Cek Apakah Tidak Ada Data Yang Di Upload
    if($error === 4){
        echo "<script>
                alert('Pilih Gambar Terlebih Dahulu!');
              </script>";
        return false;
    }

    // Cek Apakah File Yang Diupload Adalah Gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namafile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if ( !in_array($ekstensiGambar, $ekstensiGambarValid)){
        echo "<script>
                alert('Yang Anda Upload Bukan Gambar!');
                </script>";
                return false;
    }

    // Cek Jika Ukuran File Terlalu Besar
    if ( $ukuranfile > 1000000){
        echo "<script>
                alert('Yang Anda Upload Bukan Gambar!');
                </script>";
                return false;
    } 

    // Lolos Pengecekan, Gambar Siap Diupload
    // Generate Nama Gambar Baru
    $namafilebaru = uniqid();
    $namafilebaru .= '.';
    $namafilebaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, 'img/' . $namafilebaru);

    return $namafilebaru;
    
}

function hapus($id) {
    global $conn;
    
    mysqli_query($conn, "DELETE FROM tb_mahasiswa WHERE id = $id");

    return mysqli_affected_rows($conn);
}

function ubah($data) {
    global $conn;
    
    $id = $data["id"];
    $nrp = htmlspecialchars($data["nrp"]);
    $nama = htmlspecialchars($data["nama"]);
    $email = htmlspecialchars($data["email"]);
    $jurusan = htmlspecialchars($data["jurusan"]);
    $fotolama = htmlspecialchars($data["fotolama"]);

    // Cek Apakah User Pilih Gambar Baru Atau Tidak
    if( $_FILES['foto']['error'] === 4 ){
        $foto = $fotolama;
    } else {
        $foto = upload();
    }
    

    $query = "UPDATE tb_mahasiswa SET
                nrp ='$nrp',
                nama ='$nama',
                email ='$email',
                jurusan ='$jurusan',
                foto ='$foto'
                WHERE id = $id
                ";
                
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function cari($keyword){
    $query = "SELECT * FROM tb_mahasiswa WHERE 
    nama LIKE '%$keyword%' OR 
    nrp LIKE '%$keyword%' OR
    email LIKE '%$keyword%' OR
    jurusan LIKE '%$keyword%'";
    return query($query);
}

function registrasi($data) {
    global $conn;

    $username = strtolower(stripslashes($data["username"]));
    $password = mysqli_real_escape_string($conn, $data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);

    // Cek Username Sudah Ada Atau Belum
    $result = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
    if(mysqli_fetch_assoc($result)) {
        echo "<script>
                alert('Username Sudah Digunakan!');
                </script>";
                return false;
    }

    // Cek Konfirmasi Password
    if( $password !== $password2) {
        echo "<script>
                alert('Konfirmasi Password Tidak Sesuai!');
                </script>";
                return false;
    }

    // Enkripsi Password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Tambahkan User Baru Ke Database
    mysqli_query($conn, "INSERT INTO user VALUES('', '$username', '$password')");

    return mysqli_affected_rows($conn);

}
?>           