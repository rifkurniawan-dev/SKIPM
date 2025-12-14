<?php
// functions.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// CSRF helpers (dipakai juga untuk form lain)
function csrf_token() {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}
function csrf_check($token) {
    return isset($_SESSION['csrf']) && hash_equals($_SESSION['csrf'], $token);
}

// Auth helpers
function is_admin_logged_in() {
    return !empty($_SESSION['admin_id']);
}
function require_admin_login() {
    if (!is_admin_logged_in()) {
        header('Location: login.php');
        exit;
    }
}

// Flash messages (simple)
function flash_set($key, $msg) {
    $_SESSION['flash'][$key] = $msg;
}
function flash_get($key) {
    if (isset($_SESSION['flash'][$key])) {
        $v = $_SESSION['flash'][$key];
        unset($_SESSION['flash'][$key]);
        return $v;
    }
    return null;
}
