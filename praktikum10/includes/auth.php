<?php
require_once __DIR__ . '/session.php';
start_app_session();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}

// Soal Praktikum 10 No. 1: pemeriksaan role dilakukan di server.
function require_role(string $role): void
{
    if (($_SESSION['role'] ?? null) !== $role) {
        http_response_code(403);
        exit('Akses ditolak. Anda tidak memiliki hak untuk membuka halaman ini.');
    }
}
