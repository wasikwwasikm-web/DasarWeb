<?php
require_once __DIR__ . '/includes/bootstrap.php';
$page_title = "Beranda";
include __DIR__ . '/includes/header.php';
?>

<section class="card shadow-sm">
    <div class="card-body">
        <h2 class="card-title">Selamat Datang di Sistem Perpustakaan Mini</h2>
        <p class="card-text">Gunakan menu di atas untuk mengelola data buku dan anggota.</p>

        <?php
        $totalBuku = count($_SESSION['buku']['items'] ?? []);
        $totalAnggota = count($_SESSION['anggota'] ?? []);
        ?>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">Total Buku: <?php echo $totalBuku; ?></li>
            <li class="list-group-item">Total Anggota: <?php echo $totalAnggota; ?></li>
        </ul>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
