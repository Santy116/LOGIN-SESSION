<?php
require_once '../models/HewanLaut.php';
$hewan = new HewanLaut();

if (!isset($_GET['id'])) {
    header("Location: ../animals.php?status=error&action=invalid_id");
    exit();
}
$id = $_GET['id'];
$currentData = $hewan->getById($id);

if (!$currentData) {
    header("Location: ../animals.php?status=error&action=notfound");
    exit();
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'nama' => $_POST['nama'],
        'jenis' => $_POST['jenis'],
        'habitat' => $_POST['habitat'],
        'deskripsi' => $_POST['deskripsi']
    ];

    $errors = $hewan->validate($data);
    
    // Handle file upload
    $gambar = null;
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "../assets/images/";
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
            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $targetFile)) {
                $gambar = $fileName;
                // Delete old image if exists
                if (!empty($currentData['gambar'])) {
                    @unlink("../assets/images/" . $currentData['gambar']);
                }
            } else {
                $errors[] = "Gagal mengupload gambar.";
            }
        }
    }
    
    if (empty($errors)) {
        if ($hewan->update($id, $data, $gambar)) {
            header("Location: ../animals.php?status=success&action=update");
            exit();
        } else {
            $errors[] = "Gagal memperbarui data.";
        }
    }
}
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navigation.php'; ?>

<div class="container">
    <h1 class="text-center my-4">Edit Hewan Laut</h1>
    
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
                <div class="form-group">
                    <label for="nama">Nama Hewan</label>
                    <input type="text" class="form-control" id="nama" name="nama" required 
                           value="<?= isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : htmlspecialchars($currentData['nama']) ?>">
                </div>
                
                <div class="form-group">
                    <label for="jenis">Jenis</label>
                    <select class="form-control" id="jenis" name="jenis" required>
                        <option value="">-- Pilih Jenis --</option>
                        <option value="Ikan" <?= ((isset($_POST['jenis']) && $_POST['jenis'] === 'Ikan') || $currentData['jenis'] === 'Ikan') ? 'selected' : '' ?>>Ikan</option>
                        <option value="Mamalia" <?= ((isset($_POST['jenis']) && $_POST['jenis'] === 'Mamalia') || $currentData['jenis'] === 'Mamalia') ? 'selected' : '' ?>>Mamalia</option>
                        <option value="Moluska" <?= ((isset($_POST['jenis']) && $_POST['jenis'] === 'Moluska') || $currentData['jenis'] === 'Moluska') ? 'selected' : '' ?>>Moluska</option>
                        <option value="Krusta" <?= ((isset($_POST['jenis']) && $_POST['jenis'] === 'Krusta') || $currentData['jenis'] === 'Krusta') ? 'selected' : '' ?>>Krusta</option>
                        <option value="Lainnya" <?= ((isset($_POST['jenis']) && $_POST['jenis'] === 'Lainnya') || $currentData['jenis'] === 'Lainnya') ? 'selected' : '' ?>>Lainnya</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="habitat">Habitat</label>
                    <input type="text" class="form-control" id="habitat" name="habitat" required 
                           value="<?= isset($_POST['habitat']) ? htmlspecialchars($_POST['habitat']) : htmlspecialchars($currentData['habitat']) ?>">
                </div>
                
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4"><?= isset($_POST['deskripsi']) ? htmlspecialchars($_POST['deskripsi']) : htmlspecialchars($currentData['deskripsi']) ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="gambar">Gambar</label>
                    <?php if (!empty($currentData['gambar'])): ?>
                        <div class="mb-2">
                            <img src="../assets/images/<?= htmlspecialchars($currentData['gambar']) ?>" alt="Current Image" class="img-thumbnail" style="max-width: 200px;">
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" name="hapus_gambar" id="hapus_gambar" value="1">
                                <label class="form-check-label" for="hapus_gambar">
                                    Hapus gambar ini
                                </label>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="gambar" name="gambar">
                        <label class="custom-file-label" for="gambar">Pilih gambar baru...</label>
                    </div>
                </div>
                
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary mr-2">
                        <i class="fas fa-save"></i> Simpan Perubahan
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
document.querySelector('.custom-file-input').addEventListener('change', function(e) {
    var fileName = document.getElementById("gambar").files[0]?.name || "Pilih gambar baru...";
    var nextSibling = e.target.nextElementSibling;
    nextSibling.innerText = fileName;
});
</script>

<?php include '../includes/footer.php'; ?>