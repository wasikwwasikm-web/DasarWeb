<?php
require_once __DIR__ . '/../includes/bootstrap.php';
$page_title = "Tambah Buku";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>

<section class="card shadow-sm">
    <div class="card-body">
    <h2 class="card-title">Tambah Buku</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo $flash['type']; ?>">
            <?php echo htmlspecialchars($flash['pesan']); ?>
        </p>
    <?php endif; ?>

    <form id="form-tambah" method="post" action="proses_tambah.php">
        <label class="form-label" for="judul">Judul</label>
        <input class="form-control" type="text" id="judul" name="judul" required>

        <label class="form-label" for="pengarang">Pengarang</label>
        <input class="form-control" type="text" id="pengarang" name="pengarang" required>

        <label class="form-label" for="tahun">Tahun</label>
        <!-- DIPERBAIKI: batas atas tahun mengikuti tahun berjalan. -->
        <input class="form-control" type="number" id="tahun" name="tahun" min="1900" max="<?php echo date('Y'); ?>" required>

        <label class="form-label" for="isbn">ISBN</label>
        <input class="form-control" type="text" id="isbn" name="isbn">

        <label class="form-label" for="stok">Stok</label>
        <input class="form-control" type="number" id="stok" name="stok" min="0" required>

        <label class="form-label" for="kategori">Kategori</label>
        <input class="form-control" type="text" id="kategori" name="kategori">

        <button class="btn btn-primary mt-3" type="submit">Simpan</button>
    </form>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
