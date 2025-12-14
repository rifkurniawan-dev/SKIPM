<?php
// dashboard_admin.php
session_start();
require_once 'koneksi.php';

if (!isset($_SESSION['id_admin'])) {
    header("Location: login_admin.php");
    exit;
}

$id_admin = intval($_SESSION['id_admin']);

$stmt = $conn->prepare("SELECT id_admin, username, email, created_at FROM admins WHERE id_admin = ?");
$stmt->bind_param("i", $id_admin);
$stmt->execute();
$res = $stmt->get_result();
$admin = $res->fetch_assoc();
$stmt->close();

/*
  PERHATIAN:
  - Asumsi tabel visitors (id, created_at)
  - Asumsi tabel pengajuan (id_pengajuan, created_at)
  - Asumsi tabel articles atau artikel
  Jika nama/struktur berbeda, sesuaikan query di bawah.
*/

// Default values
$totalVisitors = 0;
$totalPengajuan = 0;
$totalArticles = 0;
$totalAdmins = 0;
$visitorsMonths = [];   // associative ym => count
$pengajuanMonths = [];  // associative ym => count
$errorMessages = [];

try {
    // Total visitors
    $q1 = "SELECT COUNT(*) AS cnt FROM visitors";
    $r1 = @$conn->query($q1);
    if ($r1) {
        $row = $r1->fetch_assoc();
        $totalVisitors = (int)($row['cnt'] ?? 0);
    } else {
        $errorMessages[] = "Tabel `visitors` mungkin tidak ada atau query gagal.";
    }

    // Total pengajuan
    $q2 = "SELECT COUNT(*) AS cnt FROM pengajuan";
    $r2 = @$conn->query($q2);
    if ($r2) {
        $row = $r2->fetch_assoc();
        $totalPengajuan = (int)($row['cnt'] ?? 0);
    } else {
        $errorMessages[] = "Tabel `pengajuan` mungkin tidak ada atau query gagal.";
    }

    // Total articles (coba 'articles' lalu 'artikel')
    $rA = @$conn->query("SELECT COUNT(*) AS cnt FROM articles");
    if ($rA) {
        $totalArticles = (int)$rA->fetch_assoc()['cnt'];
    } else {
        $rA2 = @$conn->query("SELECT COUNT(*) AS cnt FROM artikel");
        if ($rA2) $totalArticles = (int)$rA2->fetch_assoc()['cnt'];
        else $totalArticles = 0;
    }

    // Total admins
    $rAdm = @$conn->query("SELECT COUNT(*) AS cnt FROM admins");
    if ($rAdm) $totalAdmins = (int)$rAdm->fetch_assoc()['cnt'];

    // Statistik 6 bulan terakhir: visitors
    $q3 = "
      SELECT DATE_FORMAT(created_at, '%Y-%m') AS ym, COUNT(*) AS cnt
      FROM visitors
      WHERE created_at >= DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 5 MONTH),'%Y-%m-01')
      GROUP BY ym
      ORDER BY ym
    ";
    $r3 = @$conn->query($q3);
    if ($r3) {
        while ($row = $r3->fetch_assoc()) {
            $visitorsMonths[$row['ym']] = (int)$row['cnt'];
        }
    }

    // Statistik 6 bulan terakhir: pengajuan
    $q4 = "
      SELECT DATE_FORMAT(created_at, '%Y-%m') AS ym, COUNT(*) AS cnt
      FROM pengajuan
      WHERE created_at >= DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 5 MONTH),'%Y-%m-01')
      GROUP BY ym
      ORDER BY ym
    ";
    $r4 = @$conn->query($q4);
    if ($r4) {
        while ($row = $r4->fetch_assoc()) {
            $pengajuanMonths[$row['ym']] = (int)$row['cnt'];
        }
    }

} catch (Throwable $e) {
    $errorMessages[] = "Kesalahan saat mengambil data statistik: " . $e->getMessage();
}

// Build labels for last 6 months (YYYY-MM)
$labels = [];
for ($i = 5; $i >= 0; $i--) {
    $m = date('Y-m', strtotime("-{$i} months"));
    $labels[] = $m;
}

// Build datasets aligned to labels
$visitorsData = [];
$pengajuanData = [];
foreach ($labels as $ym) {
    $visitorsData[] = isset($visitorsMonths[$ym]) ? (int)$visitorsMonths[$ym] : 0;
    $pengajuanData[] = isset($pengajuanMonths[$ym]) ? (int)$pengajuanMonths[$ym] : 0;
}

// For display labels (friendly: e.g., "Dec 2025")
$labelsDisplay = array_map(function($ym){
    $dt = DateTime::createFromFormat('Y-m', $ym);
    return $dt ? $dt->format('M Y') : $ym;
}, $labels);

?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<title>Dashboard Admin</title>

<!-- Tailwind CSS -->
<script src="https://cdn.tailwindcss.com"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
.custom-card {
  background:white;
  border-radius:12px;
  padding:18px;
  box-shadow:0 6px 22px rgba(15,23,42,0.06);
}
.stat-number { font-size:1.75rem; font-weight:700; color:#0f172a; }
.stat-label { color:#6b7280; font-size:0.9rem; }
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
        <a href="artikel_admin.php" class="block px-4 py-2 rounded-md mb-2 hover:bg-blue-700">Berita dan Artikel</a>
    </nav>
</aside>

<!-- MAIN: use left padding (pl-72) so content tidak mepet ke sidebar (sidebar width = 16rem = 64) -->
<main class="pl-72 pt-28 pr-6 pb-10">


    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
      <!-- === SUMMARY CARDS (4 kotak) === -->
    

        <!-- Total Pengunjung -->
        <div class="p-5 bg-white rounded-xl shadow hover:shadow-md transition">
            <p class="text-sm text-gray-500">Total Pengunjung</p>
            <h3 class="text-3xl font-bold mt-2"><?= number_format($totalVisitors) ?></h3>
        </div>
        <!-- Total Artikel -->
        <div class="p-5 bg-white rounded-xl shadow hover:shadow-md transition">
            <p class="text-sm text-gray-500">Total Artikel</p>
            <h3 class="text-3xl font-bold mt-2"><?= number_format($totalArticles) ?></h3>
        </div>

        <!-- Total Admin -->
        <div class="p-5 bg-white rounded-xl shadow hover:shadow-md transition">
            <p class="text-sm text-gray-500">Total Admin</p>
            <h3 class="text-3xl font-bold mt-2"><?= number_format($totalAdmins) ?></h3>
        </div>

    </div>


</main>

<script>
const labels = <?= json_encode($labelsDisplay) ?>;
const visitorsData = <?= json_encode($visitorsData) ?>;

const commonOptions = {
  maintainAspectRatio: false,
  plugins: { legend: { display: false } },
  scales: {
    x: { grid: { display: false }},
    y: { beginAtZero: true, ticks: { precision: 0 } }
  }
};

// Visitors Chart
$q1 = "SELECT COUNT(*) AS cnt FROM visitors";

new Chart(document.getElementById('chartVisitors'), {
  type: 'line',
  data: {
    labels: labels,
    datasets: [{
      label: 'Pengunjung',
      data: visitorsData,
      tension: 0.3,
      fill: true,
      backgroundColor: 'rgba(16,185,129,0.15)',
      borderColor: 'rgba(16,185,129,1)',
      pointBackgroundColor: 'rgba(16,185,129,1)',
      pointRadius: 4
    }]
  },
  options: commonOptions
});
</script>

</body>
</html>
