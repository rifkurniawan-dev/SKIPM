<?php
// =====================================
// BERITA.PHP — LIST BERITA & ARTIKEL
// =====================================

require_once 'koneksi.php';

// Ambil semua artikel yang dipublish
$sql = "
    SELECT id, judul, slug, isi, gambar, link_manual, created_at
    FROM artikel
    WHERE is_published = 1
    ORDER BY created_at DESC
";
$res = $conn->query($sql);
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Berita & Artikel</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-sky-50 to-white text-gray-800">

<header class="fixed inset-x-0 top-0 z-50 bg-white/90 backdrop-blur-md shadow">
  <div class="max-w-7xl mx-auto px-4 py-3 flex items-center">

    <!-- Logo -->
    <a href="beranda.php" class="flex items-center gap-2">
      <img src="merak.png" class="w-24 md:w-28 h-auto" alt="Logo">
    </a>

    <!-- Desktop Nav (KIRI) -->
    <nav class="hidden md:flex ml-8 gap-6 text-sm font-semibold text-sky-600">
      <a href="beranda.php" class="text-sky-700 hover:underline">Beranda</a>
      <a href="tentang.php" class="hover:underline">Tentang Kami</a>
      <a href="layanan.php" class="hover:underline">Layanan</a>
      <a href="saran.php" class="hover:underline">Saran & Masukan</a>
    </nav>

    <!-- SPACER -->
    <div class="flex-1"></div>

    <!-- Mobile Button -->
    <button id="menuBtn" class="md:hidden ml-4 text-sky-700 text-2xl">
      <i class="fas fa-bars"></i>
    </button>

  </div>

  <!-- Mobile Menu -->
  <div id="mobileMenu"
       class="hidden md:hidden bg-white border-t shadow-lg px-6 py-4 space-y-4">
    <a href="beranda.php" class="block font-semibold text-sky-700">Beranda</a>
    <a href="tentang.php" class="block">Tentang Kami</a>
    <a href="layanan.php" class="block">Layanan</a>
    <a href="saran.php" class="block">Saran & Masukan</a>
  </div>
</header>

<!-- ================= MAIN ================= -->
<main class="pt-28 pb-16 max-w-7xl mx-auto px-6">

    <div class="mb-10 text-center">
        <h1 class="text-3xl font-bold text-sky-700">Berita & Artikel</h1>
        <p class="text-gray-600 mt-2">
            Kumpulan Berita & Artikel terkini 
        </p>
    </div>

    <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">

<?php if ($res && $res->num_rows > 0): ?>
<?php while ($row = $res->fetch_assoc()): ?>

<?php
    // Excerpt 30 kata
    $excerpt = strip_tags($row['isi']);
    $words   = preg_split('/\s+/', $excerpt);
    $excerpt = implode(' ', array_slice($words, 0, 30));
    if (count($words) > 30) {
        $excerpt .= '...';
    }

    // Gambar
    $img = 'default-berita.jpg';
    if (!empty($row['gambar']) && file_exists(__DIR__ . '/uploads/' . $row['gambar'])) {
        $img = 'uploads/' . $row['gambar'];
    }

    // Link
    $link = !empty($row['link_manual'])
        ? $row['link_manual']
        : 'berita_detail.php?slug=' . urlencode($row['slug']);
?>

        <article class="bg-white rounded-xl shadow-sm overflow-hidden flex flex-col">
            <img
                src="<?= htmlspecialchars($img) ?>"
                alt="<?= htmlspecialchars($row['judul']) ?>"
                class="w-full h-44 object-cover"
            >

            <div class="p-6 flex-1 flex flex-col">
                <h3 class="font-semibold mb-2 text-sky-700 text-center line-clamp-2">
                    <?= htmlspecialchars($row['judul']) ?>
                </h3>

                <time class="text-xs text-gray-400 mb-2">
                    <?= date('d M Y', strtotime($row['created_at'])) ?>
                </time>

                <p class="text-sm text-gray-600 flex-1 text-justify">
                    <?= htmlspecialchars($excerpt) ?>
                </p>

                <a
                    href="<?= htmlspecialchars($link) ?>"
                    target="<?= (strpos($link, 'http') === 0) ? '_blank' : '_self' ?>"
                    class="mt-4 inline-flex items-center gap-2 text-sm font-semibold
                           text-white bg-gradient-to-r from-sky-600 to-cyan-400
                           px-4 py-2 rounded-md"
                >
                    Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </article>

