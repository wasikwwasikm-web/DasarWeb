<?php
require_once __DIR__ . '/../includes/bootstrap.php';
$page_title = "Daftar Buku";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$daftarBuku = $_SESSION['buku']['items'];
?>

<section class="card shadow-sm">
    <div class="card-body">
    <h2 class="card-title">Daftar Buku</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo $flash['type']; ?>">
            <?php echo htmlspecialchars($flash['pesan']); ?>
        </p>
    <?php endif; ?>

    <div class="search-box">
        <label for="search-input">Cari Judul Buku</label>
        <input class="form-control" type="text" id="search-input" placeholder="Ketik judul buku...">
    </div>

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Pengarang</th>
                    <th>Tahun</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($daftarBuku)): ?>
                    <tr>
                        <td colspan="5">Belum ada data buku. Silakan tambah lewat menu "Tambah Buku".</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($daftarBuku as $index => $buku): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($buku['judul']); ?></td>
                            <td><?php echo htmlspecialchars($buku['pengarang']); ?></td>
                            <td><?php echo $buku['tahun']; ?></td>
                            <td><?php echo $buku['stok']; ?></td>
                            <td>
                                <!-- DIPERBAIKI: hapus dikirim ke server agar perubahan tersimpan di session. -->
                                <form class="form-hapus" method="post" action="proses_hapus.php" data-nama="<?php echo htmlspecialchars($buku['judul'], ENT_QUOTES, 'UTF-8'); ?>">
                                    <input type="hidden" name="index" value="<?php echo $index; ?>">
                                    <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
