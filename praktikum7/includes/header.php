<?php
require_once __DIR__ . '/bootstrap.php';

$__jobsheetRoot = dirname(__DIR__);
$__scriptDir = dirname($_SERVER['SCRIPT_FILENAME']);
$__rel = ltrim(str_replace('\\', '/', substr($__scriptDir, strlen($__jobsheetRoot))), '/');
$base = $__rel === '' ? '' : str_repeat('../', substr_count($__rel, '/') + 1);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIMPUS-Mini<?php echo isset($page_title) ? ' | ' . $page_title : ''; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $base; ?>assets/css/style.css">
</head>

<body class="min-vh-100 d-flex flex-column">
    <header class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand fw-semibold" href="<?php echo $base; ?>index.php">SIMPUS-Mini</a>
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav-menu"
                aria-controls="nav-menu" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <nav id="nav-menu" class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="<?php echo $base; ?>index.php">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $base; ?>buku/list.php">Daftar Buku</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $base; ?>buku/tambah.php">Tambah Buku</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $base; ?>anggota/list.php">Daftar Anggota</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo $base; ?>anggota/tambah.php">Tambah Anggota</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main class="container py-4 flex-grow-1">
