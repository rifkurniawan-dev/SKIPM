<?php
include "koneksi.php";

$username = $_POST['username'];
$email    = $_POST['email'];
$password = $_POST['password'];

// Validasi duplikasi username
$q1 = mysqli_query($conn, "SELECT * FROM admins WHERE username='$username'");
if (mysqli_num_rows($q1) > 0) {
    echo json_encode(["status"=>"error", "message"=>"Username sudah digunakan"]);
    exit;
}

// Validasi duplikasi email
$q2 = mysqli_query($conn, "SELECT * FROM admins WHERE email='$email'");
if (mysqli_num_rows($q2) > 0) {
    echo json_encode(["status"=>"error", "message"=>"Email sudah terdaftar"]);
    exit;
}

// Hash password
$hashed = password_hash($password, PASSWORD_DEFAULT);

// Simpan data admin
$save = mysqli_query($conn, "
    INSERT INTO admins (username, email, password) 
    VALUES ('$username', '$email', '$hashed')
");

if ($save) {
    echo json_encode(["status"=>"success"]);
} else {
    echo json_encode(["status"=>"error", "message"=>"Gagal menyimpan data ke database"]);
}
