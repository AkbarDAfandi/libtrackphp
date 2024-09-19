<?php
$servername = "localhost";
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$dbname = "libtrackphp";
// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);
// Periksa koneksi
if ($conn->connect_error) {
die("Koneksi gagal: " . $conn->connect_error);
}
?>