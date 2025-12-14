<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Tentang Kami - Deteksi AI</title>

  <!-- Font & Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

  <!-- Tailwind Play CDN (prototyping) -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    :root { --accent: #0077ff; }
    html,body { font-family: 'Poppins', ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; }
    body { overflow-x: clip; background: linear-gradient(135deg,#eaf8ff,#ffffff); }
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
          Stasiun Karantina Ikan Merak merupakan instansi pemerintah yang berperan penting dalam menjaga mutu dan keamanan hasil perikanan. Dengan komitmen menghadirkan layanan modern dan responsif, SKIPM Merak kini memanfaatkan Platform AI terdepan yang mampu mendeteksi tingkat kesegaran ikan secara cepat dan akurat melalui teknologi computer vision.
Inovasi ini tidak hanya membantu meningkatkan kualitas pengawasan, tetapi juga mendukung nelayan, pengepul, dan pelaku industri perikanan dalam memastikan produk yang dihasilkan tetap segar, aman, dan siap bersaing di pasar nasional maupun internasional.
        </p>
      </div>
    </section>

  

    <!-- MISSION & VISION -->
    <section class="w-screen py-12 px-6">
      <div class="max-w-6xl mx-auto grid gap-8 lg:grid-cols-2">
        <article class="mission-card bg-white p-8 rounded-2xl shadow-lg border-t-4 border-sky-600 text-center">
          <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-br from-sky-600 to-cyan-400 text-white text-2xl mx-auto mb-4">
            <i class="fas fa-bullseye"></i>
          </div>
          <h3 class="text-xl font-bold text-sky-700 mb-3">Misi</h3>
          <p class="text-sm text-gray-600 flex-1 text-justify text-justify-inter-word" style="text-align: justify;">Meningkatkan daya saing hasil kelautan dan perikanan melalui inspeksi, sertifikasi, surveilans, pengambilan contoh uji, pengujian dan monitoring.
Meningkatkan penerapan praktik yang baik di setiap rantai pasok dan kepatuhan terhadap pemenuhan standar mutu hasil kelautan dan perikanan.
Mewujudkan sistem jaminan mutu dan keamanan hasil kelautan dan perikanan yang efektif dan selaras dengan standar internasional.
Meningkatkan tata kelola pemerintahan yang bersih, efektif, dan terpercaya.</p>
        </article>

        <article class="vision-card bg-white p-8 rounded-2xl shadow-lg border-t-4 border-orange-500 text-center">
          <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-gradient-to-br from-orange-500 to-orange-300 text-white text-2xl mx-auto mb-4">
            <i class="fas fa-eye"></i>
          </div>
          <h3 class="text-xl font-bold text-orange-500 mb-3">Visi</h3>
          <p class="text-sm text-gray-600 flex-1 text-justify text-justify-inter-word" style="text-align: justify;">Terselenggaranya pengendalian dan pengawasan mutu yang terdepan untuk memastikan keamanan, kualitas, keberlanjutan dan daya saing hasil kelautan dan perikanan, dalam rangka mewujudkan masyarakat kelautan dan perikanan yang sejahtera dan sumber daya kelautan dan perikanan yang berkelanjutan untuk Indonesia maju yang berdaulat, mandiri, berkepribadian, berlandaskan gotong royong.</p>
        </article>
      </div>
    </section>

    <!-- VALUES -->
    <section class="w-screen py-12 px-6">
      <div class="max-w-7xl mx-auto text-center mb-8">
        <h2 class="text-3xl font-bold text-sky-700">Nilai-Nilai Kami</h2>
        <p class="text-gray-600 max-w-2xl mx-auto mt-2">Prinsip yang menjadi panduan dalam pengembangan produk dan layanan kami.</p>
      </div>

      <div class="max-w-7xl mx-auto grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
        <div class="value-card bg-white p-6 rounded-xl shadow-sm text-center">
          <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-sky-600 to-cyan-400 text-white text-xl mx-auto mb-4">
            <i class="fas fa-lightbulb"></i>
          </div>
          <h4 class="font-semibold text-sky-700 mb-2">Inovasi</h4>
          <p class="text-gray-600 text-sm">Terus mengembangkan teknologi AI relevan untuk industri perikanan.</p>
        </div>

        <div class="value-card bg-white p-6 rounded-xl shadow-sm text-center">
          <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-sky-600 to-cyan-400 text-white text-xl mx-auto mb-4">
            <i class="fas fa-shield-alt"></i>
          </div>
          <h4 class="font-semibold text-sky-700 mb-2">Keandalan</h4>
          <p class="text-gray-600 text-sm">Menjamin keakuratan dan stabilitas sistem deteksi.</p>
        </div>

        <div class="value-card bg-white p-6 rounded-xl shadow-sm text-center">
          <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-sky-600 to-cyan-400 text-white text-xl mx-auto mb-4">
            <i class="fas fa-handshake"></i>
          </div>
          <h4 class="font-semibold text-sky-700 mb-2">Kolaborasi</h4>
          <p class="text-gray-600 text-sm">Berkolaborasi untuk membangun ekosistem perikanan berkelanjutan.</p>
        </div>

        <div class="value-card bg-white p-6 rounded-xl shadow-sm text-center">
          <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gradient-to-br from-sky-600 to-cyan-400 text-white text-xl mx-auto mb-4">
            <i class="fas fa-leaf"></i>
          </div>
          <h4 class="font-semibold text-sky-700 mb-2">Keberlanjutan</h4>
          <p class="text-gray-600 text-sm">Komitmen terhadap praktik yang mendukung pelestarian lingkungan laut.</p>
        </div>
      </div>
    </section>

    <!-- TEAM -->
   <section class="w-screen py-12 px-6">
  <div class="max-w-7xl mx-auto text-center mb-8">
    <h2 class="text-3xl font-bold text-sky-700">Pembimbing & Tim Kami</h2>
  </div>

  <!-- gunakan flex + wrap + justify-center agar posisi selalu tengah -->
  <div class="max-w-7xl mx-auto flex flex-wrap justify-center gap-6">
    
    <!-- team card -->
    <div class="team-card bg-white p-6 rounded-xl shadow-sm text-center w-64">
      <div class="team-avatar w-28 h-28 rounded-full bg-gradient-to-br from-sky-600 to-cyan-400 text-white flex items-center justify-center mx-auto text-3xl mb-4">
        <i class="fas fa-user"></i>
      </div>
      <h3 class="text-lg font-semibold text-sky-700">Muklasin, S.St.Pi</h3>
      <div class="team-role text-orange-500 font-semibold mt-1">Pembimbing Magang</div>
    </div>

     <div class="team-card bg-white p-6 rounded-xl shadow-sm text-center w-64">
      <div class="team-avatar w-28 h-28 rounded-full bg-gradient-to-br from-sky-600 to-cyan-400 text-white flex items-center justify-center mx-auto text-3xl mb-4">
        <i class="fas fa-user"></i>
      </div>
      <h3 class="text-lg font-semibold text-sky-700">Mustika Wati, S.Pi</h3>
      <div class="team-role text-orange-500 font-semibold mt-1">Pembimbing Magang</div>
    </div>

    <div class="team-card bg-white p-6 rounded-xl shadow-sm text-center w-64">
      <div class="team-avatar w-28 h-28 rounded-full bg-gradient-to-br from-sky-600 to-cyan-400 text-white flex items-center justify-center mx-auto text-3xl mb-4">
        <i class="fas fa-user"></i>
      </div>
      <h3 class="text-lg font-semibold text-sky-700">Muhamad Mahathir Ashari</h3>
      <div class="team-role text-orange-500 font-semibold mt-1">Mahasiswa Sistem Informasi Kelautan</div>
    </div>

    <div class="team-card bg-white p-6 rounded-xl shadow-sm text-center w-64">
      <div class="team-avatar w-28 h-28 rounded-full overflow-hidden mx-auto mb-4">
    <img src="foto arif.png" alt="foto arif" class="w-full h-full object-cover">
      </div>
      <h3 class="text-lg font-semibold text-sky-700">Arif Kurniawan</h3>
      <div class="team-role text-orange-500 font-semibold mt-1">Mahasiswa Sistem Informasi Kelautan</div>
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
