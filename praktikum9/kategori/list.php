<?php
// Read, pencarian, dan pagination kategori.
$page_title = "Daftar Kategori Buku";
include __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/koneksi.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$perPage = 10;
$page = max(1, (int) ($_GET['page'] ?? 1));
$keyword = trim($_GET['q'] ?? '');
$offset = ($page - 1) * $perPage;

if ($keyword !== '') {
    $kataKunci = '%' . $keyword . '%';
    $count = $pdo->prepare(
        "SELECT COUNT(*) FROM kategori_buku WHERE nama ILIKE :nama_kw OR deskripsi ILIKE :deskripsi_kw"
    );
    $count->execute(['nama_kw' => $kataKunci, 'deskripsi_kw' => $kataKunci]);
    $totalRows = (int) $count->fetchColumn();

    $stmt = $pdo->prepare(
        "SELECT * FROM kategori_buku WHERE nama ILIKE :nama_kw OR deskripsi ILIKE :deskripsi_kw
         ORDER BY id DESC LIMIT :limit OFFSET :offset"
    );
    $stmt->bindValue('nama_kw', $kataKunci);
    $stmt->bindValue('deskripsi_kw', $kataKunci);
} else {
    $totalRows = (int) $pdo->query("SELECT COUNT(*) FROM kategori_buku")->fetchColumn();
    $stmt = $pdo->prepare("SELECT * FROM kategori_buku ORDER BY id DESC LIMIT :limit OFFSET :offset");
}
$stmt->bindValue('limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue('offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$kategoriBuku = $stmt->fetchAll(PDO::FETCH_ASSOC);
$totalPages = max(1, (int) ceil($totalRows / $perPage));
?>
<section>
    <h2>Daftar Kategori Buku</h2>

    <?php if ($flash): ?>
        <p class="flash flash-<?php echo htmlspecialchars($flash['type'], ENT_QUOTES, 'UTF-8'); ?>">
            <?php echo htmlspecialchars($flash['pesan'], ENT_QUOTES, 'UTF-8'); ?>
        </p>
    <?php endif; ?>

    <div class="search-box">
        <form method="get" action="list.php">
            <span>
                <label for="search-input">Cari Kategori</label><br>
                <input type="text" id="search-input" name="q"
                    value="<?php echo htmlspecialchars($keyword, ENT_QUOTES, 'UTF-8'); ?>"
                    placeholder="Ketik nama atau deskripsi kategori...">
            </span>
            <button type="submit">Cari</button>
        </form>
    </div>

    <p><a href="tambah.php">Tambah Kategori</a></p>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!$kategoriBuku): ?>
                    <tr>
                        <td colspan="3">Belum ada kategori buku.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($kategoriBuku as $kategori): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($kategori['nama'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($kategori['deskripsi'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <a class="btn-edit" href="edit.php?id=<?php echo (int) $kategori['id']; ?>">Edit</a>
                                <form class="form-hapus" method="post" action="hapus.php">
                                    <input type="hidden" name="id" value="<?php echo (int) $kategori['id']; ?>">
                                    <button type="submit" class="btn-hapus">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <nav class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="list.php?page=<?php echo $i; ?><?php echo $keyword !== '' ? '&q=' . urlencode($keyword) : ''; ?>"
                class="<?php echo $i === $page ? 'active' : ''; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>
    </nav>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
