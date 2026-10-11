<?php
require __DIR__ . '/../includes/auth.php';
session_start();
require __DIR__ . '/../includes/koneksi.php';

$id = $_POST['id'] ?? null;
$judul = trim($_POST['judul'] ?? '');
$pengarang = trim($_POST['pengarang'] ?? '');
$tahun = $_POST['tahun'] ?? '';
$isbn = trim($_POST['isbn'] ?? '');
$stok = $_POST['stok'] ?? '';
$kategori = trim($_POST['kategori'] ?? '');
$penerbit = trim($_POST['penerbit'] ?? '');
$bahasa = trim($_POST['bahasa'] ?? 'Indonesia');
$deskripsi = trim($_POST['deskripsi'] ?? '');

if (!$id) {
    header('Location: list.php');
    exit;
}

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
    header('Location: edit.php?id=' . urlencode($id));
    exit;
}

$stmt = $pdo->prepare(
    "UPDATE buku SET judul = :judul, pengarang = :pengarang, tahun = :tahun,
     isbn = :isbn, stok = :stok, kategori = :kategori, penerbit = :penerbit, bahasa = :bahasa, deskripsi = :deskripsi WHERE id = :id"
);
$stmt->execute([
    'judul' => $judul,
    'pengarang' => $pengarang,
    'tahun' => $tahunValid,
    'isbn' => $isbn,
    'stok' => $stokValid,
    'kategori' => $kategori,
    'penerbit' => $penerbit,
    'bahasa' => $bahasa,
    'deskripsi' => $deskripsi,
    'id' => $id,
]);

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Buku berhasil diperbarui.'];
header('Location: list.php');
exit;
