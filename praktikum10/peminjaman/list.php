<?php
require __DIR__ . '/../includes/auth.php';
$page_title = "Peminjaman";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$bukuTersedia = $pdo->query(
    "SELECT id, judul, stok FROM buku WHERE stok > 0 ORDER BY judul"
)->fetchAll(PDO::FETCH_ASSOC);
$anggotaList = $pdo->query(
    "SELECT id, nama, no_anggota FROM anggota ORDER BY nama"
)->fetchAll(PDO::FETCH_ASSOC);
$peminjamanList = $pdo->query(
    "SELECT p.id, b.judul, a.nama, a.no_anggota, p.tanggal_pinjam, p.tanggal_kembali
     FROM peminjaman p
     JOIN buku b ON b.id = p.buku_id
     JOIN anggota a ON a.id = p.anggota_id
     ORDER BY p.tanggal_kembali NULLS FIRST, p.tanggal_pinjam DESC, p.id DESC"
)->fetchAll(PDO::FETCH_ASSOC);
?>
<section>
    <h2>Peminjaman</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo htmlspecialchars($flash['type'], ENT_QUOTES, 'UTF-8'); ?>">
            <?php echo htmlspecialchars($flash['pesan'], ENT_QUOTES, 'UTF-8'); ?>
        </p>
    <?php endif; ?>

    <!-- [New] Form untuk mencatat transaksi peminjaman buku dan anggota. -->
    <h3>Catat Peminjaman</h3>
    <?php if (empty($anggotaList)): ?>
        <p>Tambahkan anggota terlebih dahulu sebelum mencatat peminjaman.</p>
    <?php elseif (empty($bukuTersedia)): ?>
        <p>Tidak ada buku dengan stok tersedia untuk dipinjam.</p>
    <?php else: ?>
        <form method="post" action="proses_pinjam.php">
            <p>
                <label for="anggota_id">Anggota</label>
                <select id="anggota_id" name="anggota_id" required>
                    <option value="">Pilih anggota</option>
                    <?php foreach ($anggotaList as $anggota): ?>
                        <option value="<?php echo (int) $anggota['id']; ?>">
                            <?php echo htmlspecialchars($anggota['nama'] . ' (' . $anggota['no_anggota'] . ')', ENT_QUOTES, 'UTF-8'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p>
                <label for="buku_id">Buku</label>
                <select id="buku_id" name="buku_id" required>
                    <option value="">Pilih buku</option>
                    <?php foreach ($bukuTersedia as $buku): ?>
                        <option value="<?php echo (int) $buku['id']; ?>">
                            <?php echo htmlspecialchars($buku['judul'] . ' (stok: ' . $buku['stok'] . ')', ENT_QUOTES, 'UTF-8'); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </p>
            <p>
                <button type="submit">Catat Peminjaman</button>
            </p>
        </form>
    <?php endif; ?>
</section>

<section>
    <!-- [New] Riwayat transaksi dan aksi untuk mencatat pengembalian. -->
    <h2>Riwayat Peminjaman</h2>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Buku</th>
                    <th>Anggota</th>
                    <th>Tanggal Pinjam</th>
                    <th>Status / Tanggal Kembali</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($peminjamanList)): ?>
                    <tr><td colspan="5">Belum ada transaksi peminjaman.</td></tr>
                <?php else: ?>
                    <?php foreach ($peminjamanList as $peminjaman): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($peminjaman['judul'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($peminjaman['nama'] . ' (' . $peminjaman['no_anggota'] . ')', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($peminjaman['tanggal_pinjam'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <?php if ($peminjaman['tanggal_kembali'] === null): ?>
                                    Sedang dipinjam
                                <?php else: ?>
                                    Dikembalikan <?php echo htmlspecialchars($peminjaman['tanggal_kembali'], ENT_QUOTES, 'UTF-8'); ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($peminjaman['tanggal_kembali'] === null): ?>
                                    <form method="post" action="proses_kembali.php">
                                        <input type="hidden" name="id" value="<?php echo (int) $peminjaman['id']; ?>">
                                        <button type="submit">Tandai Dikembalikan</button>
                                    </form>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
