<?php
// Konfigurasi koneksi database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "mahasiswa";

// Membuat koneksi
$conn = new mysqli($host, $user, $pass, $db);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari form
$nama    = $_POST['nama'];
$nim     = $_POST['nim'];
$email   = $_POST['email'];
$jurusan = $_POST['jurusan'];
$alamat  = $_POST['alamat'];
$pesan   = $_POST['pesan'];

// Query untuk menyimpan data
$sql = "INSERT INTO mahasiswa (nama, nim, email, jurusan, alamat, pesan) 
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $nama, $nim, $email, $jurusan, $alamat, $pesan);

if ($stmt->execute()) {
} else {
    echo "Terjadi kesalahan: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Berhasil Dikirim</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(135deg, #6FF7E8, #1F7EA1);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .success-box {
      background: white;
      padding: 40px 30px;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
      text-align: center;
      animation: fadeIn 0.8s ease-in;
      max-width: 400px;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    h2 {
      color: #4CAF50;
      margin-bottom: 20px;
    }

    p {
      color: #333;
      font-size: 16px;
      margin-bottom: 30px;
    }

    .back-button {
      padding: 12px 20px;
      background: linear-gradient(90deg, #018576, #1F7EA1);
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 16px;
      transition: background 0.3s ease;
      text-decoration: none;
      display: inline-block;
    }

    .back-button:hover {
      background: linear-gradient(90deg, #00B09B, #229FCC);
    }
  </style>
</head>
<body>

  <div class="success-box">
    <h2>✅ Data Berhasil Dikirim!</h2>
    <p>Terima kasih, <strong><?= htmlspecialchars($nama) ?></strong>. Kami telah menerima pesan Anda.</p>
    <a href="index.html" class="back-button">Kembali ke Form</a>
  </div>

</body>
</html>
