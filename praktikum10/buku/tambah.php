<?php
require __DIR__ . '/../includes/auth.php';
$page_title = "Tambah Buku";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
<section>
    <h2>Tambah Buku</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
    <?php endif; ?>

    <form id="form-tambah" method="post" action="proses_tambah.php">
        <p>
            <label for="judul">Judul</label><br>
            <input type="text" id="judul" name="judul" required>
        </p>
        <p>
            <label for="pengarang">Pengarang</label><br>
            <input type="text" id="pengarang" name="pengarang" required>
        </p>
        <p>
            <label for="tahun">Tahun Terbit</label><br>
            <input type="number" id="tahun" name="tahun" min="1900" max="<?php echo date('Y'); ?>" required>
        </p>

        <p>
            <label for="penerbit">Penerbit</label><br>
            <input type="text" id="penerbit" name="penerbit">
        </p>
        <p>
            <label for="bahasa">Bahasa</label><br>
            <select id="bahasa" name="bahasa">
                <option value="Indonesia">Indonesia</option>
                <option value="Inggris">Inggris</option>
                <option value="Arab">Arab</option>
            </select>
        </p>
        <p>
            <label for="deskripsi">Deskripsi</label><br>
            <textarea id="deskripsi" name="deskripsi" rows="4"></textarea>
        </p>

        <!-- [DIUBAH] ISBN dan kategori tersimpan ke kolom PostgreSQL serta tampil di daftar buku. -->
        <p>
            <label for="isbn">ISBN</label><br>
            <input type="text" id="isbn" name="isbn">
        </p>
        <p>
            <label for="stok">Stok</label><br>
            <input type="number" id="stok" name="stok" min="0" required>
        </p>
        <p>
            <label for="kategori">Kategori</label><br>
            <select id="kategori" name="kategori">
                <option value="fiksi">Fiksi</option>
                <option value="non-fiksi">Non-Fiksi</option>
                <option value="referensi">Referensi</option>
            </select>
        </p>
        <p>
            <button type="submit">Simpan</button>
        </p>
    </form>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
