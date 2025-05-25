<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
require_once 'models/HewanLaut.php';
$hewan = new HewanLaut();
$dataHewan = $hewan->getAll();

// Handle delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if ($hewan->delete($id)) {
        header("Location: animals.php?status=success&action=delete");
        exit();
    } else {
        header("Location: animals.php?status=error&action=delete");
        exit();
    }
}
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/navigation.php'; ?>

<div class="container">
    <h1 class="text-center my-4">Data Hewan Laut</h1>
    
    <?php if (isset($_GET['status'])): ?>
        <div class="alert alert-<?= $_GET['status'] === 'success' ? 'success' : 'danger' ?>">
            <?php
            $action = $_GET['action'] ?? '';
            $messages = [
                'create' => 'Data berhasil ditambahkan!',
                'update' => 'Data berhasil diperbarui!',
                'delete' => 'Data berhasil dihapus!'
            ];
            echo $messages[$action] ?? ($_GET['status'] === 'success' ? 'Operasi berhasil!' : 'Terjadi kesalahan!');
            ?>
        </div>
    <?php endif; ?>
    
    <div class="text-right mb-3">
        <a href="crud/create.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Hewan
        </a>
    </div>
    
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
    <tr>
        <th>No</th>
        <th>Gambar</th>
        <th>Nama</th>
        <th>Jenis</th>
        <th>Habitat</th>
        <th>Deskripsi</th> <!-- Tambahkan ini -->
        <th>Aksi</th>
    </tr>
</thead>
<tbody>
    <?php if (empty($dataHewan)): ?>
        <tr>
            <td colspan="7" class="text-center">Tidak ada data hewan laut</td>
        </tr>
    <?php else: ?>
        <?php foreach ($dataHewan as $index => $data): ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td>
                    <?php if (!empty($data['gambar'])): ?>
                        <img src="assets/images/<?= htmlspecialchars($data['gambar']) ?>" alt="<?= htmlspecialchars($data['nama']) ?>" class="img-thumbnail" style="width: 100px;">
                    <?php else: ?>
                        <span class="text-muted">No image</span>
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($data['nama']) ?></td>
                <td><?= htmlspecialchars($data['jenis']) ?></td>
                <td><?= htmlspecialchars($data['habitat']) ?></td>
                <td><?= htmlspecialchars($data['deskripsi']) ?></td> <!-- Tambahkan ini -->
                <td>
                    <a href="crud/edit.php?id=<?= $data['id'] ?>" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <button class="btn btn-sm btn-danger delete-btn" data-id="<?= $data['id'] ?>">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</tbody>
        </table>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus data ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <a href="#" class="btn btn-danger" id="confirmDelete">Hapus</a>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

 <script>
    $(document).ready(function() {
        // Delete confirmation modal
        $('.delete-btn').click(function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            $('#deleteModal').modal('show');
            $('#confirmDelete').attr('href', 'crud/delete.php?id=' + id);
        });
    });
</script>
</body>
</html>