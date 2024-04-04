<?php
include 'conn.php';
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Mendapatkan daftar tabel dari database
$daftar_tabel = array();
$result = $conn->query("SHOW TABLES");
if ($result->num_rows > 0) {
    while ($row = $result->fetch_row()) {
        $daftar_tabel[] = $row[0];
    }
}

// Membuka file untuk menulis
$file_handle = fopen($nama_file, 'w');

// Menulis header ke file
fwrite($file_handle, "-- Backup database pada " . date('Y-m-d H:i:s') . "\n\n");

// Mengambil struktur dan data dari setiap tabel
foreach ($daftar_tabel as $tabel) {
    // Mendapatkan struktur tabel
    $result = $conn->query("SHOW CREATE TABLE $tabel");
    $row = $result->fetch_row();
    $create_table_query = $row[1];
    fwrite($file_handle, "$create_table_query;\n\n");

    // Mendapatkan data dari tabel
    $result = $conn->query("SELECT * FROM $tabel");
    if ($result->num_rows > 0) {
        fwrite($file_handle, "INSERT INTO $tabel VALUES\n");
        $rows = array();
        while ($row = $result->fetch_assoc()) {
            $row_values = array();
            foreach ($row as $value) {
                $row_values[] = "'" . $conn->real_escape_string($value) . "'";
            }
            $rows[] = '(' . implode(', ', $row_values) . ')';
        }
        fwrite($file_handle, implode(",\n", $rows) . ";\n\n");
    }
}

// Menutup koneksi dan file
$conn->close();
fclose($file_handle);

echo "Database berhasil diekspor ke file $nama_file";
?>
