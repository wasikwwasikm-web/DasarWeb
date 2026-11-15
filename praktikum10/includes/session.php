<?php
// Soal Praktikum 10 No. 2: atur cookie sesi untuk fitur Ingat Saya.
function app_base_path(): string
{
    $appRoot = realpath(__DIR__ . '/..');
    $documentRoot = realpath($_SERVER['DOCUMENT_ROOT'] ?? '');

    if ($appRoot === false || $documentRoot === false) {
        return '/';
    }

    $appRoot = str_replace('\\', '/', $appRoot);
    $documentRoot = rtrim(str_replace('\\', '/', $documentRoot), '/');

    if (strcasecmp($appRoot, $documentRoot) === 0) {
        return '/';
    }

    $documentRootPrefix = $documentRoot . '/';
    if (strncasecmp($appRoot, $documentRootPrefix, strlen($documentRootPrefix)) === 0) {
        return '/' . trim(substr($appRoot, strlen($documentRootPrefix)), '/') . '/';
    }

    return '/';
}

function start_app_session(): void
{
    if (session_status() === PHP_SESSION_ACTIVE) {
        return;
    }

    $sessionLifetime = 30 * 24 * 60 * 60;
    ini_set('session.gc_maxlifetime', (string) $sessionLifetime);
    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => app_base_path(),
        'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);

    session_start();
}
