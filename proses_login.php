<?php
session_start();
include "koneksi.php";

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid request method."
    ]);
    exit;
}

$username = trim($_POST['username']);
$password = trim($_POST['password']);

if ($username === "" || $password === "") {
    echo json_encode([
        "status" => "error",
        "message" => "Username dan password wajib diisi!"
    ]);
    exit;
}

$stmt = mysqli_prepare($conn, "SELECT id, username, password FROM users WHERE username = ?");
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

if ($data) {

    if (password_verify($password, $data['password'])) {

        session_regenerate_id(true);

        $_SESSION['id_user'] = $data['id'];
        $_SESSION['username'] = $data['username'];

        echo json_encode(["status" => "success"]);

    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Password salah!"
        ]);
    }
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Username tidak ditemukan!"
    ]);
}

mysqli_stmt_close($stmt);
?>
