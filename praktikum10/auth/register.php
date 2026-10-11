<?php
if (session_status() === PHP_SESSION_NONE)
    session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

require __DIR__ . '/../includes/header.php';
?>

<div class="login-page">
    <section class="login-card">
        <h2>Registrasi Petugas</h2>

        <?php if (isset($_SESSION['flash'])): ?>
            <div class="alert alert-<?= $_SESSION['flash']['type'] ?>">
                <?= htmlspecialchars($_SESSION['flash']['pesan']) ?>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <form method="post" action="proses_register.php">
            <p>Nama: <br><input type="text" name="nama" required></p>
            <p>Username: <br><input type="text" name="username" required></p>
            <p>Password: <br><input type="password" name="password" minlength="6" required></p>
            <button type="submit" class="btn">Daftar</button>
            <p class="register-link"><a href="login.php">Sudah punya akun? Login</a></p>
        </form>
    </section>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
