<?php
include('connection.php');
$id = $_GET['id'];
$query = "SELECT * FROM tbl_siswa WHERE id_siswa = $id LIMIT 1";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_array($result);
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<title>Edit Student</title>
</head>
<body>
<div class="container" style="margin-top: 80px">
<div class="row">
<div class="col-md-8 offset-md-2">
<div class="card">
<div class="card-header">
STUDENT EDIT
</div>
<div class="card-body">
<form action="update-student.php" method="POST">
<input type="hidden" name="id" value="<?php echo $row['id_siswa']; ?>">
<div class="form-group">
<label>NISN</label>
<input type="text" name="nisn" value="<?php echo $row['nisn']; ?>" placeholder="Enter Student's NISN" class="form-control">
</div>
<div class="form-group">
<label>FullName</label>
<input type="text" name="full_name" value="<?php echo $row['nama_lengkap']; ?>" placeholder="Please enter a name Students" class="form-control">
</div>
<div class="form-group">
<label>Address</label>
<textarea class="form-control" name="address" placeholder="Enter an address Students" rows="4"><?php echo $row['alamat']; ?></textarea>
</div>
<button type="submit" class="btn btn-success">UPDATE</button>
<a href="index.php" class="btn btn-warning">BACK</a>
</form>
</div>
</div>
</div>
</div>
<script src="assets/js/jquery-3.3.1.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>
