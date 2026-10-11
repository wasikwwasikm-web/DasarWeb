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
        <h2>Login Petugas</h2>

        <?php if (isset($_SESSION['flash'])): ?>
            <div class="alert alert-<?= $_SESSION['flash']['type'] ?>">
                <?= htmlspecialchars($_SESSION['flash']['pesan']) ?>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <form method="post" action="proses_login.php">
            <p>Username: <br><input type="text" name="username" required></p>
            <p>Password: <br><input type="password" name="password" required></p>
            <button type="submit" class="btn">Masuk</button>
            <p class="register-link"><a href="register.php">Belum punya akun? Daftar di sini</a></p>
        </form>
    </section>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
