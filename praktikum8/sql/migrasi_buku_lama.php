<?php
// migrasikan data buku lama dari JSON ke PostgreSQL.
// Jalankan skrip ini satu kali agar data tidak terduplikasi.
require __DIR__ . '/../includes/koneksi.php';

$jsonPath = dirname(__DIR__, 2) . '/praktikum6/data/buku.json';

if (!is_file($jsonPath)) {
    throw new RuntimeException("File data buku lama tidak ditemukan: {$jsonPath}");
}

$json = file_get_contents($jsonPath);
if ($json === false) {
    throw new RuntimeException('File data buku lama tidak dapat dibaca.');
}

$data = json_decode($json, true);

if (!is_array($data) || json_last_error() !== JSON_ERROR_NONE) {
    throw new RuntimeException('Format file JSON tidak valid: ' . json_last_error_msg());
}

$insert = $pdo->prepare(
    "INSERT INTO buku (judul, pengarang, tahun, stok, kategori)
     VALUES (:judul, :pengarang, :tahun, :stok, :kategori)"
);

$jumlah = 0;
try {
    $pdo->beginTransaction();

    foreach ($data as $buku) {
        if (!is_array($buku) || !isset($buku['judul'], $buku['pengarang'], $buku['tahun'], $buku['stok'])) {
            throw new RuntimeException('Ada data buku lama yang tidak memiliki field wajib.');
        }

        $insert->execute([
            'judul' => $buku['judul'],
            'pengarang' => $buku['pengarang'],
            'tahun' => (int) $buku['tahun'],
            'stok' => (int) $buku['stok'],
            'kategori' => $buku['kategori'] ?? '',
        ]);
        $jumlah++;
    }

    $pdo->commit();
} catch (Throwable $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    throw $e;
}

echo "Migrasi selesai. Total data buku yang dipindahkan: {$jumlah}.";
