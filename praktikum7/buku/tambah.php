<?php
$page_title = "Tambah Buku";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

<section>
    <h2>Tambah Buku</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo $flash['type']; ?>">
            <?php echo htmlspecialchars($flash['pesan']); ?>
        </p>
    <?php endif; ?>

    <form id="form-tambah" method="post" action="proses_tambah.php">
        <label for="judul">Judul</label>
        <input type="text" id="judul" name="judul" required>

        <label for="pengarang">Pengarang</label>
        <input type="text" id="pengarang" name="pengarang" required>

        <label for="tahun">Tahun</label>
        <!-- DIPERBAIKI: batas atas tahun mengikuti tahun berjalan. -->
        <input type="number" id="tahun" name="tahun" min="1900" max="<?php echo date('Y'); ?>" required>

        <label for="isbn">ISBN</label>
        <input type="text" id="isbn" name="isbn">

        <label for="stok">Stok</label>
        <input type="number" id="stok" name="stok" min="0" required>

        <label for="kategori">Kategori</label>
        <input type="text" id="kategori" name="kategori">

        <button type="submit">Simpan</button>
    </form>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
