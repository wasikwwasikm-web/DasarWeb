<?php
// form Create kategori.
$page_title = "Tambah Kategori Buku";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
<section>
    <h2>Tambah Kategori Buku</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo htmlspecialchars($flash['type'], ENT_QUOTES, 'UTF-8'); ?>">
            <?php echo htmlspecialchars($flash['pesan'], ENT_QUOTES, 'UTF-8'); ?>
        </p>
    <?php endif; ?>

    <form method="post" action="proses_tambah.php">
        <p>
            <label for="nama">Nama Kategori</label><br>
            <input type="text" id="nama" name="nama" maxlength="50" required>
        </p>
        <p>
            <label for="deskripsi">Deskripsi</label><br>
            <input type="text" id="deskripsi" name="deskripsi" maxlength="255">
        </p>
        <p><button type="submit">Simpan</button></p>
    </form>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
