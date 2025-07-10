<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="stylesheet" href="assets/css/bootstrap.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<title>Student Data</title>
</head>
<body>
<div class="container" style="margin-top: 80px">
<div class="row">
<div class="col-md-12">
<div class="card">
<div class="card-header">
STUDENT DATA
</div>
<div class="card-body">
<a href="add-student.php" class="btn btn-md btn-success" style="margin-bottom: 10px"> ADD DATA </a>
<table class="table table-bordered" id="myTable">
<thead>
 <tr>
<th scope="col"> NO. </th>
<th scope="col">NISN</th>
<th scope="col"> FULL NAME </th>
<th scope="col">ADDRESS</th>
<th scope="col"> ACTION </th>
</tr>
</thead>
<tbody>
<?php
 include('connection.php');
 $no = 1;
 $query = mysqli_query($connection, "SELECT * FROM tbl_siswa");
 while ($row = mysqli_fetch_array($query)) {
 ?>
 <tr>
 <td> <?php echo $no++?> </td>
 <td> <?php echo $row['nisn']?> </td>
 <td> <?php echo $row['nama_lengkap']?> </td>
 <td> <?php echo $row['alamat']?> </td>
 <td class="text-center">
 <a href="edit-Mahasiswa.php?id=<?php echo $row['id_siswa']?>" class="btn btn-sm btn-primary"> EDIT </a>
 <a href="delete-student.php?id=<?php echo $row['id_siswa']?>" class="btn btn-sm btn-danger"> DELETE </a>
</td>
</tr>
<?php } ?>
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
<script src="assets/js/jquery-3.3.1.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function () {
$('#myTable').DataTables();
});
</script>
</body>
</html>
 