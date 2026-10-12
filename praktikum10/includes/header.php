<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$sudahLogin = isset($_SESSION['user_id']);
$base = '/DasarWeb/praktikum10/';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>SIMPUS-Mini</title>
    <link rel="stylesheet"
        href="<?= $base ?>assets/css/style.css?v=<?= filemtime(__DIR__ . '/../assets/css/style.css') ?>">
</head>

<body>
    <header>
        <button type="button" class="nav-toggle-label" id="nav-toggle-btn" aria-label="Buka navigasi" aria-expanded="false">
            ☰
        </button>
        <h1>SIMPUS-Mini</h1>
        <nav>
            <ul>
                <li><a href="<?= $base ?>index.php">Beranda</a></li>
                <li><a href="<?= $base ?>buku/list.php">Daftar Buku</a></li>
                <?php if ($sudahLogin): ?>
                    <li><a href="<?= $base ?>buku/tambah.php">Tambah Buku</a></li>
                    <li><a href="<?= $base ?>anggota/list.php">Daftar Anggota</a></li>
                    <li><a href="<?= $base ?>anggota/tambah.php">Tambah Anggota</a></li>
                    <!-- [New] Link ke pencatatan dan riwayat peminjaman. -->
                    <li><a href="<?= $base ?>peminjaman/list.php">Peminjaman</a></li>
                <?php endif; ?>
            </ul>
        </nav>
        <div class="auth-status">
            <?php if ($sudahLogin): ?>
                <span><?= htmlspecialchars($_SESSION['nama']) ?></span>
                <a href="<?= $base ?>auth/logout.php">Logout</a>
            <?php else: ?>
                <a href="<?= $base ?>auth/login.php">Login</a>
            <?php endif; ?>
        </div>
    </header>
    <main>
