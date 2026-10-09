<?php
session_start();

if (!isset($_SESSION['buku']['items'])) {
    $_SESSION['buku']['items'] = [];
}

if (!isset($_SESSION['anggota'])) {
    $_SESSION['anggota'] = [];
}
