<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Layanan</title>

  <!-- Font & Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

  <!-- Tailwind CDN (prototyping) -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    :root{--accent:#0077ff}
    html,body{font-family:'Poppins',ui-sans-serif,system-ui,-apple-system,"Segoe UI",Roboto,Arial}
    body{overflow-x:clip;background:linear-gradient(135deg,#eaf8ff,#ffffff)}
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
  <!-- MAIN -->
  <main class="pt-24">

    <!-- HERO (full-bleed, centered) -->
    <section class="w-screen bg-white py-20 px-6 lg:px-24">
      <div class="max-w-6xl mx-auto flex flex-col items-center text-center gap-6">
        <p class="text-lg text-gray-600 max-w-3xl">
          Mendukung program Kementerian Kelautan dan Perikanan dengan solusi AI berbasis computer vision untuk meningkatkan kualitas, keamanan, dan pemantauan produk perikanan secara nasional.
        </p>
      </div>
    </section>
    
    <section class="w-screen py-12 px-6 bg-sky-50">
  <div class="max-w-7xl mx-auto">

    <!-- TITLE -->
    <div class="text-center mb-10">
      <h2 class="text-3xl font-bold text-sky-700">
        Layanan Sertifikasi Badan Mutu KKP
      </h2>
      <p class="text-gray-600 max-w-2xl mx-auto mt-2">
        Menjaga Hasil Mutu Kelautan dan Perikanan dari Hulu Hingga Hilir
      </p>
    </div>

    <!-- GRID -->
    <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 place-items-center">

      <!-- 1 -->
      <div class="feature-card bg-white p-6 rounded-xl shadow-sm text-center w-full max-w-sm">
        <div class="w-14 h-14 rounded-full bg-gradient-to-br from-sky-600 to-cyan-400 text-white flex items-center justify-center mx-auto mb-4">
          <span class="text-2xl">1</span>
        </div>
        <h4 class="text-sky-700 font-semibold">CBIB</h4>
        <p class="text-gray-600 text-sm mt-2">(Cara Budidaya Ikan yang Baik)</p>
      </div>

      <!-- 2 -->
      <div class="feature-card bg-white p-6 rounded-xl shadow-sm text-center w-full max-w-sm">
        <div class="w-14 h-14 rounded-full bg-gradient-to-br from-sky-600 to-cyan-400 text-white flex items-center justify-center mx-auto mb-4">
          <span class="text-2xl">2</span>
        </div>
        <h4 class="text-sky-700 font-semibold">CPPIB</h4>
        <p class="text-gray-600 text-sm mt-2">(Cara Pembuatan Pakan Ikan yang Baik)</p>
      </div>

      <!-- 3 -->
      <div class="feature-card bg-white p-6 rounded-xl shadow-sm text-center w-full max-w-sm">
        <div class="w-14 h-14 rounded-full bg-gradient-to-br from-sky-600 to-cyan-400 text-white flex items-center justify-center mx-auto mb-4">
          <span class="text-2xl">3</span>
        </div>
        <h4 class="text-sky-700 font-semibold">CPIB</h4>
        <p class="text-gray-600 text-sm mt-2">(Cara Pembenihan Ikan yang Baik)</p>
      </div>

      <!-- 4 -->
      <div class="feature-card bg-white p-6 rounded-xl shadow-sm text-center w-full max-w-sm">
        <div class="w-14 h-14 rounded-full bg-gradient-to-br from-sky-600 to-cyan-400 text-white flex items-center justify-center mx-auto mb-4">
          <span class="text-2xl">4</span>
        </div>
        <h4 class="text-sky-700 font-semibold">CPOIB</h4>
        <p class="text-gray-600 text-sm mt-2">(Cara Pembuatan Obat Ikan yang Baik)</p>
      </div>

      <!-- 5 -->
      <div class="feature-card bg-white p-6 rounded-xl shadow-sm text-center w-full max-w-sm">
        <div class="w-14 h-14 rounded-full bg-gradient-to-br from-sky-600 to-cyan-400 text-white flex items-center justify-center mx-auto mb-4">
          <span class="text-2xl">5</span>
        </div>
        <h4 class="text-sky-700 font-semibold">CPIB Kapal</h4>
        <p class="text-gray-600 text-sm mt-2">(Cara Penangkapan Ikan di Atas Kapal)</p>
      </div>

      <!-- 6 -->
      <div class="feature-card bg-white p-6 rounded-xl shadow-sm text-center w-full max-w-sm">
        <div class="w-14 h-14 rounded-full bg-gradient-to-br from-sky-600 to-cyan-400 text-white flex items-center justify-center mx-auto mb-4">
          <span class="text-2xl">6</span>
        </div>
        <h4 class="text-sky-700 font-semibold">CDOIB</h4>
        <p class="text-gray-600 text-sm mt-2">(Cara Distribusi Obat Ikan yang Baik)</p>
      </div>

      <!-- 7 -->
      <div class="feature-card bg-white p-6 rounded-xl shadow-sm text-center w-full max-w-sm">
        <div class="w-14 h-14 rounded-full bg-gradient-to-br from-sky-600 to-cyan-400 text-white flex items-center justify-center mx-auto mb-4">
          <span class="text-2xl">7</span>
        </div>
        <h4 class="text-sky-700 font-semibold">SKP</h4>
        <p class="text-gray-600 text-sm mt-2">(Sertifikat Kelayakan Pengelolaan)</p>
      </div>

      <!-- 8 -->
      <div class="feature-card bg-white p-6 rounded-xl shadow-sm text-center w-full max-w-sm">
        <div class="w-14 h-14 rounded-full bg-gradient-to-br from-sky-600 to-cyan-400 text-white flex items-center justify-center mx-auto mb-4">
          <span class="text-2xl">8</span>
        </div>
        <h4 class="text-sky-700 font-semibold">HACCP</h4>
        <p class="text-gray-600 text-sm mt-2">(Sertifikat Penerapan Program Manajemen Mutu Terpadu)</p>
      </div>

      <!-- 9 -->
      <div class="feature-card bg-white p-6 rounded-xl shadow-sm text-center w-full max-w-sm">
        <div class="w-14 h-14 rounded-full bg-gradient-to-br from-sky-600 to-cyan-400 text-white flex items-center justify-center mx-auto mb-4">
          <span class="text-2xl">9</span>
        </div>
        <h4 class="text-sky-700 font-semibold">SPDI</h4>
        <p class="text-gray-600 text-sm mt-2">(Sertifikat Penerapan Distribusi Ikan)</p>
      </div>

    </div>
  </div>
</section>

    <!-- FEATURES -->
    <section class="w-screen py-12 px-6">
      <div class="max-w-7xl mx-auto">
        <div class="text-center mb-8">
          <h2 class="text-3xl font-bold text-sky-700">Fitur Teknologi</h2>
          <p class="text-gray-600 max-w-2xl mx-auto mt-2">Kemampuan canggih yang tersedia dalam platform Deteksi Kesegaran ikan</p>
        </div>

        <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
          <div class="feature-card bg-white p-6 rounded-xl shadow-sm text-center">
            <div class="feature-icon w-14 h-14 rounded-full bg-gradient-to-br from-sky-600 to-cyan-400 text-white flex items-center justify-center mx-auto mb-4">
              <i class="fas fa-camera"></i>
            </div>
            <h4 class="text-sky-700 font-semibold">Deteksi Real-time</h4>
            <p class="text-gray-600 text-sm mt-2">Analisis kesegaran ikan secara real-time dengan akurasi 99.2%.</p>
          </div>

          <div class="feature-card bg-white p-6 rounded-xl shadow-sm text-center">
            <div class="feature-icon w-14 h-14 rounded-full bg-gradient-to-br from-sky-600 to-cyan-400 text-white flex items-center justify-center mx-auto mb-4">
              <i class="fas fa-database"></i>
            </div>
            <h4 class="text-sky-700 font-semibold">Big Data Analytics</h4>
            <p class="text-gray-600 text-sm mt-2">Processing data besar untuk analisis trend dan prediksi stok.</p>
          </div>

          <div class="feature-card bg-white p-6 rounded-xl shadow-sm text-center">
            <div class="feature-icon w-14 h-14 rounded-full bg-gradient-to-br from-sky-600 to-cyan-400 text-white flex items-center justify-center mx-auto mb-4">
              <i class="fas fa-mobile-alt"></i>
            </div>
            <h4 class="text-sky-700 font-semibold">Mobile Integration</h4>
            <p class="text-gray-600 text-sm mt-2">Akses lewat mobile dengan keamanan tingkat tinggi.</p>
          </div>
        </div>
      </div>
    </section>

    

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