<?php
session_start();
include "koneksi.php";

// Cek login
if (!isset($_SESSION['id_admin'])) {
    header("Location: login_admin.php");
    exit;
}

// Hapus berita
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM berita WHERE id='$id'");
    header("Location: artikel_list.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Berita & Artikel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100">

<div class="max-w-4xl mx-auto mt-10 bg-white p-6 rounded-lg shadow">
    <div class="flex justify-between mb-4">
        <h2 class="text-2xl font-bold">📚 Berita & Artikel</h2>
        <a href="artikel_admin.php" class="px-4 py-2 bg-green-600 text-white rounded">+ Tambah Berita</a>
    </div>

    <table class="w-full border">
        <tr class="bg-gray-200 text-left">
            <th class="p-2">Judul</th>
            <th class="p-2">Tanggal</th>
            <th class="p-2">Aksi</th>
        </tr>

        <?php
        $q = mysqli_query($conn, "SELECT * FROM berita ORDER BY id DESC");
        while ($row = mysqli_fetch_assoc($q)):
        ?>
        <tr>
            <td class="p-2 border"><?= $row['judul']; ?></td>
            <td class="p-2 border"><?= $row['tanggal']; ?></td>
            <td class="p-2 border">
                <a href="artikel_edit.php?id=<?= $row['id']; ?>" class="text-blue-600">Edit</a> |
                <a onclick="return confirm('Hapus berita ini?')" href="artikel_list.php?hapus=<?= $row['id']; ?>" class="text-red-600">Hapus</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>
