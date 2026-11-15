<?php
// proses Update kategori.
session_start();
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$nama = trim($_POST['nama'] ?? '');
$deskripsi = trim($_POST['deskripsi'] ?? '');

if (!$id) {
    header('Location: list.php');
    exit;
}
if ($nama === '' || mb_strlen($nama) > 50 || mb_strlen($deskripsi) > 255) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Nama kategori wajib diisi (maksimal 50 karakter); deskripsi maksimal 255 karakter.'];
    header('Location: edit.php?id=' . $id);
    exit;
}

$stmt = $pdo->prepare("UPDATE kategori_buku SET nama = :nama, deskripsi = :deskripsi WHERE id = :id");
try {
    $stmt->execute(['nama' => $nama, 'deskripsi' => $deskripsi === '' ? null : $deskripsi, 'id' => $id]);
} catch (PDOException $e) {
    if ($e->getCode() !== '23505') {
        throw $e;
    }
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Nama kategori tersebut sudah digunakan.'];
    header('Location: edit.php?id=' . $id);
    exit;
}

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Kategori berhasil diperbarui.'];
header('Location: list.php');
exit;
