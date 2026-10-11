<?php
// Guard clause: wajib di-require di baris paling atas halaman terkunci,
// SEBELUM header.php / output HTML apapun.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}
