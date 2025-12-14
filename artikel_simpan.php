<?php
session_start();
include "koneksi.php"; // harus menghasilkan $conn (mysqli)

// cek session admin
if (!isset($_SESSION['id_admin'])) {
    header("Location: login_admin.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: artikel_admin.php");
    exit;
}

// ambil data, trim untuk keamanan dasar
$judul = trim($_POST['judul'] ?? '');
$slug = trim($_POST['slug'] ?? '');
$link_manual = trim($_POST['link_manual'] ?? '');
$isi = trim($_POST['isi'] ?? '');

// validasi sederhana
$errors = [];
if ($judul === '') $errors[] = "Judul wajib diisi.";
if ($isi === '') $errors[] = "Isi berita wajib diisi.";
if ($slug === '') {
    // fallback slug bila kosong (safety)
    $slug = preg_replace('/[^a-z0-9\-]/', '-', strtolower(trim($judul)));
    $slug = preg_replace('/-+/', '-', $slug);
    $slug = trim($slug, '-');
}
if (!empty($errors)) {
    // bisa memperbaiki: simpan ke session atau tampilkan
    $_SESSION['artikel_errors'] = $errors;
    header("Location: artikel_admin.php");
    exit;
}

// proses upload gambar (opsional)
$upload_dir = __DIR__ . '/uploads';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

$gambar_filename = null;
if (!empty($_FILES['gambar']['name'])) {
    $file = $_FILES['gambar'];
    // cek error
    if ($file['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $allowed = ['jpg','jpeg','png','webp','gif'];
        if (!in_array(strtolower($ext), $allowed)) {
            $_SESSION['artikel_errors'] = ["Format gambar tidak diijinkan. (jpg, png, webp)"];
            header("Location: artikel_admin.php");
            exit;
        }
        // buat nama file unik
        $gambar_filename = time() . '_' . preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $file['name']);
        $target = $upload_dir . '/' . $gambar_filename;
        if (!move_uploaded_file($file['tmp_name'], $target)) {
            $_SESSION['artikel_errors'] = ["Gagal mengunggah gambar."];
            header("Location: artikel_admin.php");
            exit;
        }
    } else {
        // kalau error, bisa abaikan atau set error
        // kita abaikan upload bila error kecil
        $gambar_filename = null;
    }
}

// simpan ke DB dengan prepared statement
$stmt = $conn->prepare("INSERT INTO artikel (judul, slug, isi, gambar, link_manual) VALUES (?, ?, ?, ?, ?)");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("sssss", $judul, $slug, $isi, $gambar_filename, $link_manual);
$ok = $stmt->execute();
if (!$ok) {
    // jika duplicate slug, tambahkan suffix
    if ($conn->errno == 1062) { // duplicate entry
        $slug = $slug . '-' . time();
        $stmt = $conn->prepare("INSERT INTO artikel (judul, slug, isi, gambar, link_manual) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $judul, $slug, $isi, $gambar_filename, $link_manual);
        $ok = $stmt->execute();
    }
}

$stmt->close();

if ($ok) {
    // sukses: redirect ke beranda atau kembali ke admin list
    header("Location: beranda.php");
    exit;
} else {
    $_SESSION['artikel_errors'] = ["Gagal menyimpan artikel: " . $conn->error];
    header("Location: artikel_admin.php");
    exit;
}
