<?php
require __DIR__ . '/../includes/koneksi.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: list.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM buku WHERE id = :id");
$stmt->execute(['id' => $id]);
$buku = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$buku) {
    http_response_code(404);
}

$page_title = $buku ? 'Detail Buku' : 'Buku Tidak Ditemukan';
include __DIR__ . '/../includes/header.php';
?>
<section>
    <?php if ($buku): ?>
        <h2><?php echo htmlspecialchars($buku['judul'], ENT_QUOTES, 'UTF-8'); ?></h2>
        <dl class="book-details">
            <dt>Pengarang</dt>
            <dd><?php echo htmlspecialchars($buku['pengarang'], ENT_QUOTES, 'UTF-8'); ?></dd>

            <dt>Tahun Terbit</dt>
            <dd><?php echo htmlspecialchars((string) $buku['tahun'], ENT_QUOTES, 'UTF-8'); ?></dd>

            <dt>Penerbit</dt>
            <dd><?php echo htmlspecialchars($buku['penerbit'] ?? '', ENT_QUOTES, 'UTF-8'); ?></dd>

            <dt>Bahasa</dt>
            <dd><?php echo htmlspecialchars($buku['bahasa'] ?? '', ENT_QUOTES, 'UTF-8'); ?></dd>

            <dt>ISBN</dt>
            <dd><?php echo htmlspecialchars($buku['isbn'] ?? '', ENT_QUOTES, 'UTF-8'); ?></dd>

            <dt>Kategori</dt>
            <dd><?php echo htmlspecialchars($buku['kategori'] ?? '', ENT_QUOTES, 'UTF-8'); ?></dd>

            <dt>Stok</dt>
            <dd><?php echo htmlspecialchars((string) $buku['stok'], ENT_QUOTES, 'UTF-8'); ?></dd>

            <dt>Deskripsi</dt>
            <dd><?php echo nl2br(htmlspecialchars($buku['deskripsi'] ?? '', ENT_QUOTES, 'UTF-8')); ?></dd>
        </dl>
    <?php else: ?>
        <h2>Buku tidak ditemukan</h2>
        <p>Data buku yang diminta tidak tersedia.</p>
    <?php endif; ?>
    <p><a href="list.php">Kembali ke daftar buku</a></p>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
