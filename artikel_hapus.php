<?php
session_start();
include "koneksi.php";
if (!isset($_SESSION['id_admin'])) {
    header("Location: login_admin.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: artikel_admin.php");
    exit;
}

$id = intval($_POST['id'] ?? 0);
if ($id <= 0) {
    header("Location: artikel_admin.php");
    exit;
}

// ambil nama file gambar dulu
$stmt = $conn->prepare("SELECT gambar FROM artikel WHERE id = ? LIMIT 1");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$gambar = null;
if ($res && $res->num_rows === 1) {
    $row = $res->fetch_assoc();
    $gambar = $row['gambar'];
}
$stmt->close();

// hapus record
$stmt = $conn->prepare("DELETE FROM artikel WHERE id = ?");
$stmt->bind_param("i", $id);
$ok = $stmt->execute();
$stmt->close();

// jika berhasil hapus DB, hapus file gambar fisik
if ($ok) {
    $upload_dir = __DIR__ . '/uploads';
    if (!empty($gambar) && file_exists($upload_dir . '/' . $gambar)) {
        @unlink($upload_dir . '/' . $gambar);
    }
    header("Location: artikel_admin.php");
    exit;
} else {
    $_SESSION['artikel_errors'] = ["Gagal menghapus artikel: " . $conn->error];
    header("Location: artikel_admin.php");
    exit;
}
