<?php
session_start();
include 'config.php';

// Cek login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_name = $_SESSION['full_name'];
$user_role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Pendaftaran Sekolah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .sidebar {
            background: white;
            min-height: calc(100vh - 76px);
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        .sidebar .nav-link {
            color: #495057;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e9ecef;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover {
            background-color: #f8f9fa;
            color: #667eea;
            transform: translateX(5px);
        }
        .sidebar .nav-link.active {
            background-color: #667eea;
            color: white;
        }
        .main-content {
            padding: 2rem;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .table-container {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        .btn-action {
            border-radius: 20px;
            padding: 0.25rem 0.75rem;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-graduation-cap"></i> Sistem Pendaftaran Sekolah
            </a>
            <div class="navbar-nav ms-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user"></i> <?= $user_name ?>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="profile.php"><i class="fas fa-user-edit"></i> Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0">
                <div class="sidebar">
                    <nav class="nav flex-column">
                        <a class="nav-link active" href="dashboard.php">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                        <a class="nav-link" href="siswa.php">
                            <i class="fas fa-users"></i> Data Siswa
                        </a>
                        <a class="nav-link" href="tambah.php">
                            <i class="fas fa-user-plus"></i> Tambah Siswa
                        </a>
                        <?php if ($user_role == 'admin'): ?>
                        <a class="nav-link" href="users.php">
                            <i class="fas fa-user-cog"></i> Kelola User
                        </a>
                        <?php endif; ?>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10">
                <div class="main-content">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2>Dashboard</h2>
                        <small class="text-muted">Selamat datang, <?= $user_name ?>!</small>
                    </div>

                    <!-- Stats Cards -->
                    <div class="row mb-4">
                        <div class="col-md-6 col-lg-3 mb-3">
                            <div class="card stats-card">
                                <div class="card-body text-center">
                                    <i class="fas fa-users fa-2x mb-2"></i>
                                    <h4>
                                        <?php
                                        $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM siswa");
                                        $data = mysqli_fetch_assoc($result);
                                        echo $data['total'];
                                        ?>
                                    </h4>
                                    <p class="mb-0">Total Siswa</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-3">
                            <div class="card stats-card">
                                <div class="card-body text-center">
                                    <i class="fas fa-male fa-2x mb-2"></i>
                                    <h4>
                                        <?php
                                        $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM siswa WHERE jenis_kelamin = 'L'");
                                        $data = mysqli_fetch_assoc($result);
                                        echo $data['total'];
                                        ?>
                                    </h4>
                                    <p class="mb-0">Laki-laki</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-3">
                            <div class="card stats-card">
                                <div class="card-body text-center">
                                    <i class="fas fa-female fa-2x mb-2"></i>
                                    <h4>
                                        <?php
                                        $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM siswa WHERE jenis_kelamin = 'P'");
                                        $data = mysqli_fetch_assoc($result);
                                        echo $data['total'];
                                        ?>
                                    </h4>
                                    <p class="mb-0">Perempuan</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-3 mb-3">
                            <div class="card stats-card">
                                <div class="card-body text-center">
                                    <i class="fas fa-calendar fa-2x mb-2"></i>
                                    <h4>
                                        <?php
                                        $result = mysqli_query($conn, "SELECT COUNT(*) as total FROM siswa WHERE DATE(created_at) = CURDATE()");
                                        $data = mysqli_fetch_assoc($result);
                                        echo $data['total'];
                                        ?>
                                    </h4>
                                    <p class="mb-0">Hari Ini</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Students -->
                    <div class="table-container">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5><i class="fas fa-users"></i> Siswa Terbaru</h5>
                            <a href="siswa.php" class="btn btn-outline-primary btn-sm">
                                Lihat Semua <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>JK</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $result = mysqli_query($conn, "SELECT * FROM siswa ORDER BY created_at DESC LIMIT 5");
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>
                                            <td>$no</td>
                                            <td><strong>{$row['nama']}</strong></td>
                                            <td>{$row['alamat']}</td>
                                            <td>
                                                <span class='badge " . ($row['jenis_kelamin'] == 'L' ? 'bg-primary' : 'bg-danger') . "'>
                                                    " . ($row['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan') . "
                                                </span>
                                            </td>
                                            <td>{$row['tanggal_lahir']}</td>
                                            <td>
                                                <a href='edit.php?id={$row['id']}' class='btn btn-warning btn-action'>
                                                    <i class='fas fa-edit'></i>
                                                </a>
                                                <a href='hapus.php?id={$row['id']}' onclick='return confirm(\"Yakin?\")' class='btn btn-danger btn-action'>
                                                    <i class='fas fa-trash'></i>
                                                </a>
                                            </td>
                                        </tr>";
                                        $no++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 