<?php
session_start();
include "koneksi.php";

// Pastikan koneksi tersedia
if (!isset($conn)) {
    die("Koneksi database tidak tersedia.");
}

// Cek login admin
if (!isset($_SESSION['id_admin'])) {
    header("Location: login_admin.php");
    exit;
}

// Ambil data admin (jika ada), untuk menampilkan di sidebar
$admin = ['username' => 'Admin', 'email' => 'admin@example.com'];
$id_admin = intval($_SESSION['id_admin'] ?? 0);

if ($id_admin > 0) {
    $stmtAdmin = $conn->prepare("SELECT username, email FROM admins WHERE id = ? LIMIT 1");
    if ($stmtAdmin) {
        $stmtAdmin->bind_param("i", $id_admin);
        $stmtAdmin->execute();
        $resAdmin = $stmtAdmin->get_result();
        if ($resAdmin && $resAdmin->num_rows === 1) {
            $adminRow = $resAdmin->fetch_assoc();
            // Pastikan nilai tidak null sebelum assign
            if (!empty($adminRow['username'])) $admin['username'] = $adminRow['username'];
            if (!empty($adminRow['email'])) $admin['email'] = $adminRow['email'];
        }
        $stmtAdmin->close();
    }
}

// Ambil ID artikel dari query string
$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    header("Location: artikel_admin.php");
    exit;
}

// Ambil data artikel
$stmt = $conn->prepare("SELECT id, judul, slug, isi, gambar, link_manual FROM artikel WHERE id = ? LIMIT 1");
if (!$stmt) {
    die("Gagal menyiapkan query artikel: " . $conn->error);
}
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();

if (!$res || $res->num_rows !== 1) {
    $stmt->close();
    header("Location: artikel_admin.php");
    exit;
}

$article = $res->fetch_assoc();
$stmt->close();

// timezone fallback (opsional)
date_default_timezone_set("Asia/Jakarta");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Edit Artikel</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">

    <script>
        function buatSlug(text) {
            return text.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, "")
                .replace(/\s+/g, "-")
                .replace(/-+/g, "-");
        }

        function updatePreview() {
            let judul = document.getElementById("judul").value;
            let slug = buatSlug(judul);

            document.getElementById("slug").value = slug;

            let autoLink = "berita_detail.php?slug=" + encodeURIComponent(slug);
            const previewAutoLink = document.getElementById("previewAutoLink");
            const previewAutoText = document.getElementById("previewAutoText");

            if (previewAutoLink) previewAutoLink.href = autoLink;
            if (previewAutoText) previewAutoText.innerText = autoLink;

            const previewBox = document.getElementById("previewBox");
            if (previewBox) previewBox.classList.remove("hidden");
        }
    </script>

    <style>
        main { padding-left: 16rem; }
    </style>
</head>

<body class="bg-gray-100 min-h-screen">

<!-- NAVBAR -->
<header class="w-full bg-blue-500 text-white py-3 px-6 flex justify-between items-center fixed top-0 left-0 z-50 shadow-md">
    <h1 class="text-lg font-semibold tracking-wide"></h1>

    <div class="flex items-center space-x-4">
        <!-- JAM REALTIME -->
        <span id="jam-aktif" class="text-sm opacity-85"><?= date("H:i:s"); ?></span>

        <script>
            function updateJam() {
                const el = document.getElementById('jam-aktif');
                if (!el) return;
                const now = new Date();
                const hh = String(now.getHours()).padStart(2, '0');
                const mm = String(now.getMinutes()).padStart(2, '0');
                const ss = String(now.getSeconds()).padStart(2, '0');
                el.innerText = `${hh}:${mm}:${ss}`;
            }
            updateJam();
            setInterval(updateJam, 1000);
        </script>

        <a href="logout_admin.php" class="bg-red-500 hover:bg-red-600 text-white px-4 py-1 rounded">Logout</a>
    </div>
</header>

<!-- SIDEBAR -->
<aside class="w-64 bg-blue-900 text-white shadow-lg fixed inset-y-0 left-0 z-40" style="top:56px;">
    <div class="p-4 flex flex-col items-center border-b border-blue-700">
        <img src="merak.png" class="w-24 mb-2" alt="logo">
    </div>

    <nav class="mt-5 px-4">
        <a href="dashboard_admin.php" class="block px-4 py-2 rounded-md mb-2 hover:bg-blue-700 font-semibold">Dashboard</a>
        <a href="artikel_admin.php" class="block px-4 py-2 rounded-md mb-2 hover:bg-blue-700 font-semibold">Berita dan Artikel</a>
    </nav>
</aside>

<!-- CONTENT -->
<div class="ml-64 pt-24 px-6">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
        <form action="artikel_update.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= htmlspecialchars($article['id']); ?>">
            <input type="hidden" id="slug" name="slug" value="<?= htmlspecialchars($article['slug']); ?>">

            <label class="block font-medium">Judul</label>
            <input type="text" id="judul" name="judul" value="<?= htmlspecialchars($article['judul']); ?>"
                   class="w-full border p-2 rounded mb-3" onkeyup="updatePreview()">

            <label class="block font-medium">Link Akses</label>
            <input type="url" name="link_manual" value="<?= htmlspecialchars($article['link_manual'] ?? ''); ?>"
                   class="w-full border p-2 rounded mb-3">


            <label class="block font-medium">Isi</label>
            <textarea name="isi" class="w-full border p-2 rounded mb-3 h-40"><?= htmlspecialchars($article['isi']); ?></textarea>

            <div class="mb-3">
                <?php
                $img_src = 'default-berita.jpg';
                if (!empty($article['gambar']) && file_exists(__DIR__ . '/uploads/' . $article['gambar'])) {
                    $img_src = 'uploads/' . $article['gambar'];
                }
                ?>
                <img src="<?= htmlspecialchars($img_src); ?>" class="w-48 h-32 object-cover rounded mb-2" alt="preview gambar">
            </div>

            <label class="block font-medium">Update Gambar</label>
            <input type="file" name="gambar" class="mb-3">

            <input type="hidden" name="old_gambar" value="<?= htmlspecialchars($article['gambar'] ?? ''); ?>">

            <div class="flex items-center gap-3">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
                <a href="artikel_admin.php" class="px-4 py-2 bg-gray-100 rounded border">Kembali</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
