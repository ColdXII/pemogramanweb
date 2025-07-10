-- Membuat database db_sekolah
CREATE DATABASE IF NOT EXISTS db_sekolah;

-- Menggunakan database db_sekolah
USE db_sekolah;

-- Membuat tabel tbl_siswa
CREATE TABLE IF NOT EXISTS tbl_siswa (
    id_siswa INT(11) PRIMARY KEY AUTO_INCREMENT,
    nisn VARCHAR(10) NOT NULL,
    nama_lengkap VARCHAR(50) NOT NULL,
    alamat TEXT NOT NULL
);

-- Menambahkan beberapa data contoh (opsional)

-- Menampilkan struktur tabel
DESCRIBE tbl_siswa;

-- Menampilkan data yang sudah dimasukkan
SELECT * FROM tbl_siswa; 