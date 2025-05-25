<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: crud/login.php");
    exit();
}
?>
<?php
require_once 'models/HewanLaut.php';
$hewan = new HewanLaut();
$dataHewan = $hewan->getAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HALAMAN UTAMA: JENIS HEWAN</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    <?php include 'includes/navigation.php'; ?>
<div class="hero">
    <div class="hero-content">
        <h1>Selamat Datang di Portal Hewan Laut</h1>
        <p>Temukan berbagai macam hewan laut dan kelola data mereka dengan mudah</p>
        <a href="animals.php" class="btn btn-primary">Kelola Data Hewan</a>
    </div>
</div>
<!-- Tampilkan Daftar Hewan Laut -->
<div class="container mt-5">
    <h2 class="text-center mb-4">Daftar Hewan Laut</h2>
    <div class="row">
        <?php if (!empty($dataHewan)): ?>
            <?php foreach ($dataHewan as $h): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <?php if (!empty($h['gambar'])): ?>
                            <img src="assets/images/<?= htmlspecialchars($h['gambar']) ?>" alt="<?= htmlspecialchars($h['nama']) ?>" class="card-img-top">
                        <?php else: ?>
                            <img src="assets/images/no-image.jpg" alt="No Image" class="card-img-top">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($h['nama']) ?></h5>
                            <p class="card-text"><strong>Jenis:</strong> <?= htmlspecialchars($h['jenis']) ?></p>
                            <p class="card-text"><strong>Habitat:</strong> <?= htmlspecialchars($h['habitat']) ?></p>
                            <p class="card-text"><strong>Deskripsi:</strong> <?= htmlspecialchars($h['deskripsi']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <p>Tidak ada data hewan laut.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<div class="features">
    <div class="feature">
        <i class="fas fa-fish"></i>
        <h3>Jenis Hewan</h3>
        <p>Berbagai jenis hewan laut dari ikan hingga mamalia</p>
    </div>
    <div class="feature">
        <i class="fas fa-water"></i>
        <h3>Habitat</h3>
        <p>Informasi habitat tempat hewan-hewan ini hidup</p>
    </div>
    <div class="feature">
        <i class="fas fa-info-circle"></i>
        <h3>Deskripsi Lengkap</h3>
        <p>Deskripsi detail tentang setiap hewan laut</p>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>