CREATE TABLE hewan_laut (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nama VARCHAR(100) NOT NULL,
    jenis VARCHAR(100) NOT NULL,
    habitat VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    gambar VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO hewan_laut (nama, jenis, habitat, deskripsi) VALUES
('Hiu Paus', 'Ikan', 'Laut Tropis', 'Hiu terbesar di dunia yang bersifat filter feeder'),
('Penyu Hijau', 'Reptil', 'Laut Tropis', 'Penyu laut yang sering ditemukan di perairan dangkal'),
('Gurita Pasifik', 'Moluska', 'Laut Dalam', 'Gurita besar yang dikenal sangat cerdas');