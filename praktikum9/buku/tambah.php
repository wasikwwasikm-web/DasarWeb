<?php
$page_title = "Tambah Buku";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
$kategoriBuku = $pdo->query("SELECT id, nama FROM kategori_buku ORDER BY nama")->fetchAll(PDO::FETCH_ASSOC);
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
            <input type="number" id="tahun" name="tahun" min="1900" max="2026" required>
        </p>
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
                <!-- TAMBAHAN LATIHAN 7.4 #4: pilihan berasal dari daftar kategori. -->
                <option value="">Pilih kategori</option>
                <?php foreach ($kategoriBuku as $kategori): ?>
                    <option value="<?php echo (int) $kategori['id']; ?>">
                        <?php echo htmlspecialchars($kategori['nama'], ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <button type="submit">Simpan</button>
        </p>
    </form>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
