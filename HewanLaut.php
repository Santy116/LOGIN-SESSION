<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HEWAN LAUT</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php
require_once 'config/database.php';
class HewanLaut {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function getAll() {
        $conn = $this->db->getConnection();
        $result = $conn->query("SELECT * FROM hewan_laut ORDER BY created_at DESC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getById($id) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("SELECT * FROM hewan_laut WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    
    public function create($data, $gambar) {
        $conn = $this->db->getConnection();
        $stmt = $conn->prepare("INSERT INTO hewan_laut (nama, jenis, habitat, deskripsi, gambar) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $data['nama'], $data['jenis'], $data['habitat'], $data['deskripsi'], $gambar);
        return $stmt->execute();
    }
    
    public function update($id, $data, $gambar = null) {
        $conn = $this->db->getConnection();
        
        if ($gambar) {
            $stmt = $conn->prepare("UPDATE hewan_laut SET nama = ?, jenis = ?, habitat = ?, deskripsi = ?, gambar = ? WHERE id = ?");
            $stmt->bind_param("sssssi", $data['nama'], $data['jenis'], $data['habitat'], $data['deskripsi'], $gambar, $id);
        } else {
            $stmt = $conn->prepare("UPDATE hewan_laut SET nama = ?, jenis = ?, habitat = ?, deskripsi = ? WHERE id = ?");
            $stmt->bind_param("ssssi", $data['nama'], $data['jenis'], $data['habitat'], $data['deskripsi'], $id);
        }
        
        return $stmt->execute();
    }
    
    public function delete($id) {
        $conn = (new Database())->getConnection();
        try {
            $stmt = $conn->prepare("DELETE FROM hewan_laut WHERE id = ?");
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Error deleting record: " . $e->getMessage());
            return false;
        }
    }
    
    public function validate($data) {
        $errors = [];
        
        if (empty($data['nama'])) {
            $errors[] = "Nama hewan harus diisi";
        } elseif (strlen($data['nama']) > 100) {
            $errors[] = "Nama hewan maksimal 100 karakter";
        }
        
        if (empty($data['jenis'])) {
            $errors[] = "Jenis hewan harus dipilih";
        }
        
        if (empty($data['habitat'])) {
            $errors[] = "Habitat hewan harus diisi";
        }
        
        return $errors;
    }
}
?>
</body>
</html>