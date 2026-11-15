<?php
require_once __DIR__ . '/includes/session.php';
$page_title = "Beranda";
include __DIR__ . '/includes/header.php';
?>

<section>
    <h2>Selamat Datang di Sistem Perpustakaan Mini</h2>
    <p>Aplikasi sederhana untuk mengelola data buku dan anggota perpustakaan.</p>
</section>

<section>
    <h2>Ringkasan</h2>
    <article>
        <h3>Total Buku</h3>
        <p><?php echo count($_SESSION['buku']['items']); ?></p>
    </article>
    <article>
        <h3>Total Anggota</h3>
        <p><?php echo count($_SESSION['anggota']); ?></p>
    </article>
    <article>
        <h3>Sedang Dipinjam</h3>
        <p>0</p>
    </article>
</section>

<section>
    <h2>Pengelolaan Data Sesi</h2>
    <p>Hapus seluruh data buku dan anggota yang tersimpan di sesi ini.</p>
    <form action="reset_session.php" method="post" data-confirm-reset>
        <button type="submit" class="btn-reset">Reset Data</button>
    </form>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
