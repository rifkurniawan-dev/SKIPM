<?php
session_start();
include "koneksi.php";
if (!isset($_SESSION['id_admin'])) {
    header("Location: login_admin.php");
    exit;
}

// ambil data admin (sesuaikan nama tabel jika berbeda)
$admin = ['username' => 'Admin', 'email' => 'admin@example.com'];
$id_admin = $_SESSION['id_admin'];
if (isset($conn) && $id_admin) {
    $stmt = $conn->prepare("SELECT username, email FROM admins WHERE id = ? LIMIT 1");
    if ($stmt) {
        $stmt->bind_param("i", $id_admin);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res && $res->num_rows === 1) $admin = $res->fetch_assoc();
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Tambah Artikel</title>

  <!-- Tailwind CDN -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">

  <style>
    main { padding-left: 16rem; } /* agar tidak tertutup sidebar w-64 */
  </style>

  <script>
    function buatSlug(text) {
      return text
        .toLowerCase()
        .replace(/[^a-z0-9\s-]/g, "")
        .replace(/\s+/g, "-")
        .replace(/-+/g, "-")
        .replace(/^-+|-+$/g, "");
    }

    function updatePreview() {
      let judul = document.getElementById("judul").value;
      let slug = buatSlug(judul);
      document.getElementById("slug").value = slug;
      let autoLink = "berita_detail.php?slug=" + encodeURIComponent(slug);
      document.getElementById("previewAutoLink").href = autoLink;
      document.getElementById("previewAutoText").innerText = autoLink;
      document.getElementById("previewBox").classList.remove("hidden");
    }
  </script>
</head>
<body class="bg-gray-100 min-h-screen">

<!-- ================= NAVBAR ================= -->
<header class="w-full bg-blue-500 text-white py-3 px-6 flex justify-between items-center fixed top-0 left-0 z-50 shadow-md">
    <h1 class="text-lg font-semibold tracking-wide"></h1>

    <div class="flex items-center space-x-4">

        <!-- JAM AKTIF SAJA -->
        <span id="jam-aktif" class="text-sm opacity-85">
            <?= date("H:i:s"); ?>
        </span>

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

        <!-- LOGOUT -->
        <a href="logout_admin.php" 
           class="bg-red-500 hover:bg-red-600 text-white px-4 py-1 rounded">
            Logout
        </a>
    </div>
</header>

<!-- ================= SIDEBAR ================= -->
<aside class="w-64 bg-blue-900 text-white shadow-lg fixed inset-y-0 left-0 z-40" style="top:56px;">
    <div class="p-4 flex flex-col items-center border-b border-blue-700">
        <img src="merak.png" class="w-24 mb-2" alt="logo">
    </div>

    <nav class="mt-5 px-4">
        <a href="dashboard_admin.php" class="block px-4 py-2 rounded-md mb-2 hover:bg-blue-700 font-semibold">Dashboard</a>
        <a href="artikel_admin.php" class="block px-4 py-2 rounded-md mb-2 hover:bg-blue-700 font-semibold">Berita dan Artikel</a>
    </nav>
</aside>

<main class="pt-10 pb-12">
  <div class="max-w-3xl mx-auto mt-6 bg-white p-6 rounded-lg shadow">
    

    <!-- tampilkan error / sukses -->
    <?php if (!empty($_SESSION['artikel_errors'])): ?>
      <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded">
        <?php foreach ($_SESSION['artikel_errors'] as $err): ?>
          <div>- <?= htmlspecialchars($err) ?></div>
        <?php endforeach; unset($_SESSION['artikel_errors']); ?>
      </div>
    <?php endif; ?>

    <?php if (!empty($_SESSION['artikel_success'])): ?>
      <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded">
        <?= htmlspecialchars($_SESSION['artikel_success']); unset($_SESSION['artikel_success']); ?>
      </div>
    <?php endif; ?>

    <form action="artikel_simpan.php" method="POST" enctype="multipart/form-data" class="space-y-4">
      <div>
        <label class="block font-medium">Judul</label>
        <input type="text" id="judul" name="judul" onkeyup="updatePreview()" class="w-full border p-2 rounded" required>
      </div>

      <input type="hidden" id="slug" name="slug">

      <div>
        <label class="block font-medium">Link Akses</label>
        <input type="url" name="link_manual" class="w-full border p-2 rounded" placeholder="https://contoh.com/berita">
      </div>

      <div>
        <label class="block font-medium">Isi Berita dan Artikel</label>
        <textarea name="isi" class="w-full border p-2 rounded h-48" required></textarea>
      </div>

      <div>
        <label class="block font-medium">Upload Gambar</label>
        <input type="file" name="gambar" accept="image/*" class="mt-1">
      </div>


      <div class="flex items-center gap-3">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Simpan</button>
        <a href="artikel_admin.php" class="px-4 py-2 bg-gray-100 rounded border">Batal</a>
      </div>
    </form>
  </div>
</main>

</body>
</html>
