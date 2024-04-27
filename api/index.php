<?php
// Include file konfigurasi database
include '../conn.php';
// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Query untuk mengambil URL aplikasi
$sql = "SELECT url FROM app WHERE id = 1"; // Ubah sesuai dengan nama tabel dan struktur database Anda

// Eksekusi query
$result = $conn->query($sql);

// Memeriksa apakah hasil query mengembalikan baris data
if ($result->num_rows > 0) {
    // Mengambil data dari baris pertama (asumsi hanya ada satu baris data)
    $row = $result->fetch_assoc();
    $appURL = $row["url"];
    // Mengembalikan data URL
    echo $appURL;
} else {
    echo "Tidak ada data URL aplikasi yang ditemukan.";
}

// Tutup koneksi ke database
$conn->close();
header("Location: $appURL");
?>
