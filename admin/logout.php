<?php
session_start();
// koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "inventori");

// Untuk Menghapus Sessionnya
$_SESSION = [];
session_unset();
session_destroy();

// Mengalihkan ke halaman login
header("location: ../index.php");
exit;
