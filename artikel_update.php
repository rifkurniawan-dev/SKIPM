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
$judul = trim($_POST['judul'] ?? '');
$slug = trim($_POST['slug'] ?? '');
$link_manual = trim($_POST['link_manual'] ?? '');
$isi = $_POST['isi'] ?? '';
$old_gambar = $_POST['old_gambar'] ?? '';

if ($id <= 0 || $judul === '' || $isi === '') {
    $_SESSION['artikel_errors'] = ["Data tidak lengkap."];
    header("Location: artikel_edit.php?id=" . $id);
    exit;
}

// proses upload gambar baru jika ada
$upload_dir = __DIR__ . '/uploads';
if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);

$new_gambar_filename = $old_gambar;
if (!empty($_FILES['gambar']['name']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['gambar'];
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $allowed = ['jpg','jpeg','png','webp','gif'];
    if (!in_array(strtolower($ext), $allowed)) {
        $_SESSION['artikel_errors'] = ["Format gambar tidak diizinkan."];
        header("Location: artikel_edit.php?id=" . $id);
        exit;
    }
    $new_gambar_filename = time() . '_' . preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $file['name']);
    $target = $upload_dir . '/' . $new_gambar_filename;
    if (!move_uploaded_file($file['tmp_name'], $target)) {
        $_SESSION['artikel_errors'] = ["Gagal mengunggah gambar."];
        header("Location: artikel_edit.php?id=" . $id);
        exit;
    }
    // hapus file lama bila ada dan berbeda
    if (!empty($old_gambar) && file_exists($upload_dir . '/' . $old_gambar) && $old_gambar !== $new_gambar_filename) {
        @unlink($upload_dir . '/' . $old_gambar);
    }
}

// update DB
$stmt = $conn->prepare("UPDATE artikel SET judul = ?, slug = ?, isi = ?, gambar = ?, link_manual = ?, updated_at = NOW() WHERE id = ?");
if (!$stmt) {
    $_SESSION['artikel_errors'] = ["Prepare failed: " . $conn->error];
    header("Location: artikel_edit.php?id=" . $id);
    exit;
}
$stmt->bind_param("sssssi", $judul, $slug, $isi, $new_gambar_filename, $link_manual, $id);
$ok = $stmt->execute();
$stmt->close();

if ($ok) {
    header("Location: artikel_admin.php");
    exit;
} else {
    $_SESSION['artikel_errors'] = ["Gagal mengupdate artikel: " . $conn->error];
    header("Location: artikel_edit.php?id=" . $id);
    exit;
}
