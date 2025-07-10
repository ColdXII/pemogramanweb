<?php
$host = "sql210.infinityfree.com"; // (find the correct host in MySQL Databases page)
$user = "if0_39388902";    // your InfinityFree DB username
$password = "Coldandc00l"; // your InfinityFree DB password
$dbname = "if0_39388902_project_221510006"; // your DB name

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
