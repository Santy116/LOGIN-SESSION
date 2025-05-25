<footer class="bg-dark text-white py-4 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5><i class="fas fa-fish"></i> Portal Hewan Laut</h5>
                <p>Portal informasi tentang berbagai jenis hewan laut di seluruh dunia.</p>
            </div>
            <div class="col-md-4">
                <h5>Menu</h5>
                <ul class="list-unstyled">
                    <li><a href="/PWD-Praktikum/Tugas-Pertemuan7dan8/index.php" class="text-white">Beranda</a></li>
                    <li><a href="/PWD-Praktikum/Tugas-Pertemuan7dan8/animals.php" class="text-white">Data Hewan</a></li>
                    <li><a href="/PWD-Praktikum/Tugas-Pertemuan7dan8/crud/create.php" class="text-white">Tambah Hewan</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5>Kontak</h5>
                <ul class="list-unstyled">
                    <li><i class="fas fa-envelope"></i> info@hewanlaut.com</li>
                    <li><i class="fas fa-phone"></i> +62 123 4567 890</li>
                    <li><i class="fas fa-map-marker-alt"></i> Jl. Laut No. 123, Jakarta</li>
                </ul>
            </div>
        </div>
        <hr class="bg-light">
        <div class="text-center">
            <p class="mb-0">&copy; <?php echo date('Y'); ?> Portal Hewan Laut. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});
function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
        window.location.href = 'delete.php?id=' + id;
    }
}
</script>