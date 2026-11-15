<?php
// proses Create kategori.
session_start();
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

$nama = trim($_POST['nama'] ?? '');
$deskripsi = trim($_POST['deskripsi'] ?? '');

if ($nama === '' || mb_strlen($nama) > 50 || mb_strlen($deskripsi) > 255) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Nama kategori wajib diisi (maksimal 50 karakter); deskripsi maksimal 255 karakter.'];
    header('Location: tambah.php');
    exit;
}

$stmt = $pdo->prepare("INSERT INTO kategori_buku (nama, deskripsi) VALUES (:nama, :deskripsi)");
try {
    $stmt->execute(['nama' => $nama, 'deskripsi' => $deskripsi === '' ? null : $deskripsi]);
} catch (PDOException $e) {
    if ($e->getCode() !== '23505') {
        throw $e;
    }
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Nama kategori tersebut sudah digunakan.'];
    header('Location: tambah.php');
    exit;
}

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Kategori berhasil ditambahkan.'];
header('Location: list.php');
exit;
