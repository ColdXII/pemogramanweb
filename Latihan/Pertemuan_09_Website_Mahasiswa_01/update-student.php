<?php
// include database connections
include('connection.php');
// get data from the form
$id = $_POST['id'];
$nisn = $_POST['nisn'];
$full_name = $_POST['full_name'];
$address = $_POST['address'];
// query update data in database
$query = "UPDATE tbl_siswa SET nisn='$nisn', nama_lengkap='$full_name', alamat='$address' WHERE id_siswa=$id";
// the condition of checking whether the data was successfully updated or not
if ($connection->query($query)) {
    // redirect to index.php page
    header("location: index.php");
    } else {
    // error message failed to update data
    echo "Data Failed to Update!";
    }
    ?> 