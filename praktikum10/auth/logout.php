<?php
require_once __DIR__ . '/../includes/session.php';
start_app_session();

// Soal Praktikum 10 No. 2: hapus cookie sesi persisten saat logout.
setcookie(session_name(), '', [
    'expires' => time() - 3600,
    'path' => app_base_path(),
    'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
    'httponly' => true,
    'samesite' => 'Lax',
]);
session_destroy();
header('Location: login.php');
exit;
