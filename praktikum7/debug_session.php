<?php
$page_title = "Debug Sesi";
include __DIR__ . '/includes/header.php';
?>

<section>
    <h2>Isi Sesi</h2>
    <p>Halaman sementara untuk memeriksa data yang tersimpan pada sesi PHP.</p>
    <pre class="session-debug"><?php echo htmlspecialchars(print_r($_SESSION, true), ENT_QUOTES, 'UTF-8'); ?></pre>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
