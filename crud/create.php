<?php
require_once '../models/HewanLaut.php';
$hewan = new HewanLaut();

$errors = [];
$data = [
    'nama' => '',
    'jenis' => '',
    'habitat' => '',
    'deskripsi' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'nama' => $_POST['nama'] ?? '',
        'jenis' => $_POST['jenis'] ?? '',
        'habitat' => $_POST['habitat'] ?? '',
        'deskripsi' => $_POST['deskripsi'] ?? ''
    ];

    $errors = $hewan->validate($data);
    
    // Handle file upload
    $gambar = null;
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $targetDir = __DIR__ . '/../assets/images/';
        $fileName = basename($_FILES['gambar']['name']);
        $targetFile = $targetDir . $fileName;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        
        // Check if image file is a actual image
        $check = getimagesize($_FILES['gambar']['tmp_name']);
        if ($check === false) {
            $errors[] = "File bukan gambar.";
        }
        
        // Check file size (max 2MB)
        if ($_FILES['gambar']['size'] > 2000000) {
            $errors[] = "Ukuran gambar terlalu besar (max 2MB).";
        }
        
        // Allow certain file formats
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowedTypes)) {
            $errors[] = "Hanya format JPG, JPEG, PNG & GIF yang diperbolehkan.";
        }
        
        if (empty($errors)) {
            if (!move_uploaded_file($_FILES['gambar']['tmp_name'], $targetFile)) {
                $errors[] = "Gagal mengupload gambar.";
            } else {
                $gambar = $fileName;
            }
        }
    }
    
    if (empty($errors)) {
        if ($hewan->create($data, $gambar)) {
            header("Location: ../animals.php?status=success&action=create");
            exit();
        } else {
            $errors[] = "Gagal menambahkan data.";
        }
    }
}

require __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/navigation.php';
?>

<div class="container">
    <h1 class="text-center my-4">Tambah Hewan Laut</h1>
    
    <div class="row justify-content-center">
        <div class="col-md-8">
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Hewan</label>
                    <input type="text" class="form-control" id="nama" name="nama" required 
                           value="<?= htmlspecialchars($data['nama']) ?>">
                </div>
                
                <div class="mb-3">
                    <label for="jenis" class="form-label">Jenis</label>
                    <select class="form-select" id="jenis" name="jenis" required>
                        <option value="">-- Pilih Jenis --</option>
                        <option value="Ikan" <?= $data['jenis'] === 'Ikan' ? 'selected' : '' ?>>Ikan</option>
                        <option value="Mamalia" <?= $data['jenis'] === 'Mamalia' ? 'selected' : '' ?>>Mamalia</option>
                        <option value="Moluska" <?= $data['jenis'] === 'Moluska' ? 'selected' : '' ?>>Moluska</option>
                        <option value="Krustasea" <?= $data['jenis'] === 'Krustasea' ? 'selected' : '' ?>>Krustasea</option>
                        <option value="Lainnya" <?= $data['jenis'] === 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="habitat" class="form-label">Habitat</label>
                    <input type="text" class="form-control" id="habitat" name="habitat" required 
                           value="<?= htmlspecialchars($data['habitat']) ?>">
                </div>
                
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4"><?= htmlspecialchars($data['deskripsi']) ?></textarea>
                </div>
                
                <div class="mb-3">
                    <label for="gambar" class="form-label">Gambar</label>
                    <input type="file" class="form-control" id="gambar" name="gambar">
                </div>
                
                <div class="text-center">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <a href="../animals.php" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Update file input label
document.getElementById('gambar').addEventListener('change', function(e) {
    const fileName = e.target.files[0] ? e.target.files[0].name : "Pilih gambar...";
    const label = e.target.nextElementSibling;
    if (label) {
        label.innerText = fileName;
    }
});
</script>

<?php
require __DIR__ . '/../includes/footer.php';
?>