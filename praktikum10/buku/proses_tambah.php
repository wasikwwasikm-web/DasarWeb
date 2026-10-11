<?php
require __DIR__ . '/../includes/auth.php';
session_start();
require __DIR__ . '/../includes/koneksi.php';

$judul = trim($_POST['judul'] ?? '');
$pengarang = trim($_POST['pengarang'] ?? '');
$tahun = $_POST['tahun'] ?? '';
$isbn = trim($_POST['isbn'] ?? '');
$stok = $_POST['stok'] ?? '';
$kategori = trim($_POST['kategori'] ?? '');
$penerbit = trim($_POST['penerbit'] ?? '');
$deskripsi = trim($_POST['deskripsi'] ?? '');
$bahasa = trim($_POST['bahasa'] ?? 'Indonesia');

// Validasi server-side — wajib ada meski sudah divalidasi JS di Jobsheet 5,
// karena validasi client bisa dilewati (nonaktifkan JS / kirim request manual).
$errors = [];
if ($judul === '') {
    $errors[] = "Judul wajib diisi.";
}
if ($pengarang === '') {
    $errors[] = "Pengarang wajib diisi.";
}
// [DIUBAH] Validasi server juga membatasi tahun ke bilangan bulat dan tahun berjalan.
$tahunValid = filter_var($tahun, FILTER_VALIDATE_INT);
if ($tahunValid === false || $tahunValid < 1900 || $tahunValid > (int) date('Y')) {
    $errors[] = "Tahun harus berupa bilangan bulat antara 1900-" . date('Y') . ".";
}
$stokValid = filter_var($stok, FILTER_VALIDATE_INT);
if ($stokValid === false || $stokValid < 0) {
    $errors[] = "Stok harus berupa bilangan bulat dan tidak boleh negatif.";
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => implode(' ', $errors)];
    header('Location: tambah.php');
    exit;
}

$stmt = $pdo->prepare(
    "INSERT INTO buku (judul, pengarang, tahun, isbn, stok, kategori, penerbit, deskripsi, bahasa)
     VALUES (:judul, :pengarang, :tahun, :isbn, :stok, :kategori, :penerbit, :deskripsi, :bahasa)
     RETURNING id"
);
$stmt->execute([
    'judul' => $judul,
    'pengarang' => $pengarang,
    'tahun' => $tahunValid,
    'isbn' => $isbn,
    'stok' => $stokValid,
    'kategori' => $kategori,
    'penerbit' => $penerbit,
    'deskripsi' => $deskripsi,
    'bahasa' => $bahasa,
]);

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Buku berhasil ditambahkan.'];
header('Location: list.php');
exit;
