<?php
require __DIR__ . '/../includes/auth.php';
require __DIR__ . '/../includes/koneksi.php';

$id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
if ($id === false || $id < 1) {
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Transaksi peminjaman tidak valid.'];
    header('Location: list.php');
    exit;
}

try {
    $pdo->beginTransaction();

    // [New] Kunci transaksi agar pengembalian bersamaan tidak menambah stok dua kali.
    $stmt = $pdo->prepare(
        "SELECT buku_id FROM peminjaman WHERE id = :id AND tanggal_kembali IS NULL FOR UPDATE"
    );
    $stmt->execute(['id' => $id]);
    $bukuId = $stmt->fetchColumn();

    if ($bukuId === false) {
        $pdo->rollBack();
        $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Transaksi tidak ditemukan atau sudah dikembalikan.'];
        header('Location: list.php');
        exit;
    }

    $tandaiKembali = $pdo->prepare(
        "UPDATE peminjaman SET tanggal_kembali = CURRENT_DATE WHERE id = :id AND tanggal_kembali IS NULL"
    );
    $tandaiKembali->execute(['id' => $id]);

    $tambahStok = $pdo->prepare("UPDATE buku SET stok = stok + 1 WHERE id = :id");
    $tambahStok->execute(['id' => $bukuId]);
    if ($tambahStok->rowCount() !== 1) {
        throw new RuntimeException('Buku untuk transaksi pengembalian tidak ditemukan.');
    }

    $pdo->commit();
    $_SESSION['flash'] = ['type' => 'success', 'pesan' => 'Buku berhasil ditandai sudah dikembalikan.'];
} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    error_log('Gagal mencatat pengembalian: ' . $e->getMessage());
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Pengembalian gagal disimpan. Silakan coba lagi.'];
} catch (RuntimeException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    error_log('Gagal mencatat pengembalian: ' . $e->getMessage());
    $_SESSION['flash'] = ['type' => 'error', 'pesan' => 'Buku terkait transaksi tidak ditemukan.'];
}

header('Location: list.php');
exit;
