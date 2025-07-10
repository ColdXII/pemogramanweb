<?php
// variable declassification
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "db_sekolah";
$connection = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$connection) {
echo "Connection Failed!:" . mysqli_connect_error();
}
?>
