<?php
session_start();
include "koneksi.php";

// timezone Indonesia
date_default_timezone_set("Asia/Jakarta");

// Cek login admin
if (!isset($_SESSION['id_admin'])) {
    header("Location: login_admin.php");
    exit;
}

// Ambil data admin (fallback)
$admin = ['username' => 'Admin', 'email' => 'admin@example.com'];
$id_admin = $_SESSION['id_admin'] ?? null;

if ($id_admin) {
    $stmt = $conn->prepare("SELECT username, email FROM admins WHERE id = ? LIMIT 1");
    if ($stmt) {
        $stmt->bind_param("i", $id_admin);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res && $res->num_rows === 1) {
            $admin = $res->fetch_assoc();
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Artikel</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">

    <style>
        main { padding-left: 16rem; }
        .float-add {
            position: fixed;
            right: 2rem;
            bottom: 2rem;
            z-index: 60;
        }
    </style>
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

<!-- ================= MAIN CONTENT ================= -->
<main class="pt-24 pb-12">
    <div class="max-w-7xl mx-auto mt-6">
        
        <div class="bg-white rounded-lg shadow p-4">
            <h1 class="text-2xl font-bold mb-6">Daftar Berita dan Artikel</h1>

            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gray-50 text-center">
                        <th class="px-4 py-3 text-sm font-semibold">NO</th>
                        <th class="px-4 py-3 text-sm font-semibold">JUDUL BERITA DAN ARTIKEL</th>
                        <th class="px-4 py-3 text-sm font-semibold">GAMBAR</th>
                        <th class="px-4 py-3 text-sm font-semibold">TANGGAL</th>
                        <th class="px-4 py-3 text-sm font-semibold">STATUS</th>
                        <th class="px-4 py-3 text-sm font-semibold">AKSI</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    <?php
                    $q_all = "SELECT * FROM artikel ORDER BY created_at DESC";
                    $res_all = $conn->query($q_all);
                    $no = 1;

                    if ($res_all && $res_all->num_rows > 0) {
                        while ($row = $res_all->fetch_assoc()) {

                            $img = (!empty($row['gambar']) && file_exists(__DIR__ . '/uploads/' . $row['gambar']))
                                ? 'uploads/' . $row['gambar']
                                : 'default-berita.jpg';
                    ?>
                    <tr>
                        <td class="px-4 py-3 text-center"><?= $no++ ?></td>

                        <td class="px-4 py-3"><?= htmlspecialchars($row['judul']) ?></td>

                        <td class="px-4 py-3 text-center">
                            <img src="<?= htmlspecialchars($img) ?>" class="w-24 h-14 object-cover rounded" alt="gambar berita">
                        </td>

                        <td class="px-4 py-3 text-center text-gray-600 text-sm">
                            <?= htmlspecialchars($row['created_at']) ?>
                        </td>

                        <td class="px-4 py-3 text-center">
                            <?= $row['is_published']
                                ? '<span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">Published</span>'
                                : '<span class="text-xs bg-gray-100 text-gray-800 px-2 py-1 rounded">Draft</span>' ?>
                        </td>

                        <td class="px-4 py-3 text-center">
                            <div class="flex justify-center items-center gap-2">
                                <a href="artikel_edit.php?id=<?= urlencode($row['id']) ?>"
                                   class="px-3 py-1 bg-yellow-500 text-white rounded">
                                    Edit
                                </a>

                                <form action="artikel_hapus.php" method="POST" 
                                      onsubmit="return confirm('Yakin ingin menghapus artikel ini?');">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">
                                    <button class="px-3 py-1 bg-red-500 text-white rounded">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php
                        }
                    } else {
                        echo '<tr><td colspan="6" class="text-center py-6 text-gray-600">Belum ada artikel.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>

        </div>
    </div>
</main>

<!-- Tombol Tambah Artikel -->
<a href="artikel_tambah.php" class="float-add" title="Tambah artikel">
    <button class="w-14 h-14 rounded-full bg-blue-600 text-white shadow hover:bg-blue-700">+</button>
</a>

</body>
</html>
