<?php
require_once __DIR__ . '/../config/database.php';

class User {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function register($username, $email, $password) {
    $conn = $this->db->getConnection();
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("sss", $username, $email, $password);
    return $stmt->execute();
}

    public function login($email, $password) {
    $conn = $this->db->getConnection();
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Jika password di database sudah di-hash, gunakan password_verify
        // if (password_verify($password, $row['password'])) {
        if ($row['password'] === $password) { // Jika belum di-hash
            return $row;
        }
    }
    return false;
}
}
?>