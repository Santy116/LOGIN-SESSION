<?php
require_once '../models/HewanLaut.php';
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $hewan = new HewanLaut();
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
    
    if ($id === false || $id <= 0) {
        header("Location: ../animals.php?status=error&action=invalid_id");
        exit();
    }

    // Dapatkan data hewan untuk menghapus gambar terkait
    $data = $hewan->getById($id);
    if ($data && !empty($data['gambar'])) {
        $gambarPath = "../assets/images/" . $data['gambar'];
        if (file_exists($gambarPath)) {
            unlink($gambarPath);
        }
    }

    if ($hewan->delete($id)) {
        header("Location: ../animals.php?status=success&action=delete");
    } else {
        header("Location: ../animals.php?status=error&action=delete");
    }
    exit();
} else {
    header("Location: ../animals.php");
    exit();
}
?>