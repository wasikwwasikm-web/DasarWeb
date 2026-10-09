<?php
require_once __DIR__ . '/../includes/bootstrap.php';

if (!isset($_POST['index']) || !is_numeric($_POST['index'])) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Data yang akan dihapus tidak valid.'];
    header('Location: list.php');
    exit;
}

$index = (int) $_POST['index'];
$items = $_SESSION['buku']['items'] ?? [];

if (!isset($items[$index])) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Data buku tidak ditemukan.'];
    header('Location: list.php');
    exit;
}

unset($items[$index]);
$_SESSION['buku']['items'] = array_values($items);
$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Buku berhasil dihapus.'];

header('Location: list.php');
exit;
