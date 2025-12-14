<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.php");
    exit;
}

$judul = $_POST['judul'];
$isi   = $_POST['isi'];
$link  = $_POST['link'];

$gambar = "";

if (!empty($_FILES['gambar']['name'])) {
    $gambar = time() . "_" . $_FILES['gambar']['name'];
    move_uploaded_file($_FILES['gambar']['tmp_name'], "upload/" . $gambar);
}

$query = "INSERT INTO berita (judul, isi, gambar, link) VALUES (
    '$judul', '$isi', '$gambar', '$link'
)";

mysqli_query($conn, $query);

header("Location: dashboard_admin.php?success=1");
exit;
