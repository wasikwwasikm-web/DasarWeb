<?php
require_once __DIR__ . '/../includes/bootstrap.php';

if (!isset($_POST['index']) || !is_numeric($_POST['index'])) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Data yang akan dihapus tidak valid.'];
    header('Location: list.php');
    exit;
}

$index = (int) $_POST['index'];
$items = $_SESSION['anggota'] ?? [];

if (!isset($items[$index])) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Data anggota tidak ditemukan.'];
    header('Location: list.php');
    exit;
}

unset($items[$index]);
$_SESSION['anggota'] = array_values($items);
$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Anggota berhasil dihapus.'];

header('Location: list.php');
exit;
