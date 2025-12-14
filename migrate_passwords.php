<?php
// migrate_passwords.php
// Jalankan sekali lalu hapus file ini.
// Pastikan koneksi.php tersedia.
require_once 'koneksi.php';

$counter = 0;
$skipped = 0;

try {
    // Ambil semua admin
    $res = $conn->query("SELECT id_admin, password FROM admins");
    while ($row = $res->fetch_assoc()) {
        $id = (int)$row['id_admin'];
        $pw = $row['password'];

        // Cek apakah string sudah tampak hash bcrypt/argon2 (memulai dengan $2y$ atau $argon2)
        $isHashed = (strpos($pw, '$2y$') === 0 || strpos($pw, '$2a$') === 0 || strpos($pw, '$argon2') === 0);

        if ($isHashed) {
            $skipped++;
            continue;
        }

        // Anggap plaintext -> buat hash
        $hash = password_hash($pw, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE admins SET password = ? WHERE id_admin = ?");
        $stmt->bind_param("si", $hash, $id);
        $stmt->execute();
        $stmt->close();
        $counter++;
    }

    echo "Selesai. Di-hash: {$counter}. Dilewati (sudah hash): {$skipped}.\n";
} catch (Exception $e) {
    echo "Error: ".$e->getMessage();
}
