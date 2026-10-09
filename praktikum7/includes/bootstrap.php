<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['buku']['items']) || !is_array($_SESSION['buku']['items'])) {
    $_SESSION['buku']['items'] = [];
}

if (!isset($_SESSION['anggota']) || !is_array($_SESSION['anggota'])) {
    $_SESSION['anggota'] = [];
}