<?php endwhile; ?>
<?php else: ?>

        <div class="col-span-3 text-center text-gray-500">
            Belum ada artikel.
        </div>

<?php endif; ?>

    </div>
</main>

<!-- FOOTER (Tailwind) -->
<footer class="w-screen bg-white/90 mt-12 mb-12">
  <div class="max-w-7xl mx-auto px-6 py-10">

    <div class="grid grid-cols-1 md:grid-cols-4 gap-8 items-start text-center md:text-left">

  <!-- Brand -->
  <div class="footer-section">
    <h3 class="text-sky-700 font-bold text-lg">SKIPM Merak</h3>

    <div class="flex justify-center md:justify-start gap-3 mt-4">
      <a href="https://www.facebook.com/badanmutukkpmerak" class="text-sky-600 hover:text-sky-800"><i class="fab fa-facebook-f"></i></a>
      <a href="https://x.com/bppmhkp" class="text-sky-600 hover:text-sky-800"><i class="fab fa-twitter"></i></a>
      <a href="https://www.instagram.com/bppmhkp.merak?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==" class="text-sky-600 hover:text-sky-800"><i class="fab fa-instagram"></i></a>
      <a href="https://www.youtube.com/@bppmhkp_merak" class="text-sky-600 hover:text-sky-800"><i class="fab fa-youtube"></i></a>
      <a href="https://www.tiktok.com/@bppmhkp.merak" class="text-sky-600 hover:text-sky-800"><i class="fab fa-tiktok"></i></a>
    </div>
  </div>

  <!-- Alamat -->
  <div class="footer-section">
    <h3 class="text-sky-700 font-bold text-lg">Alamat</h3>

    <p class="text-gray-600 mt-3 text-sm">
      Jalan Raya Tol Merak Km.01<br>
      Pelabuhan Penyeberangan Merak,<br>
      Gerem, Kec. Gerogol,<br>
      Kota Cilegon, Banten 42438
    </p>
  </div>

  <!-- Lokasi (Map) — diperlebar & diposisikan lebih ke tengah -->
  <div class="footer-section md:col-span-2 md:pl-6">
    <h3 class="text-sky-700 font-bold text-lg mb-3">Lokasi Kami</h3>

    <div class="w-full h-56 rounded-xl overflow-hidden shadow">
      <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.616701987579!2d105.994096!3d-6.186607!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e418d2765955691%3A0xe2783e47a032e0cd!2sStasiun%20Karantina%20Ikan%20Pengendalian%20Mutu%20dan%20Keamanan%20Hasil%20Perikanan%20Kelas%20I%20Merak!5e0!3m2!1sen!2sid!4v1700000000000"
        width="100%" height="100%" allowfullscreen="" loading="lazy">
      </iframe>
    </div>
  </div>

</div>


    <!-- Copyright -->
    <div class="border-t border-gray-100 mt-8 pt-6 text-center">
      <p class="text-gray-500 text-sm">&copy;Copyright 2025 Stasiun Karantina Ikan Merak.</p>
    </div>

  </div>
</footer>

<script>
  const menuBtn = document.getElementById('menuBtn');
  const mobileMenu = document.getElementById('mobileMenu');
  
  menuBtn.addEventListener('click', () => {
    mobileMenu.classList.toggle('hidden');
  });


</script>


</body>
</html>
