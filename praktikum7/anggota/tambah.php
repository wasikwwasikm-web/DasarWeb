<?php
require_once __DIR__ . '/../includes/bootstrap.php';
$page_title = "Tambah Anggota";
include __DIR__ . '/../includes/header.php';
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);
?>
<section class="card shadow-sm">
    <div class="card-body">
    <h2 class="card-title">Tambah Anggota</h2>
    <?php if ($flash): ?>
        <p class="flash flash-<?php echo $flash['type']; ?>">
            <?php echo htmlspecialchars($flash['pesan']); ?>
        </p>
    <?php endif; ?>
    <form id="form-tambah" method="post" action="proses_tambah.php">
        <label class="form-label" for="nama">Nama</label>
        <input class="form-control" type="text" id="nama" name="nama" required>

        <label class="form-label" for="email">Email</label>
        <input class="form-control" type="email" id="email" name="email" required>

        <label class="form-label" for="telepon">Telepon</label>
        <input class="form-control" type="text" id="telepon" name="telepon">

        <label class="form-label" for="alamat">Alamat</label>
        <textarea class="form-control" id="alamat" name="alamat"></textarea>

        <button class="btn btn-primary mt-3" type="submit">Simpan</button>
    </form>
    </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
