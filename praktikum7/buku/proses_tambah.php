<?php
require_once __DIR__ . '/../includes/bootstrap.php';

$judul = trim($_POST['judul'] ?? '');
$pengarang = trim($_POST['pengarang'] ?? '');
$tahun = $_POST['tahun'] ?? '';
$isbn = trim($_POST['isbn'] ?? '');
$stok = $_POST['stok'] ?? '';
$kategori = trim($_POST['kategori'] ?? '');

$errors = [];

if ($judul === '') {
    $errors[] = "Judul wajib diisi.";
}
if ($pengarang === '') {
    $errors[] = "Pengarang wajib diisi.";
}
if (!is_numeric($tahun) || $tahun < 1900 || $tahun > (int) date('Y')) {
    $errors[] = "Tahun harus di antara 1900 dan " . date('Y') . ".";
}
if (!is_numeric($stok) || $stok < 0) {
    $errors[] = "Stok harus berupa angka non-negatif.";
}

// Kalau ada error: flash error + redirect kembali
if (!empty($errors)) {
    $_SESSION['flash'] = [
        'type' => 'error',
        'pesan' => implode(' ', $errors)
    ];
    header('Location: tambah.php');
    exit;
}

// Kalau valid: simpan ke session
$_SESSION['buku']['items'][] = [
    'judul' => $judul,
    'pengarang' => $pengarang,
    'tahun' => (int) $tahun,
    'isbn' => $isbn,
    'stok' => (int) $stok,
    'kategori' => $kategori,
];

$_SESSION['flash'] = [
    'type' => 'success',
    'pesan' => 'Buku berhasil ditambahkan.'
];

header('Location: list.php');
exit;
