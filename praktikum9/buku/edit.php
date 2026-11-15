<?php
$page_title = "Edit Buku";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
$kategoriBuku = $pdo->query("SELECT id, nama FROM kategori_buku ORDER BY nama")->fetchAll(PDO::FETCH_ASSOC);

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: list.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM buku WHERE id = :id");
$stmt->execute(['id' => $id]);
$buku = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$buku) {
    header('Location: list.php');
    exit;
}
?>
<section>
    <h2>Edit Buku</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
    <?php endif; ?>

    <!-- form update meminta konfirmasi sebelum dikirim. -->
    <form id="form-tambah" class="form-update" method="post" action="proses_edit.php">
        <input type="hidden" name="id" value="<?php echo $buku['id']; ?>">
        <p>
            <label for="judul">Judul</label><br>
            <input type="text" id="judul" name="judul" value="<?php echo $buku['judul']; ?>" required>
        </p>
        <p>
            <label for="pengarang">Pengarang</label><br>
            <input type="text" id="pengarang" name="pengarang" value="<?php echo $buku['pengarang']; ?>" required>
        </p>
        <p>
            <label for="tahun">Tahun Terbit</label><br>
            <input type="number" id="tahun" name="tahun" min="1900" max="2026" value="<?php echo $buku['tahun']; ?>"
                required>
        </p>
        <p>
            <label for="isbn">ISBN</label><br>
            <input type="text" id="isbn" name="isbn" value="<?php echo $buku['isbn']; ?>">
        </p>
        <p>
            <label for="stok">Stok</label><br>
            <input type="number" id="stok" name="stok" min="0" value="<?php echo $buku['stok']; ?>" required>
        </p>
        <p>
            <label for="kategori">Kategori</label><br>
            <select id="kategori" name="kategori">
                <!-- TAMBAHAN LATIHAN 7.4 #4: kategori dipilih dari tabel kategori_buku. -->
                <option value="">Pilih kategori</option>
                <?php foreach ($kategoriBuku as $kategori): ?>
                    <option value="<?php echo (int) $kategori['id']; ?>"
                        <?php echo (int) $buku['kategori_id'] === (int) $kategori['id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($kategori['nama'], ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <button type="submit">Update</button>
        </p>
    </form>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
