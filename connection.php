<?php
$host = "localhost"; // or your DB host
$user = "root"; // or your DB username
$password = ""; // your DB password
$database = "PY"; // change this

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
?>
