<?php
require_once __DIR__ . '/../includes/bootstrap.php';
$page_title = "Daftar Anggota";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$daftarAnggota = $_SESSION['anggota'];
?>

<section class="card shadow-sm">
    <div class="card-body">
    <h2 class="card-title">Daftar Anggota</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo $flash['type']; ?>">
            <?php echo htmlspecialchars($flash['pesan']); ?>
        </p>
    <?php endif; ?>

    <div class="search-box">
        <label for="search-input">Cari Nama Anggota</label>
        <input class="form-control" type="text" id="search-input" placeholder="Ketik nama anggota...">
    </div>

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($daftarAnggota)): ?>
                    <tr>
                        <td colspan="5">Belum ada data anggota. Silakan tambah lewat menu "Tambah Anggota".</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($daftarAnggota as $index => $anggota): ?>
                        <tr>
                            <td>
                                <?php echo htmlspecialchars($anggota['nama'], ENT_QUOTES, 'UTF-8'); ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($anggota['email'], ENT_QUOTES, 'UTF-8'); ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($anggota['telepon'], ENT_QUOTES, 'UTF-8'); ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($anggota['alamat'], ENT_QUOTES, 'UTF-8'); ?>
                            </td>
                            <td>
                                <!-- DIPERBAIKI: hapus dikirim ke server agar perubahan tersimpan di session. -->
                                <form class="form-hapus" method="post" action="proses_hapus.php" data-nama="<?php echo htmlspecialchars($anggota['nama'], ENT_QUOTES, 'UTF-8'); ?>">
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
