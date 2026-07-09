create database db_klinik;
USE db_klinik;

-- ===========================
-- Tabel Users
-- ===========================
CREATE TABLE users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','dokter','pasien') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ===========================
-- Tabel Dokter
-- ===========================
CREATE TABLE dokter (
    id_dokter INT AUTO_INCREMENT PRIMARY KEY,
    nama_dokter VARCHAR(100) NOT NULL,
    spesialis VARCHAR(100) NOT NULL,
    no_str VARCHAR(50),
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ===========================
-- Tabel Jadwal Dokter
-- ===========================
CREATE TABLE jadwal (
    id_jadwal INT AUTO_INCREMENT PRIMARY KEY,
    id_dokter INT,
    hari VARCHAR(20),
    jam_mulai TIME,
    jam_selesai TIME,
    FOREIGN KEY(id_dokter) REFERENCES dokter(id_dokter)
        ON DELETE CASCADE
);

-- ===========================
-- Tabel Reservasi
-- ===========================
CREATE TABLE reservasi (
    id_reservasi INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT,
    id_dokter INT,
    tanggal DATE,
    keluhan TEXT,
    status ENUM('Menunggu','Diterima','Selesai') DEFAULT 'Menunggu',

    FOREIGN KEY(id_user)
    REFERENCES users(id_user)
    ON DELETE CASCADE,

    FOREIGN KEY(id_dokter)
    REFERENCES dokter(id_dokter)
    ON DELETE CASCADE
);

-- ===========================
-- Tabel Rekam Medis
-- ===========================
CREATE TABLE rekam_medis (
    id_rekam INT AUTO_INCREMENT PRIMARY KEY,
    id_reservasi INT,
    diagnosa TEXT,
    tindakan TEXT,
    resep TEXT,

    FOREIGN KEY(id_reservasi)
    REFERENCES reservasi(id_reservasi)
    ON DELETE CASCADE
);

CREATE TABLE pasien (
    id_pasien INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    tanggal_lahir DATE NOT NULL,
    jenis_kelamin ENUM('L', 'P') NOT NULL,
    alamat TEXT NOT NULL,
    no_hp VARCHAR(15) NOT NULL,
    FOREIGN KEY (id_user) REFERENCES users(id_user) ON DELETE CASCADE
);

INSERT INTO dokter
(nama_dokter,spesialis,no_str,email)
VALUES
('dr. Andi Saputra',
'Dokter Umum',
'STR001',
'dokter@klinik.com');

INSERT INTO jadwal
(id_dokter,hari,jam_mulai,jam_selesai)
VALUES
(1,'Senin','08:00','12:00'),
(1,'Rabu','08:00','12:00'),
(1,'Jumat','13:00','17:00');

INSERT INTO users(nama,email,password,role)
VALUES
('Administrator',
'admin@klinik.com',
'$2y$10$5Xg8Qj2s5n2gx0mK4SKQ3eQO8A7bz8PvQjJQ6P6c8J8M0jP1R8P9m',
'admin');
select *from dokter ;

UPDATE users
SET password = 'admin123'
WHERE role = 'admin';

SET SQL_SAFE_UPDATES = 0;
UPDATE users
SET password = 'admin123'
WHERE role = 'admin';

SELECT* FROM users;
SELECT* FROM dokter;
DELETE FROM users
WHERE email='guspuja786@gmail.com';

INSERT INTO users
(nama,email,password,role)
VALUES
(
'Administrator',
'admin@klinik.com',
'$2y$10$DRHkMuur92DOdkIY9KEp1.vBPQokxrLEjZE4gwKu3ToqfvkHpOq7S',
'admin'
);
update users
set password = '$2y$10$DRHkMuur92DOdkIY9KEp1.vBPQokxrLEjZE4gwKu3ToqfvkHpOq7S'
where nama='Administrator';

CREATE TABLE pasien (
    id_pasien INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    tanggal_lahir DATE,
    jenis_kelamin ENUM('L','P'),
    alamat TEXT,
    no_hp VARCHAR(20),

    FOREIGN KEY (id_user)
    REFERENCES users(id_user)
    ON DELETE CASCADE
);

SELECT * FROM reservasi;
SELECT id_user, nama, email, role
FROM users;

SET SQL_SAFE_UPDATES = 0;

UPDATE users
SET role = 'admin'
WHERE email = 'adminbaru@klinik.com';

UPDATE users 
SET password = '$2y$10$mC7p71vUvWpxNZZpMvP6e.q2vOPhGOmbQZ9zJg4bK7fBmxvPZ9lOi' 
WHERE email = 'admin@klinik.com';

SET SQL_SAFE_UPDATES = 0;

UPDATE users 
SET role = 'dokter' 
WHERE email = 'dokterstrange@linik.com';

UPDATE users 
SET role = 'dokter' 
WHERE email = 'guspuja786@gmail.com';

ALTER TABLE reservasi MODIFY COLUMN status ENUM('Menunggu', 'Diterima', 'Ditolak', 'Selesai') DEFAULT 'Menunggu';

