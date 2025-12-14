<?php 
// dashboard.php (Final-ready, annotated download + no-double-label)
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Dashboard — Deteksi AI SKIPM</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root{ --accent: #0077ff; }
        body { font-family: 'Poppins', ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, Arial; }
        video::-webkit-media-controls { display:none !important; }
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
<main class="pt-28 pb-16">
<div class="max-w-6xl mx-auto px-6">
    <section class="mb-8 text-center">
        <h1 class="text-3xl lg:text-4xl font-extrabold text-sky-700">Deteksi Kesegaran Ikan</h1>
        <p class="text-gray-600 mt-2 max-w-2xl mx-auto">Arahkan kamera atau upload gambar untuk estimasi kesegaran menggunakan model AI.</p>
    </section>

    <section class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        <div class="lg:col-span-2 bg-white rounded-2xl shadow p-6">
            <div class="flex flex-col lg:flex-row gap-6">
                <div class="flex-1">
                    <div class="bg-slate-50 rounded-xl overflow-hidden border border-slate-100">
                        <video id="camera" autoplay playsinline class="w-full h-64 lg:h-96 object-cover bg-black"></video>
                    </div>

                    <div class="mt-4 flex flex-wrap items-center gap-3">
                        <button id="startBtn" class="inline-flex items-center gap-2 bg-gradient-to-r from-sky-600 to-cyan-400 text-white px-4 py-2 rounded-lg shadow">
                            <i class="fas fa-video"></i> Aktifkan Kamera
                        </button>
                        <button id="captureBtn" class="inline-flex items-center gap-2 bg-white text-sky-700 border border-sky-100 px-4 py-2 rounded-lg shadow hidden">
                            <i class="fas fa-camera"></i> Ambil Gambar
                        </button>
                        <button id="stopBtn" class="inline-flex items-center gap-2 bg-red-50 text-red-700 border border-red-100 px-4 py-2 rounded-lg shadow hidden">
                            <i class="fas fa-stop"></i> Matikan Kamera
                        </button>
                        <button id="uploadBtn" class="inline-flex items-center gap-2 bg-white text-sky-700 border border-sky-100 px-4 py-2 rounded-lg shadow">
                            <i class="fas fa-upload"></i> Upload Gambar
                        </button>
                        <input type="file" id="uploadInput" accept="image/*" class="hidden">
                        <button id="downloadBtn" class="inline-flex gap-2 bg-white text-sky-700 border border-sky-100 px-4 py-2 rounded-lg shadow hidden">
                            <i class="fas fa-download"></i> Unduh Foto
                        </button>
                        <div id="cameraStatus" class="ml-auto text-sm text-gray-500"></div>
                    </div>

                    <div id="resultPanel" class="mt-6 p-4 rounded-lg hidden">
                        <div class="flex items-start gap-4">
                            <div>
                                <img id="resultImage" src="" alt="preview" class="w-44 h-36 object-cover rounded-md border" style="display:none">
                            </div>
                            <div>
                                <div id="resultLabel" class="text-lg font-bold"></div>
                                <div id="resultPercent" class="text-4xl font-extrabold text-sky-700 mt-1"></div>
                                <p id="resultNote" class="text-sm text-gray-600 mt-2"></p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow p-6">
            <h3 class="text-sky-700 font-semibold">Riwayat Deteksi</h3>
            <div id="historyList" class="mt-4 space-y-3 text-sm text-gray-600 max-h-96 overflow-y-auto">
                <div class="text-gray-400 italic">Belum ada hasil. Mulai kamera lalu ambil gambar.</div>
            </div>

            <div class="mt-6">
                <button id="clearHistory" class="w-full inline-flex justify-center items-center gap-2 bg-gray-100 text-gray-700 px-4 py-2 rounded-lg">
                    <i class="fas fa-trash"></i> Bersihkan Riwayat
                </button>
            </div>
        </div>
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
/* ------------------------- ELEMENTS ------------------------- */
const startBtn = document.getElementById('startBtn');
const captureBtn = document.getElementById('captureBtn');
const stopBtn = document.getElementById('stopBtn');
const downloadBtn = document.getElementById('downloadBtn');
const video = document.getElementById('camera');
const cameraStatus = document.getElementById('cameraStatus');
const resultPanel = document.getElementById('resultPanel');
const resultLabel = document.getElementById('resultLabel');
const resultPercent = document.getElementById('resultPercent');
const resultNote = document.getElementById('resultNote');
const resultImage = document.getElementById('resultImage');
const historyList = document.getElementById('historyList');
const clearHistory = document.getElementById('clearHistory');
const logoutBtn = document.getElementById('logoutBtn');
const uploadBtn = document.getElementById('uploadBtn');
const uploadInput = document.getElementById('uploadInput');

let stream = null;
let lastImageData = null;
let history = JSON.parse(localStorage.getItem('ocealyze_history') || '[]');
const API_ENDPOINT = 'predict.php';

/* ------------------------- HELPERS: WRAP & ANNOTATE ------------------------- */
function wrapText(ctx, text, x, y, maxWidth, lineHeight) {
    const words = text.split(' ');
    let line = '';
    for (let n = 0; n < words.length; n++) {
        const testLine = line + words[n] + ' ';
        const metrics = ctx.measureText(testLine);
        const testWidth = metrics.width;
        if (testWidth > maxWidth && n > 0) {
            ctx.fillText(line, x, y);
            line = words[n] + ' ';
            y += lineHeight;
        } else {
            line = testLine;
        }
    }
    ctx.fillText(line, x, y);
}

function annotateImage(imageDataUrl, labelText, percentText, noteText, timestampText) {
    return new Promise((resolve, reject) => {
        const img = new Image();
        img.crossOrigin = "anonymous";
        img.onload = () => {
            const padding = 18;
            const overlayHeight = 110;
            const canvas = document.createElement('canvas');
            canvas.width = img.width;
            canvas.height = img.height;
            const ctx = canvas.getContext('2d');

            // gambar asli
            ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

            // overlay bottom rounded rectangle
            const boxHeight = overlayHeight;
            const boxY = canvas.height - boxHeight - padding;
            const r = 12;
            ctx.fillStyle = 'rgba(0,0,0,0.45)';
            ctx.beginPath();
            ctx.moveTo(padding + r, boxY);
            ctx.arcTo(canvas.width - padding, boxY, canvas.width - padding, boxY + boxHeight, r);
            ctx.arcTo(canvas.width - padding, boxY + boxHeight, padding, boxY + boxHeight, r);
            ctx.arcTo(padding, boxY + boxHeight, padding, boxY, r);
            ctx.arcTo(padding, boxY, canvas.width - padding, boxY, r);
            ctx.closePath();
            ctx.fill();

            // teks
            const leftX = padding + 16;
            let y = boxY + 18;

            // warna label berdasarkan kata
            let labelColor = '#34D399';
            const l = labelText.toLowerCase();
            if (l.includes('sangat')) labelColor = '#10B981';
            else if (l.includes('segar')) labelColor = '#F59E0B';
            else if (l.includes('kurang')) labelColor = '#DC2626';
            else labelColor = '#60A5FA';

            ctx.textBaseline = 'top';

            // label
            ctx.font = `${Math.round(Math.max(20, canvas.width * 0.035))}px Poppins, sans-serif`;
            ctx.fillStyle = labelColor;
            ctx.fillText(labelText, leftX, y);

            // persen di kanan
            ctx.font = `${Math.round(Math.max(18, canvas.width * 0.03))}px Poppins, sans-serif`;
            ctx.fillStyle = '#ffffff';
            const percentX = canvas.width - padding - ctx.measureText(percentText).width - 24;
            ctx.fillText(percentText, percentX, y);

            // note (baris kedua)
            y += 36;
            ctx.font = `${Math.round(Math.max(13, canvas.width * 0.022))}px Poppins, sans-serif`;
            ctx.fillStyle = '#E5E7EB';
            wrapText(ctx, noteText, leftX, y, canvas.width - leftX - padding - 12, 18);

            // timestamp kanan bawah overlay
            ctx.font = `${Math.round(Math.max(11, canvas.width * 0.018))}px Poppins, sans-serif`;
            ctx.fillStyle = '#C7D2FE';
            const tsWidth = ctx.measureText(timestampText).width;
            ctx.fillText(timestampText, canvas.width - padding - tsWidth - 12, boxY + boxHeight - 28);

            resolve(canvas.toDataURL('image/jpg'));
        };
        img.onerror = (e) => reject(e);
        img.src = imageDataUrl;
    });
}

/* ------------------------- RENDER HISTORY ------------------------- */
function renderHistory(){
    if(!history || history.length===0){
        historyList.innerHTML='<div class="text-gray-400 italic">Belum ada hasil. Mulai kamera lalu ambil gambar.</div>';
        return;
    }
    historyList.innerHTML = history.map(item=>{
        const modelSuffix = (item.model && item.model.toLowerCase() !== item.freshness.toLowerCase()) ? `<div class="text-xs text-gray-500">Model: ${item.model}</div>` : '';
        return `
            <div class="flex flex-col gap-1 bg-slate-50 p-2 rounded">
                <div class="text-xs font-semibold ${item.color}">${item.freshness} — ${item.percent}%</div>
                <div class="text-xs text-gray-500">${new Date(item.timestamp).toLocaleString('id-ID')}</div>
                ${modelSuffix}
            </div>
        `;
    }).join('');
}
renderHistory();

/* ------------------------- CAMERA CONTROL ------------------------- */
startBtn.addEventListener('click', async()=>{
    try{
        stream = await navigator.mediaDevices.getUserMedia({video:{facingMode:'environment'},audio:false});
        video.srcObject = stream;
        cameraStatus.textContent='Kamera aktif';
        startBtn.classList.add('hidden');
        captureBtn.classList.remove('hidden');
        stopBtn.classList.remove('hidden');
    }catch(err){
        console.error(err);
        Swal.fire('Gagal mengakses kamera','Pastikan izin kamera diaktifkan dan coba lagi.','error');
    }
});

stopBtn.addEventListener('click',()=>{
    if(stream) stream.getTracks().forEach(t=>t.stop());
    video.srcObject=null;
    cameraStatus.textContent='Kamera dimatikan';
    startBtn.classList.remove('hidden');
    captureBtn.classList.add('hidden');
    stopBtn.classList.add('hidden');
    downloadBtn.classList.add('hidden');
});

/* ------------------------- PROCESS RESULT, ANNOTATE & SAVE ------------------------- */
async function processResult(modelLabel, confidenceFloat, imageDataUrl=null){
    if(confidenceFloat===null || confidenceFloat===undefined || Number.isNaN(Number(confidenceFloat))) confidenceFloat=0;
    // normalisasi: backend bisa mengirim (0..1) atau persen (0..100)
    let confRatio = Number(confidenceFloat);
    if(confRatio > 1) confRatio = confRatio / 100.0;
    const confidencePercent = (confRatio * 100).toFixed(2);
    const confidenceValue = parseFloat(confidencePercent);

    // tentukan freshness
    let freshness='', note='', short='', colorClass='';
    if(confidenceValue >= 90){
        freshness = 'Sangat Segar';
        note = 'Ikan sangat segar dan layak konsumsi.Hasil analisa pengujian sensori/pengujian orgaleptik (penampangkan)';
        short = 'Sangat Segar';
        colorClass = 'text-green-600';
    } else if(confidenceValue >= 70){
        freshness = 'Segar';
        note = 'Ikan segar, masih layak konsumsi. Hasil analisa pengujian sensori/pengujian orgaleptik (penampangkan)';
        short = 'Segar';
        colorClass = 'text-yellow-600';
    } else if(confidenceValue >= 60){
        freshness = 'Kurang Segar';
        note = 'Kualitas ikan menurun, periksa lebih lanjut. Hasil analisa pengujian sensori/pengujian orgaleptik (penampangkan)';
        short = 'Kurang Segar';
        colorClass = 'text-orange-600';
    } else {
        freshness = 'Tidak Segar';
        note = 'Ikan sudah kurang segar, tidak disarankan dikonsumsi. Hasil analisa pengujian sensori/pengujian orgaleptik (penampangkan)';
        short = 'Tidak Segar';
        colorClass = 'text-red-600';
    }

    const timestampText = new Date().toLocaleString('id-ID');
    let displayLabel = freshness;
    if (modelLabel && modelLabel.toString().trim() !== '' && modelLabel.toLowerCase() !== freshness.toLowerCase()) {
        displayLabel = `${freshness} — ${modelLabel}`;
    }

    // jika ada gambar -> annotate lalu tampilkan & set lastImageData ke annotated image
    if (imageDataUrl) {
        try {
            const annotated = await annotateImage(imageDataUrl, freshness, confidencePercent + '%', note, timestampText);
            resultPanel.classList.remove('hidden');
            resultLabel.textContent = displayLabel;
            resultPercent.textContent = `${confidencePercent}%`;
            resultPercent.className = `text-4xl font-extrabold mt-1 ${colorClass}`;
            resultNote.textContent = note;
            resultImage.src = annotated;
            resultImage.style.display = 'block';
            lastImageData = annotated;
            if (lastImageData) downloadBtn.classList.remove('hidden');
        } catch (err) {
            console.error('Annotate failed', err);
            // fallback: tampilkan original image
            resultPanel.classList.remove('hidden');
            resultLabel.textContent = displayLabel;
            resultPercent.textContent = `${confidencePercent}%`;
            resultNote.textContent = note;
            if (imageDataUrl) {
                resultImage.src = imageDataUrl;
                resultImage.style.display = 'block';
                lastImageData = imageDataUrl;
                if (lastImageData) downloadBtn.classList.remove('hidden');
            }
        }
    } else {
        // tanpa gambar
        resultPanel.classList.remove('hidden');
        resultLabel.textContent = displayLabel;
        resultPercent.textContent = `${confidencePercent}%`;
        resultNote.textContent = note;
    }

    // simpan riwayat
    history.unshift({
        timestamp: new Date().toISOString(),
        freshness: freshness,
        percent: confidencePercent,
        short: short,
        model: modelLabel || '',
        color: colorClass
    });
    history = history.slice(0,50);
    localStorage.setItem('ocealyze_history', JSON.stringify(history));
    renderHistory();
}

/* ------------------------- CAPTURE & UPLOAD ------------------------- */
captureBtn.addEventListener('click', captureHandler);
uploadBtn.addEventListener('click',()=>uploadInput.click());
uploadInput.addEventListener('change',uploadHandler);

async function captureHandler(){
    if(!video.videoWidth){
        Swal.fire('Kesalahan','Video belum siap. Mohon tunggu beberapa detik lalu coba lagi.','warning');
        return;
    }
    const canvas=document.createElement('canvas');
    canvas.width=960; // sedikit lebih besar untuk kualitas annotasi lebih baik
    canvas.height=Math.round((video.videoHeight/video.videoWidth)*960);
    const ctx=canvas.getContext('2d');
    ctx.drawImage(video,0,0,canvas.width,canvas.height);
    const dataUrl=canvas.toDataURL('image/jpg');

    canvas.toBlob(async(blob)=>{
        if(!blob){ Swal.fire('Kesalahan','Gagal membuat gambar.','error'); return; }
        Swal.fire({title:'Memproses...',text:'Mengirim gambar ke model AI',allowOutsideClick:false,didOpen:()=>{Swal.showLoading();}});

        try{
            const form=new FormData();
            form.append('file',blob,'capture.png');
            const resp=await fetch(API_ENDPOINT,{method:'POST',body:form});
            if(!resp.ok){ const txt=await resp.text(); throw new Error('HTTP '+resp.status+': '+txt); }
            const data=await resp.json();

            const modelLabel = data.predicted_class || data.predicted || '';
            let conf = null;
            if(data.confidence!==undefined && data.confidence!==null) conf=Number(data.confidence);
            else if(data.probability!==undefined) conf=Number(data.probability);
            else if(data.scores!==undefined && Array.isArray(data.scores)) conf=Math.max(...data.scores.map(Number));
            if(conf===null||Number.isNaN(conf)) conf=0;
            if(conf > 1) conf = conf / 100.0; // normalize if backend sends percent

            await processResult(modelLabel, conf, dataUrl);
            Swal.close();
        }catch(err){ console.error(err); Swal.close(); Swal.fire('Gagal','Terjadi kesalahan: '+err.message,'error'); }
    },'image/jpg');
}

async function uploadHandler(){
    const file=uploadInput.files[0]; if(!file) return;
    Swal.fire({title:'Memproses...',text:'Gambar sedang dianalisis AI',allowOutsideClick:false,didOpen:()=>{Swal.showLoading();}});
    const reader=new FileReader();
    reader.onload=async()=>{ 
        const imageDataUrl=reader.result;
        try{
            const formData=new FormData(); formData.append('file',file);
            const resp=await fetch(API_ENDPOINT,{method:'POST',body:formData});
            if(!resp.ok){ const txt=await resp.text(); throw new Error('HTTP '+resp.status+': '+txt); }
            const data=await resp.json();

            const modelLabel = data.predicted_class || data.predicted || '';
            let conf = null;
            if(data.confidence!==undefined && data.confidence!==null) conf=Number(data.confidence);
            else if(data.probability!==undefined) conf=Number(data.probability);
            else if(data.scores!==undefined && Array.isArray(data.scores)) conf=Math.max(...data.scores.map(Number));
            if(conf===null||Number.isNaN(conf)) conf=0;
            if(conf>1) conf=conf/100.0;

            await processResult(modelLabel,conf,imageDataUrl);
            Swal.close();
        }catch(err){ console.error(err); Swal.close(); Swal.fire('Gagal','Terjadi kesalahan: '+err.message,'error');}
    };
    reader.readAsDataURL(file);
}

/* ------------------------- DOWNLOAD & CLEAR HISTORY ------------------------- */
downloadBtn.addEventListener('click',()=>{
    if(!lastImageData) return;
    const a=document.createElement('a');
    a.href=lastImageData;
    a.download = `hasil_deteksi_${new Date().toISOString().replace(/[:.]/g,'-')}.jpg`;
    document.body.appendChild(a);
    a.click();
    a.remove();
});

clearHistory.addEventListener('click',()=>{
    Swal.fire({
        title:'Hapus Riwayat?',
        text:'Semua data deteksi akan dihapus.',
        icon:'warning',
        showCancelButton:true,
        confirmButtonColor:'#d33',
        confirmButtonText:'Hapus',
        cancelButtonText:'Batal'
    }).then(result=>{
        if(result.isConfirmed){
            history=[];
            localStorage.removeItem('ocealyze_history');
            renderHistory();
        }
    });
});

  const menuBtn = document.getElementById('menuBtn');
  const mobileMenu = document.getElementById('mobileMenu');

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
