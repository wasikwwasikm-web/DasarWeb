<?php
require __DIR__ . '/../includes/koneksi.php';

$q = trim($_GET['q'] ?? '');

if ($q === '') {
    $stmt = $pdo->query("SELECT * FROM buku ORDER BY id DESC LIMIT 20");
} else {
    $stmt = $pdo->prepare("SELECT * FROM buku WHERE judul ILIKE :kw ORDER BY id DESC LIMIT 20");
    $stmt->execute(['kw' => '%' . $q . '%']);
}

header('Content-Type: application/json');
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
