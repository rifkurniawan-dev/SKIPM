<?php
session_start();
include "koneksi.php";

header("Content-Type: application/json");

// Ambil input
$username = trim($_POST['username']);
$email    = trim($_POST['email']);
$password = trim($_POST['password']);

// Validasi input kosong
if ($username == "" || $email == "" || $password == "") {
    echo json_encode([
        "status" => "error",
        "message" => "Semua field wajib diisi!"
    ]);
    exit;
}

/* =====================================================
   CEK DUPLIKASI USERNAME
===================================================== */
$stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE username = ?");
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    echo json_encode([
        "status" => "error",
        "message" => "Username sudah digunakan!"
    ]);
    exit;
}
mysqli_stmt_close($stmt);

/* =====================================================
   CEK DUPLIKASI EMAIL
===================================================== */
$stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE email = ?");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    echo json_encode([
        "status" => "error",
        "message" => "Email sudah terdaftar!"
    ]);
    exit;
}
mysqli_stmt_close($stmt);

/* =====================================================
   HASH PASSWORD
===================================================== */
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

/* =====================================================
   SIMPAN DATA BARU
   (Tanpa kolom nama, sesuai permintaan)
===================================================== */
$stmt = mysqli_prepare($conn, 
    "INSERT INTO users (username, email, password) VALUES (?, ?, ?)"
);
mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPassword);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Gagal mendaftarkan pengguna!"
    ]);
}

mysqli_stmt_close($stmt);
?>
