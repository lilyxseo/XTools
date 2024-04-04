<?php
include 'conn.php';
include 'menu.php';

// Periksa apakah parameter "ns" telah diterima dari URL
if (isset($_GET['ns'])) {
    $id = $_GET['ns'];

    // Lakukan query penghapusan data dari database
    $stmt = mysqli_prepare($conn, "DELETE FROM domains WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    // Redirect kembali ke halaman yang sesuai setelah penghapusan
    header("Location: ns");
    exit;
} else {
    // Tindakan jika parameter "ns" tidak ada
    echo "";
}

// Periksa apakah parameter "np" telah diterima dari URL
if (isset($_GET['np'])) {
    $id = $_GET['np'];

    // Lakukan query penghapusan data dari database
    $stmt = mysqli_prepare($conn, "DELETE FROM notepad WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $successMessage = "Data berhasil dihapus!";

    // Redirect kembali ke halaman yang sesuai setelah penghapusan
    header("Location: notepad");
    exit;
} else {
    // Tindakan jika parameter "np" tidak ada
    $errorMessage = "";
}

// Periksa apakah parameter "menu" telah diterima dari URL
if (isset($_GET['menu'])) {
    $id = $_GET['menu'];

    // Lakukan query untuk mengambil link menu yang akan dihapus
    $stmt = mysqli_prepare($conn, "SELECT link FROM menu WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $link);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Jika link menu ditemukan
    if ($link) {
        // Hapus file terkait
        $fileName = "$link.php"; // Sesuaikan dengan format nama file
        if (file_exists($fileName)) {
            unlink($fileName); // Hapus file
        }
    }

    // Lakukan query penghapusan data dari database
    $stmt = mysqli_prepare($conn, "DELETE FROM menu WHERE id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $successMessage = "Data berhasil dihapus!";

    // Redirect kembali ke halaman yang sesuai setelah penghapusan
    header("Location: manage");
    exit;
} else {
    // Tindakan jika parameter "menu" tidak ada
    $errorMessage = "";
}


// Fungsi untuk menghapus file dari folder backup
function deleteBackupFile($fileName) {
    $backupFolder = 'backup/';
    $filePath = $backupFolder . $fileName;

    // Periksa apakah file ada sebelum menghapusnya
    if (file_exists($filePath)) {
        // Hapus file
        unlink($filePath);
        return true; // Berhasil menghapus file
    } else {
        return false; // File tidak ditemukan
    }
}

// Fungsi untuk menghapus file dari folder uploads
function deleteUserFile($fileName, $username) {
    $uploadsFolder = 'uploads/';
    $userFolder = $uploadsFolder . $username . '/';
    $filePath = $userFolder . $fileName;

    // Periksa apakah file ada sebelum menghapusnya
    if (file_exists($filePath)) {
        // Hapus file
        unlink($filePath);
        return true; // Berhasil menghapus file
    } else {
        return false; // File tidak ditemukan
    }
}

// Periksa apakah parameter "db" telah diterima dari URL (untuk menghapus file dari folder backup)
if (isset($_GET['db'])) {
    $fileName = $_GET['db'];

    // Hapus file dari folder backup
    $deleted = deleteBackupFile($fileName);

    if ($deleted) {
        $successMessage = "File $fileName berhasil dihapus!";
    } else {
        $errorMessage = "File $fileName tidak dapat ditemukan atau gagal dihapus.";
    }

    // Redirect kembali ke halaman sebelumnya
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
}

// Pastikan variabel $username sudah diinisialisasi sebelumnya

// Periksa apakah parameter "file" telah diterima dari URL (untuk menghapus file dari folder uploads)
if (isset($_GET['file'])) {
    $fileName = $_GET['file'];

    // Hapus file dari folder uploads sesuai dengan username
    $deleted = deleteUserFile($fileName, $username);

    if ($deleted) {
        $successMessage = "File $fileName berhasil dihapus!";
    } else {
        $errorMessage = "File $fileName tidak dapat ditemukan atau gagal dihapus.";
    }

    // Redirect kembali ke halaman sebelumnya
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit;
}
?>
