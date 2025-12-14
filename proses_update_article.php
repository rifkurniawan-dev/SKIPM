<?php
session_start();
header('Content-Type: application/json');
include "koneksi.php";
if (!isset($_SESSION['id_admin'])) { echo json_encode(['status'=>'error','message'=>'Tidak terautentikasi']); exit; }

$id = intval($_POST['id'] ?? 0);
$title = trim($_POST['title'] ?? '');
$summary = trim($_POST['summary'] ?? '');
$content = trim($_POST['content'] ?? '');
$is_published = (isset($_POST['is_published']) && $_POST['is_published']=='1') ? 1 : 0;

if ($id <= 0) { echo json_encode(['status'=>'error','message'=>'ID tidak valid']); exit; }
if ($title === '' || $content === '') { echo json_encode(['status'=>'error','message'=>'Judul & isi wajib']); exit; }

$stmt = $conn->prepare("UPDATE articles SET title = ?, summary = ?, content = ?, is_published = ? WHERE id = ?");
$stmt->bind_param("sssii", $title, $summary, $content, $is_published, $id);
$ok = $stmt->execute();
if ($ok) echo json_encode(['status'=>'success']);
else echo json_encode(['status'=>'error','message'=>'Gagal update: '.$stmt->error]);
$stmt->close();
