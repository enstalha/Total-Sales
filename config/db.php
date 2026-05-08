<?php
// database connection
// change these if your xampp setup is different

$host = "localhost";
$db   = "totalsales";
$user = "root";
$pass = "";  // default xampp has no password

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// just in case characters break
mysqli_set_charset($conn, "utf8");
