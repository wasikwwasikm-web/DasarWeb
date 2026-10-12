<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/koneksi.php';

$anggotaId = filter_var($_POST['anggota_id'] ?? null, FILTER_VALIDATE_INT);
$bukuId = filter_var($_POST['buku_id'] ?? null, FILTER_VALIDATE_INT);

if ($anggotaId === false || $anggotaId < 1 || $bukuId === false || $bukuId < 1) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Pilih anggota dan buku yang valid.'];
    header('Location: list.php');
    exit;
}

try {
    $pdo->beginTransaction();

    $cekAnggota = $pdo->prepare("SELECT id FROM anggota WHERE id = :id");
    $cekAnggota->execute(['id' => $anggotaId]);
    if (!$cekAnggota->fetchColumn()) {
        $pdo->rollBack();
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Anggota tidak ditemukan.'];
        header('Location: list.php');
        exit;
    }

    // [New] Perbarui stok secara atomik agar stok tidak bisa dipinjam melebihi jumlah tersedia.
    $kurangiStok = $pdo->prepare(
        "UPDATE buku SET stok = stok - 1 WHERE id = :id AND stok > 0 RETURNING id"
    );
    $kurangiStok->execute(['id' => $bukuId]);
    if (!$kurangiStok->fetchColumn()) {
        $pdo->rollBack();
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Buku tidak ditemukan atau stok sedang tidak tersedia.'];
        header('Location: list.php');
        exit;
    }

    $stmt = $pdo->prepare(
        "INSERT INTO peminjaman (buku_id, anggota_id) VALUES (:buku_id, :anggota_id)"
    );
    $stmt->execute(['buku_id' => $bukuId, 'anggota_id' => $anggotaId]);
    $pdo->commit();

    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Peminjaman berhasil dicatat.'];
} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    error_log('Gagal mencatat peminjaman: ' . $e->getMessage());
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Peminjaman gagal disimpan. Silakan coba lagi.'];
}

header('Location: list.php');
exit;
