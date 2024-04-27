<?php 

// Inisialisasi koneksi ke database
$host = 'localhost';
$user = 'bydrz';
$pass = '';
$db = 'xtools';

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

; 
?>
