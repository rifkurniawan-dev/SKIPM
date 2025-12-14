<?php
// proses_login_admin.php (robust debug / dev)
// HANYA untuk development. Setelah debug, hapus display_errors lines.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');
session_start();

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode(['status'=>'error','message'=>'Metode request tidak diperbolehkan.']);
        exit;
    }

    // Pastikan koneksi file berada di path yang benar
    $koneksiPath = __DIR__ . '/koneksi.php';
    if (!file_exists($koneksiPath)) {
        // Log untuk admin, kembalikan pesan generik ke client
        error_log("koneksi.php tidak ditemukan di: $koneksiPath");
        http_response_code(500);
        echo json_encode(['status'=>'error','message'=>'Server configuration error.']);
        exit;
    }
    require_once $koneksiPath;
    if (!isset($conn) || !$conn) {
        error_log("Variabel \$conn tidak tersedia atau koneksi gagal.");
        http_response_code(500);
        echo json_encode(['status'=>'error','message'=>'Database connection error.']);
        exit;
    }

    // Ambil input
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if ($username === '' || $password === '') {
        echo json_encode(['status'=>'error','message'=>'Username dan password harus diisi.']);
        exit;
    }

    // Prepared statement
    $stmt = $conn->prepare("SELECT id_admin, username, password FROM admins WHERE username = ? LIMIT 1");
    if (!$stmt) {
        error_log("Prepare gagal: " . $conn->error);
        http_response_code(500);
        echo json_encode(['status'=>'error','message'=>'Server error (db).']);
        exit;
    }
    $stmt->bind_param("s", $username);
    $execOk = $stmt->execute();
    if (!$execOk) {
        error_log("Execute gagal pada proses_login_admin.php: " . $stmt->error);
        http_response_code(500);
        echo json_encode(['status'=>'error','message'=>'Server error (db).']);
        exit;
    }

    // Ambil hasil, dengan fallback untuk lingkungan tanpa mysqlnd
    $user = null;
    if (method_exists($stmt, 'get_result')) {
        $res = $stmt->get_result();
        $user = $res ? $res->fetch_assoc() : null;
    } else {
        $stmt->bind_result($f_id_admin, $f_username, $f_password);
        if ($stmt->fetch()) {
            $user = [
                'id_admin' => $f_id_admin,
                'username' => $f_username,
                'password' => $f_password
            ];
        }
    }
    $stmt->close();

    if (!$user) {
        // Jangan merinci; untuk UX bisa ubah nanti
        echo json_encode(['status'=>'error','message'=>'Username atau password salah.']);
        exit;
    }

    $dbHash = $user['password'];
    $verified = false;

    if (password_verify($password, $dbHash)) {
        $verified = true;
    } else {
        // fallback jika DB plaintext (HANYA fallback)
        if (hash_equals((string)$dbHash, (string)$password)) {
            $verified = true;
        }
    }

    if ($verified) {
        session_regenerate_id(true);
        $_SESSION['id_admin'] = (int)$user['id_admin'];
        $_SESSION['username'] = $user['username'];
        echo json_encode(['status'=>'success']);
        exit;
    } else {
        echo json_encode(['status'=>'error','message'=>'Username atau password salah.']);
        exit;
    }

} catch (Throwable $e) {
    // Log detail ke error_log (server) — jangan kirim detail ke client di production
    error_log("Proses login exception: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine());
    http_response_code(500);
    echo json_encode(['status'=>'error','message'=>'Terjadi kesalahan server.']);
    exit;
}
