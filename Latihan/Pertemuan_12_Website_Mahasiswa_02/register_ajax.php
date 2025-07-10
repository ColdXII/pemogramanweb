<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'] ?? '';
    $alamat = $_POST['alamat'] ?? '';
    $jk = $_POST['jk'] ?? '';
    $tgl = $_POST['tanggal_lahir'] ?? '';

    if ($nama && $alamat && $jk && $tgl) {
        $query = "INSERT INTO siswa (nama, alamat, jenis_kelamin, tanggal_lahir)
                  VALUES ('$nama', '$alamat', '$jk', '$tgl')";
        if (mysqli_query($conn, $query)) {
            echo "success";
        } else {
            echo "error";
        }
    } else {
        echo "incomplete";
    }
}
?>