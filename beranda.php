<?php 
session_start();
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

// koneksi database
include "koneksi.php"; // pastikan koneksi.php membuat $conn (mysqli)

?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Beranda - Deteksi AI</title>

  <!-- Font & Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- SweetAlert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    :root { --accent: #0077ff; }
    html, body { font-family: 'Poppins'; }
    body { overflow-x: clip; }
  </style>
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

    <!-- Desktop Logout (KANAN) -->
    <button id="logoutBtn"
      class="hidden md:inline-flex items-center gap-2 bg-green-500 hover:bg-green-600
             text-white text-sm font-semibold px-3 py-2 rounded-md shadow-sm">
      <i class="fas fa-sign-out-alt"></i> Logout
    </button>

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

    <button onclick="logoutConfirm()"
      class="w-full mt-3 bg-green-500 text-white py-2 rounded-md font-semibold">
      Logout
    </button>
  </div>
</header>

<!-- MAIN CONTENT -->
<main class="pt-24">

<!-- HERO -->
<section class="w-screen bg-cover bg-center bg-no-repeat relative py-20 px-6 lg:px-24" 
  style="background-image: url('nelayan.jpg');">
  <div class="absolute inset-0 bg-black/40"></div>

  <div class="relative flex justify-center text-center">
    <div class="space-y-6 max-w-2xl text-white">
      <h1 class="text-3xl lg:text-4xl font-extrabold leading-tight">
        Deteksi Kesegaran Ikan menggunakan
        <span class="bg-clip-text text-transparent bg-gradient-to-r from-orange-400 to-yellow-300">
          Kecerdasan Buatan
        </span>
      </h1>

      <p class="text-lg text-gray-200">
        Platform AI pertama di Indonesia yang menganalisis kesegaran ikan dengan akurasi hingga <strong>99.2%</strong>.
      </p>

      <a href="dashboard.php" class="inline-flex items-center gap-2 bg-gradient-to-r from-sky-600 to-cyan-400 text-white px-5 py-3 rounded-lg font-semibold shadow-lg">
        <i class="fas fa-play-circle"></i> Mulai Deteksi Sekarang
      </a>

      <div class="flex flex-wrap justify-center gap-6 mt-3">
        <div>
          <div class="text-2xl font-extrabold">500+</div>
          <div class="text-sm text-gray-200">Pengguna Aktif</div>
        </div>
        <div>
          <div class="text-2xl font-extrabold">99.2%</div>
          <div class="text-sm text-gray-200">Tingkat Akurasi</div>
        </div>
        <div>
          <div class="text-2xl font-extrabold">24/7</div>
          <div class="text-sm text-gray-200">Monitoring</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- FEATURES -->
<section class="w-screen py-12 px-6">
  <div class="max-w-7xl mx-auto">
    <div class="mb-10 text-center">
      <h2 class="text-3xl font-bold text-sky-700">Keunggulan Platform Kami</h2>
    </div>

    <div class="grid gap-8 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
      <article class="bg-white p-6 rounded-xl shadow-sm text-center">
        <div class="text-sky-600 text-3xl mb-3"><i class="fas fa-bolt"></i></div>
        <h3 class="font-semibold text-lg">Deteksi Real-time</h3>
        <p class="text-gray-500 text-sm mt-2">Hasil analisis dalam hitungan detik.</p>
      </article>

      <article class="bg-white p-6 rounded-xl shadow-sm text-center">
        <div class="text-sky-600 text-3xl mb-3"><i class="fas fa-chart-line"></i></div>
        <h3 class="font-semibold text-lg">Akurasi Tinggi</h3>
        <p class="text-gray-500 text-sm mt-2">Akurasi hingga 99.2%.</p>
      </article>

      <article class="bg-white p-6 rounded-xl shadow-sm text-center">
        <div class="text-sky-600 text-3xl mb-3"><i class="fas fa-mobile-alt"></i></div>
        <h3 class="font-semibold text-lg">Akses Mobile</h3>
        <p class="text-gray-500 text-sm mt-2">UI responsif dan cepat.</p>
      </article>

      <article class="bg-white p-6 rounded-xl shadow-sm text-center">
        <div class="text-sky-600 text-3xl mb-3"><i class="fas fa-database"></i></div>
        <h3 class="font-semibold text-lg">Data Analytics</h3>
        <p class="text-gray-500 text-sm mt-2">Insight kualitas hasil tangkapan.</p>
      </article>

      <article class="bg-white p-6 rounded-xl shadow-sm text-center">
        <div class="text-sky-600 text-3xl mb-3"><i class="fas fa-cloud-upload-alt"></i></div>
        <h3 class="font-semibold text-lg">Cloud Storage</h3>
        <p class="text-gray-500 text-sm mt-2">Backup otomatis terenkripsi.</p>
      </article>

      <article class="bg-white p-6 rounded-xl shadow-sm text-center">
        <div class="text-sky-600 text-3xl mb-3"><i class="fas fa-users"></i></div>
        <h3 class="font-semibold text-lg">Multi-user</h3>
        <p class="text-gray-500 text-sm mt-2">Manajemen akses untuk tim.</p>
      </article>
    </div>
  </div>
</section>

<!-- HOW IT WORKS -->
<section class="w-screen py-10 px-6">
  <div class="max-w-7xl mx-auto">
    <div class="text-center mb-8">
      <h2 class="text-2xl font-bold text-sky-700">Cara Kerja Platform</h2>
      <p class="text-gray-600">3 langkah sederhana</p>
    </div>

    <div class="relative max-w-5xl mx-auto">
      <div class="hidden lg:block absolute left-1/2 top-8 bottom-8 w-1 bg-gradient-to-b from-sky-100 to-sky-200 -translate-x-1/2 rounded"></div>

      <div class="space-y-8 lg:grid lg:grid-cols-3 lg:gap-x-8 text-center">

        <article class="bg-white p-6 rounded-xl shadow-sm lg:relative">
          <div class="w-12 h-12 bg-gradient-to-br from-sky-600 to-cyan-400 text-white flex items-center justify-center rounded-full absolute -top-6 left-6">1</div>
          <img src="ikan.jpg" class="w-20 h-20 object-cover rounded-md mb-3 mx-auto"/>
          <h3 class="font-semibold">Ambil / Unggah Foto</h3>
          <p class="text-sm text-gray-500 mt-2">Gunakan pencahayaan baik.</p>
        </article>

        <article class="bg-white p-6 rounded-xl shadow-sm lg:relative">
          <div class="w-12 h-12 bg-gradient-to-br from-sky-600 to-cyan-400 text-white flex items-center justify-center rounded-full absolute -top-6 left-6">2</div>
          <img src="analisis.jpg" class="w-20 h-20 object-cover rounded-md mb-3 mx-auto"/>
          <h3 class="font-semibold">Analisis AI</h3>
          <p class="text-sm text-gray-500 mt-2">Model membaca warna, tekstur & ciri visual.</p>
        </article>

        <article class="bg-white p-6 rounded-xl shadow-sm lg:relative">
          <div class="w-12 h-12 bg-gradient-to-br from-sky-600 to-cyan-400 text-white flex items-center justify-center rounded-full absolute -top-6 left-6">3</div>
          <img src="hasil.jpg" class="w-20 h-20 object-cover rounded-md mb-3 mx-auto"/>
          <h3 class="font-semibold">Hasil & Rekomendasi</h3>
          <p class="text-sm text-gray-500 mt-2">Menampilkan skor & rekomendasi.</p>
        </article>

      </div>
    </div>
  </div>
</section>

<!-- BERITA (DINAMIS: ambil dari tabel `artikel`) -->
<section id="berita-artikel" class="w-screen py-12 px-6 bg-sky-50">
  <div class="max-w-7xl mx-auto">
    <div class="mb-8 text-center">
      <h2 class="text-3xl font-bold text-sky-700">Berita & Artikel</h2>
    </div>

    <div class="grid gap-8 grid-cols-1 md:grid-cols-3">

<?php
// query artikel terbaru (ubah LIMIT sesuai kebutuhan)
$sql = "SELECT id, judul, slug, isi, gambar, link_manual, created_at FROM artikel WHERE is_published = 1 ORDER BY created_at DESC LIMIT 9";
$res = $conn->query($sql);

if ($res && $res->num_rows > 0) {
    while ($row = $res->fetch_assoc()) {
        // buat excerpt singkat (30 kata)
        $excerpt = strip_tags($row['isi']);
        $words = preg_split('/\s+/', $excerpt);
        $excerpt = implode(' ', array_slice($words, 0, 30));
        if (count($words) > 30) $excerpt .= '...';

        // fallback gambar
        $img_src = 'default-berita.jpg';
        if (!empty($row['gambar']) && file_exists(__DIR__ . '/uploads/' . $row['gambar'])) {
            $img_src = 'uploads/' . $row['gambar'];
        }

        // link tujuan: pakai link_manual bila ada, else berita_detail.php?slug=...
        $link = (!empty($row['link_manual'])) ? $row['link_manual'] : ("berita_detail.php?slug=" . urlencode($row['slug']));
        ?>
        <article class="bg-white rounded-xl shadow-sm overflow-hidden flex flex-col">
          <img src="<?= htmlspecialchars($img_src) ?>" class="w-full h-44 object-cover"/>
          <div class="p-6 flex-1 flex flex-col">
           <h3 class="font-semibold mb-2 text-sky-700 text-center line-clamp-2"><?= htmlspecialchars($row['judul']) ?></h3>
            <p class="text-sm text-gray-600 flex-1 text-justify"><?= htmlspecialchars($excerpt) ?></p>
            <a href="<?= htmlspecialchars($link) ?>" 
               target="<?= (strpos($link, 'http') === 0) ? '_blank' : '_self' ?>" 
               class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-white bg-gradient-to-r from-sky-600 to-cyan-400 px-4 py-2 rounded-md">
              Baca Selengkapnya
              <i class="fas fa-arrow-right"></i>
            </a>
          </div>
        </article>
        <?php
    }
} else {
    // bila kosong, tampilkan placeholder atau pesan
    ?>
    <div class="col-span-3 text-center text-gray-600">
      Belum ada artikel.
    </div>
    <?php
}
?>

    </div>

    <!-- Button Lihat Semua -->
    <div class="mt-10 text-center">
      <a href="berita.php"
         class="inline-flex items-center gap-2 text-sm font-semibold text-sky-700 hover:underline">
        Lihat Semua Berita
        <i class="fas fa-arrow-right"></i>
      </a>
    </div>

  </div>
</section>

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
  document.getElementById('logoutBtn').addEventListener('click', logoutConfirm);

  menuBtn.addEventListener('click', () => {
    mobileMenu.classList.toggle('hidden');
  });

  function logoutConfirm() {
    Swal.fire({
      title: "Yakin ingin logout?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Ya, logout"
    }).then(res => {
      if (res.isConfirmed) {
        window.location.href = "login.php";
      }
    });
  }
</script>


</body>
</html>
