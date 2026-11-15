<?php
// proses Delete kategori.
session_start();
require __DIR__ . '/../includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: list.php');
    exit;
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Kategori yang dipilih tidak valid.'];
    header('Location: list.php');
    exit;
}

$stmt = $pdo->prepare("DELETE FROM kategori_buku WHERE id = :id");
try {
    $stmt->execute(['id' => $id]);
} catch (PDOException $e) {
    if ($e->getCode() !== '23503') {
        throw $e;
    }
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Kategori masih digunakan oleh buku dan tidak dapat dihapus.'];
    header('Location: list.php');
    exit;
}

$_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Kategori berhasil dihapus.'];
header('Location: list.php');
exit;
