<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Saran & Masukan - SKIPM Merak</title>

  <!-- Fonts & Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- SweetAlert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    html,body { font-family: 'Poppins', system-ui, sans-serif; }
    body { background: linear-gradient(135deg,#eaf8ff,#ffffff); }
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

<main class="pt-24">

<!-- ================= HERO ================= -->
<section class="py-20 text-center">
  <h2 class="text-3xl font-bold text-sky-700">Saran & Masukan</h2>
  <p class="text-gray-600 mt-3 max-w-2xl mx-auto">
    Pendapat Anda membantu peningkatan layanan mutu kelautan dan perikanan.
  </p>
</section>

<div class="max-w-7xl mx-auto px-6">

<!-- ================= SUCCESS ================= -->
<div id="successMessage" class="hidden bg-green-100 border border-green-200 text-green-800 p-4 rounded mb-6">
  <i class="fas fa-check-circle"></i> Saran berhasil dikirim
</div>

<!-- ================= FORM ================= -->
<section class="bg-white rounded-2xl shadow-lg p-8 mb-12">
<h3 class="text-xl font-bold text-sky-700 mb-6 text-center">Form Saran & Saran</h3>

<form id="saranForm" class="space-y-5">

<div class="grid md:grid-cols-2 gap-4">
  <input id="nama" placeholder="Nama Lengkap*" class="border p-3 rounded">
  <input id="email" type="email" placeholder="Email*" class="border p-3 rounded">
</div>

<select id="kategori" class="border p-3 rounded w-full">
  <option value="">Pilih Kategori*</option>
  <option value="saran">Saran</option>
  <option value="masukan">Masukan</option>
  <option value="laporan">Laporan</option>
  <option value="pujian">Pujian</option>
</select>

<input id="judul" placeholder="Judul*" class="border p-3 rounded w-full">

<textarea id="deskripsi" placeholder="Deskripsi Lengkap*" class="border p-3 rounded w-full min-h-[120px]"></textarea>

<!-- Rating -->
<div>
  <p class="font-semibold mb-2">Rating Kepuasan*</p>
  <div class="flex gap-2" id="ratingStars">
    <button type="button" class="star" data-rating="1"><i class="far fa-star text-xl"></i></button>
    <button type="button" class="star" data-rating="2"><i class="far fa-star text-xl"></i></button>
    <button type="button" class="star" data-rating="3"><i class="far fa-star text-xl"></i></button>
    <button type="button" class="star" data-rating="4"><i class="far fa-star text-xl"></i></button>
    <button type="button" class="star" data-rating="5"><i class="far fa-star text-xl"></i></button>
  </div>
  <input type="hidden" id="rating">
</div>

<label class="flex gap-2">
  <input type="checkbox" id="anonim"> Kirim sebagai anonim
</label>

<div class="flex justify-end gap-3">
  <button type="reset" id="resetBtn" class="border px-5 py-2 rounded">Reset</button>
  <button type="submit" class="bg-sky-600 text-white px-5 py-2 rounded">Kirim</button>
</div>

</form>
</section>

<!-- ================= LIST ================= -->
<section class="mb-16">
<h3 class="text-xl font-bold text-sky-700 mb-4 text-center">Saran Masuk</h3>

<div class="flex gap-2 justify-center mb-4">
  <button class="filter-btn bg-sky-600 text-white px-3 py-1 rounded" data-filter="all">Semua</button>
  <button class="filter-btn px-3 py-1 rounded border" data-filter="saran">Saran</button>
  <button class="filter-btn px-3 py-1 rounded border" data-filter="masukan">Masukan</button>
  <button class="filter-btn px-3 py-1 rounded border" data-filter="laporan">Laporan</button>
</div>

<div id="suggestionsList" class="space-y-4"></div>
</section>

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
/* ================= ROLE ================= */
// ganti manual untuk simulasi:
// localStorage.setItem('role','admin');
// localStorage.setItem('role','publik');

const ROLE = localStorage.getItem('role') || 'publik';

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
/* ================= RATING ================= */
const stars=document.querySelectorAll('.star');
const ratingInput=document.getElementById('rating');

stars.forEach(star=>{
  star.onclick=()=>{
    const v=star.dataset.rating;
    ratingInput.value=v;
    stars.forEach(s=>{
      s.firstChild.className=
        s.dataset.rating<=v
        ?'fas fa-star text-yellow-400 text-xl'
        :'far fa-star text-xl';
    });
  };
});

/* ================= RENDER ================= */
function render(filter='all'){
  const box=document.getElementById('suggestionsList');
  box.innerHTML='';

  const data=JSON.parse(localStorage.getItem('saran')||'[]')
    .filter(d=>filter==='all'||d.kategori===filter);

  if(!data.length){
    box.innerHTML='<p class="text-center text-gray-400 italic">Belum ada data</p>';
    return;
  }

  data.forEach((d,i)=>{
    box.innerHTML+=`
    <div class="bg-white border rounded-xl shadow-sm p-5 space-y-4">

      <!-- HEADER -->
      <div class="flex justify-between text-sm text-gray-500">
        <span class="font-medium">${d.nama}</span>
        <span>${d.waktu}</span>
      </div>

      <!-- SARAN -->
      <div>
        <h4 class="text-lg font-semibold text-sky-700">${d.judul}</h4>
        <p class="text-gray-600">${d.deskripsi}</p>
      </div>

      <!-- RATING -->
      <div class="text-yellow-400 text-sm">
        ${'★'.repeat(d.rating)}${'☆'.repeat(5-d.rating)}
      </div>

      <!-- TANGGAPAN -->
      <div class="border-t pt-4 space-y-3">
        <h5 class="text-sm font-semibold text-gray-700">Tanggapan</h5>

        ${(d.komentar||[]).length
          ? d.komentar.map(k=>`
            <div class="p-3 rounded-lg border ${
              k.role==='admin'
              ?'bg-sky-50 border-sky-300'
              :'bg-gray-50'
            }">
              <div class="flex justify-between text-xs text-gray-500 mb-1">
                <span class="font-semibold">
                  ${k.role==='admin'
                    ?'Admin SKIPM'
                    :k.nama}
                </span>
                <span>${k.waktu}</span>
              </div>

              ${k.role==='admin'
                ?'<span class="inline-block text-xs bg-sky-600 text-white px-2 py-0.5 rounded mb-1">Tanggapan Resmi</span>'
                :''
              }

              <p class="text-gray-700 text-sm">${k.isi}</p>
            </div>
          `).join('')
          :'<p class="text-gray-400 italic text-sm">Belum ada tanggapan</p>'
        }

        <!-- FORM TANGGAPAN -->
        <div class="grid md:grid-cols-4 gap-2">
          <input id="namaK${i}"
            placeholder="${ROLE==='admin'?'Admin SKIPM':'Nama'}"
            ${ROLE==='admin'?'disabled':''}
            class="border rounded px-3 py-2 text-sm md:col-span-1">

          <input id="isiK${i}"
            placeholder="Tulis tanggapan secara profesional"
            class="border rounded px-3 py-2 text-sm md:col-span-2">

          <button onclick="kirimKomentar(${i})"
            class="bg-sky-600 hover:bg-sky-700 text-white rounded px-4 text-sm">
            Kirim
          </button>
        </div>
      </div>
    </div>`;
  });
}

/* ================= KIRIM KOMENTAR ================= */
function kirimKomentar(i){
  const isi=document.getElementById(`isiK${i}`).value;
  if(!isi.trim()) return;

  const data=JSON.parse(localStorage.getItem('saran')||'[]');
  data[i].komentar=data[i].komentar||[];

  data[i].komentar.push({
    nama: ROLE==='admin'?'Admin SKIPM':document.getElementById(`namaK${i}`).value||'Admin',
    isi,
    role: ROLE,
    waktu:new Date().toLocaleString('id-ID')
  });

  localStorage.setItem('saran',JSON.stringify(data));
  render();
}

/* ================= SUBMIT SARAN ================= */
saranForm.onsubmit=e=>{
  e.preventDefault();
  if(!rating.value) return alert("Rating wajib");

  const saran={
    nama: anonim.checked?'Anonim':nama.value,
    kategori:kategori.value,
    judul:judul.value,
    deskripsi:deskripsi.value,
    rating:rating.value,
    waktu:new Date().toLocaleString('id-ID'),
    komentar:[]
  };

  const arr=JSON.parse(localStorage.getItem('saran')||'[]');
  arr.unshift(saran);
  localStorage.setItem('saran',JSON.stringify(arr));

  saranForm.reset();
  stars.forEach(s=>s.firstChild.className='far fa-star text-xl');
  successMessage.classList.remove('hidden');
  setTimeout(()=>successMessage.classList.add('hidden'),2500);
  render();
};

/* ================= FILTER ================= */
document.querySelectorAll('.filter-btn').forEach(b=>{
  b.onclick=()=>{
    document.querySelectorAll('.filter-btn')
      .forEach(x=>x.classList.remove('bg-sky-600','text-white'));
    b.classList.add('bg-sky-600','text-white');
    render(b.dataset.filter);
  };
});

render();
</script>



</body>
</html>
