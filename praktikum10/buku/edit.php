<?php
require __DIR__ . '/../includes/auth.php';
$page_title = "Edit Buku";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

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

    <form id="form-tambah" method="post" action="proses_edit.php">
        <input type="hidden" name="id" value="<?php echo $buku['id']; ?>">
        <p>
            <label for="judul">Judul</label><br>
            <input type="text" id="judul" name="judul"
                value="<?php echo htmlspecialchars($buku['judul'], ENT_QUOTES, 'UTF-8'); ?>" required>
        </p>
        <p>
            <label for="pengarang">Pengarang</label><br>
            <input type="text" id="pengarang" name="pengarang"
                value="<?php echo htmlspecialchars($buku['pengarang'], ENT_QUOTES, 'UTF-8'); ?>" required>
        </p>
        <p>
            <label for="tahun">Tahun Terbit</label><br>
            <input type="number" id="tahun" name="tahun" min="1900" max="<?php echo date('Y'); ?>" value="<?php echo $buku['tahun']; ?>"
                required>
        </p>
        <p>
            <label for="penerbit">Penerbit</label><br>
            <input type="text" id="penerbit" name="penerbit"
                value="<?php echo htmlspecialchars($buku['penerbit'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
        </p>
        <p>
            <label for="bahasa">Bahasa</label><br>
            <select id="bahasa" name="bahasa">
                <?php foreach (['Indonesia', 'Inggris', 'Arab'] as $b): ?>
                    <option value="<?php echo htmlspecialchars($b, ENT_QUOTES, 'UTF-8'); ?>" <?php echo ($buku['bahasa'] ?? '') === $b ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($b, ENT_QUOTES, 'UTF-8'); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label for="deskripsi">Deskripsi</label><br>
            <textarea id="deskripsi" name="deskripsi"
                rows="4"><?php echo htmlspecialchars($buku['deskripsi'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
        </p>
        <p>
            <label for="isbn">ISBN</label><br>
            <input type="text" id="isbn" name="isbn"
                value="<?php echo htmlspecialchars($buku['isbn'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
        </p>
        <p>
            <label for="stok">Stok</label><br>
            <input type="number" id="stok" name="stok" min="0" value="<?php echo $buku['stok']; ?>" required>
        </p>
        <p>
            <label for="kategori">Kategori</label><br>
            <select id="kategori" name="kategori">
                <?php foreach (['fiksi' => 'Fiksi', 'non-fiksi' => 'Non-Fiksi', 'referensi' => 'Referensi'] as $value => $label): ?>
                    <option value="<?php echo htmlspecialchars($value, ENT_QUOTES, 'UTF-8'); ?>" <?php echo ($buku['kategori'] ?? '') === $value ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?>
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
