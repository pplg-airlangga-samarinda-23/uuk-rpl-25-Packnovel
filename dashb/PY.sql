-- Create database
CREATE DATABASE IF NOT EXISTS PY;
USE PY;

-- Table: users (admin and nurses)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'bidan') NOT NULL,
    employee_id VARCHAR(20) NOT NULL
);

-- Table: anak (children)
CREATE TABLE anak (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_anak VARCHAR(100) NOT NULL,
    jenis_kelamin ENUM('Laki-laki', 'Perempuan') NOT NULL,
    tanggal_lahir DATE NOT NULL,
    nama_ibu VARCHAR(100) NOT NULL
);

-- Table: imunisasi (child immunization records)
CREATE TABLE imunisasi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    anak_id INT NOT NULL,
    tanggal DATE NOT NULL,
    usia INT NOT NULL,
    imunisasi VARCHAR(100) NOT NULL,
    vitamin_a ENUM('Merah', 'Biru') DEFAULT NULL,
    keterangan TEXT,
    FOREIGN KEY (anak_id) REFERENCES anak(id) ON DELETE CASCADE
);

-- Table: penimbangan (child growth/weighing records)
CREATE TABLE penimbangan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    anak_id INT NOT NULL,
    tanggal DATE NOT NULL,
    usia INT NOT NULL,
    berat_badan DECIMAL(5,2) NOT NULL,
    tinggi_badan DECIMAL(5,2) NOT NULL,
    deteksi ENUM('Sesuai', 'Tidak Sesuai') NOT NULL,
    keterangan TEXT,
    FOREIGN KEY (anak_id) REFERENCES anak(id) ON DELETE CASCADE
);

-- Sample Admin and Nurse Users
INSERT INTO users (fullname, username, password, role, employee_id) VALUES
('Admin Posyandu', 'admin', MD5('admin123'), 'admin', 'EMP001'),
('Bidan Siti', 'bidan', MD5('bidan123'), 'bidan', 'EMP002');
