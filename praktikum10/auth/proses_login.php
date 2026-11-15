<?php
require_once __DIR__ . '/../includes/session.php';
start_app_session();
require __DIR__ . '/../includes/koneksi.php';

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$rememberMe = isset($_POST['remember_me']);
$attemptKey = hash('sha256', strtolower($username));
$maxAttempts = 5;
$lockoutDuration = 60;

//catat percobaan login gagal per username dalam sesi.
$attempt = $_SESSION['login_attempts'][$attemptKey] ?? ['count' => 0, 'locked_until' => 0];
if ($attempt['locked_until'] > time()) {
    $_SESSION['flash'] = [
        'type' => 'danger',
        'pesan' => 'Terlalu banyak percobaan login. Coba lagi dalam ' . ($attempt['locked_until'] - time()) . ' detik.'
    ];
    header('Location: login.php');
    exit;
}
if ($attempt['locked_until'] !== 0) {
    unset($_SESSION['login_attempts'][$attemptKey]);
    $attempt = ['count' => 0, 'locked_until' => 0];
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
$stmt->execute(['username' => $username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user['password'])) {
    // Soal Praktikum 10 No. 2: perbarui ID sesi setelah autentikasi berhasil.
    session_regenerate_id(true);
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['nama'] = $user['nama'];
    $_SESSION['role'] = $user['role'];
    unset($_SESSION['login_attempts'][$attemptKey]);

    // Soal Praktikum 10 No. 2: buat cookie sesi bertahan 30 hari hanya setelah login sukses.
    if ($rememberMe) {
        $cookieOptions = [
            'expires' => time() + (30 * 24 * 60 * 60),
            'path' => app_base_path(),
            'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
            'httponly' => true,
            'samesite' => 'Lax',
        ];
        setcookie(session_name(), session_id(), $cookieOptions);
    }

    header('Location: ../index.php');
    exit;
}

// beri peringatan setelah kegagalan ketiga dan kunci sementara setelah lima kali.
$attempt['count']++;
if ($attempt['count'] >= $maxAttempts) {
    $attempt['locked_until'] = time() + $lockoutDuration;
    $message = 'Terlalu banyak percobaan login. Akun ini dikunci sementara selama 60 detik.';
} elseif ($attempt['count'] >= 3) {
    $message = 'Peringatan: percobaan login gagal ' . $attempt['count'] . ' kali. Maksimal 5 percobaan.';
} else {
    $message = 'Username atau password salah.';
}
$_SESSION['login_attempts'][$attemptKey] = $attempt;
$_SESSION['flash'] = ['type' => 'danger', 'pesan' => $message];
header('Location: login.php');
exit;
