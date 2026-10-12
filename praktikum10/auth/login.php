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
            <p>
                <label for="login-password">Password</label>
                <span class="password-field">
                    <input type="password" id="login-password" name="password" required>
                    <button type="button" class="password-toggle" aria-label="Tampilkan password" aria-pressed="false">
                        <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                            <path d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12Z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                            <path class="eye-slash" d="M3 3 21 21"></path>
                        </svg>
                    </button>
                </span>
            </p>
            <button type="submit" class="btn">Masuk</button>
            <p class="register-link"><a href="register.php">Belum punya akun? Daftar di sini</a></p>
        </form>
    </section>
</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>
