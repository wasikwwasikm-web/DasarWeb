<?php
$page_title = "Tambah Anggota";
include __DIR__ . '/../includes/header.php';
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
<section>
    <h2>Tambah Anggota</h2>
    <?php if ($flash): ?>
        <p class="flash flash-<?php echo $flash['type']; ?>">
            <?php echo htmlspecialchars($flash['pesan']); ?>
        </p>
    <?php endif; ?>
    <form id="form-tambah" method="post" action="proses_tambah.php">
        <label for="nama">Nama</label>
        <input type="text" id="nama" name="nama" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

        <label for="telepon">Telepon</label>
        <input type="tel" id="telepon" name="telepon" pattern="[0-9+() -]+" title="Gunakan angka, spasi, tanda plus, tanda kurung, atau tanda hubung.">

        <label for="alamat">Alamat</label>
        <textarea id="alamat" name="alamat"></textarea>

        <button type="submit">Simpan</button>
    </form>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
