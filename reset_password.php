<?php
// reset_password.php
require_once 'koneksi.php';
session_start();

$selector = $_GET['selector'] ?? '';
$validator = $_GET['validator'] ?? '';

$error = '';
$info = '';

// Jika tidak ada parameter, tampilkan error
if (!$selector || !$validator) {
    $error = "Tautan reset tidak lengkap.";
} else {
    // Cari record yang belum kadaluarsa
    $stmt = $conn->prepare("SELECT id, token_hash, user_email, expires_at FROM password_resets WHERE selector = ? LIMIT 1");
    $stmt->bind_param("s", $selector);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    $stmt->close();

    if (!$row) {
        $error = "Tautan reset tidak valid atau sudah digunakan.";
    } else {
        // Cek expired
        $expires = strtotime($row['expires_at']);
        if ($expires < time()) {
            $error = "Tautan reset sudah kadaluarsa.";
            // Hapus token yang kadaluarsa
            $del = $conn->prepare("DELETE FROM password_resets WHERE id = ?");
            $del->bind_param("i", $row['id']);
            $del->execute();
            $del->close();
        } else {
            // Verifikasi validator (token) dengan hash
            // validator dikirim sebagai hex string; kita menyimpannya langsung sebagai string token saat pembuatan
            if (!password_verify($validator, $row['token_hash'])) {
                $error = "Tautan reset tidak valid.";
            } else {
                // siap menampilkan form ganti password
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $password = $_POST['password'] ?? '';
                    $password2 = $_POST['password2'] ?? '';

                    if (strlen($password) < 6) {
                        $error = "Password minimal 6 karakter.";
                    } elseif ($password !== $password2) {
                        $error = "Password dan konfirmasi tidak cocok.";
                    } else {
                        // Update password user (hash dulu)
                        $new_hash = password_hash($password, PASSWORD_DEFAULT);
                        // Pastikan nama tabel & kolom sesuai (saya anggap 'users' dan 'password')
                        $upd = $conn->prepare("UPDATE users SET password = ? WHERE email = ? LIMIT 1");
                        $upd->bind_param("ss", $new_hash, $row['user_email']);
                        $ok = $upd->execute();
                        $upd->close();

                        if ($ok) {
                            // Hapus token
                            $del = $conn->prepare("DELETE FROM password_resets WHERE id = ?");
                            $del->bind_param("i", $row['id']);
                            $del->execute();
                            $del->close();

                            $info = "Password berhasil diperbarui. Silakan <a href='login.php'>login</a>.";
                        } else {
                            $error = "Gagal memperbarui password. Silakan coba lagi.";
                        }
                    }
                }
            }
        }
    }
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Reset Password</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    body{font-family:Arial,Helvetica,sans-serif;display:flex;align-items:center;justify-content:center;height:100vh;margin:0;background:#f4f6f8}
    .card{background:white;padding:28px;border-radius:12px;box-shadow:0 6px 24px rgba(0,0,0,0.08);width:100%;max-width:420px}
    input{width:100%;padding:12px;border-radius:8px;border:1px solid #ddd;margin-top:8px}
    button{margin-top:12px;padding:12px 16px;border:none;border-radius:8px;background:#28a745;color:white;cursor:pointer}
    .info{background:#e6ffed;color:#064e2a;padding:10px;border-radius:8px;margin-top:12px}
    .err{background:#ffecec;color:#611a15;padding:10px;border-radius:8px;margin-top:12px}
    a{color:#007bff}
  </style>
</head>
<body>
  <div class="card">
    <h2>Reset Password</h2>

    <?php if ($error): ?>
      <div class="err"><?= htmlspecialchars($error) ?></div>
    <?php elseif ($info): ?>
      <div class="info"><?= $info ?></div>
    <?php endif; ?>

    <?php if (!$error && !$info): ?>
      <form method="post">
        <label>Password baru</label>
        <input type="password" name="password" required placeholder="Minimal 6 karakter" />
        <label>Konfirmasi password</label>
        <input type="password" name="password2" required placeholder="Ketik lagi password" />
        <button type="submit">Simpan Password Baru</button>
      </form>
    <?php endif; ?>

  </div>
</body>
</html>
