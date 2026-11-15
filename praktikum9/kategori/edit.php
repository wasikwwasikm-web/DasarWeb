<?php
// form Update kategori.
$page_title = "Edit Kategori Buku";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: list.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM kategori_buku WHERE id = :id");
$stmt->execute(['id' => $id]);
$kategori = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$kategori) {
    header('Location: list.php');
    exit;
}
?>
<section>
    <h2>Edit Kategori Buku</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo htmlspecialchars($flash['type'], ENT_QUOTES, 'UTF-8'); ?>">
            <?php echo htmlspecialchars($flash['pesan'], ENT_QUOTES, 'UTF-8'); ?>
        </p>
    <?php endif; ?>

    <form method="post" action="proses_edit.php">
        <input type="hidden" name="id" value="<?php echo (int) $kategori['id']; ?>">
        <p>
            <label for="nama">Nama Kategori</label><br>
            <input type="text" id="nama" name="nama" maxlength="50"
                value="<?php echo htmlspecialchars($kategori['nama'], ENT_QUOTES, 'UTF-8'); ?>" required>
        </p>
        <p>
            <label for="deskripsi">Deskripsi</label><br>
            <input type="text" id="deskripsi" name="deskripsi" maxlength="255"
                value="<?php echo htmlspecialchars($kategori['deskripsi'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
        </p>
        <p><button type="submit">Update</button></p>
    </form>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
