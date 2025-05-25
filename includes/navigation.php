<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand" href="/PWD-Praktikum/Tugas_P9/index.php">
            <i class="fas fa-fish"></i> Portal Hewan Laut
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/PWD-Praktikum/Tugas_P9/index.php">
                        <i class="fas fa-home"></i> Beranda
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/PWD-Praktikum/Tugas_P9/index.php">
                        <i class="fas fa-list"></i> Data Hewan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/PWD-Praktikum/Tugas_P9/crud/create.php">
                        <i class="fas fa-plus-circle"></i> Tambah Hewan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-info-circle"></i> Tentang
                    </a>
                </li>
                <?php if (isset($_SESSION['user'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/PWD-Praktikum/Tugas_P9/crud/logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/PWD-Praktikum/Tugas_P9/crud/login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/PWD-Praktikum/Tugas_P9/crud/register.php">Register</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>