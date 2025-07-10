<?php
// include database connections
include('connection.php');
// get data from the form
$nisn = $_POST['nisn'];
$full_name = $_POST['full_name'];
$address = $_POST['address'];
// query insert data into database
$query = "INSERT INTO tbl_siswa (nisn, nama_lengkap, alamat) VALUES ('$nisn', '$full_name', '$address')";
// the condition of checking whether the data was successfully entered or not
if ($connection->query($query)) {
    // redirect to index.php page
    header("location: index.php");
    } else {
    // error message failed to insert data
    echo "Data Failed to Save!";
    }
    ?>
    