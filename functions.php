<?php
date_default_timezone_set('Asia/Jakarta');
if (!isset($_COOKIE['unique_login_cookie'])) {
    header('Location: auth-login'); // Redirect pengguna ke halaman login jika belum login
    exit();
}

include 'conn.php'; 
// Baca cookie dan ambil ID pengguna
$unique_login_cookie = $_COOKIE['unique_login_cookie'];

// Query untuk mengambil informasi pengguna dari database
$query = "SELECT * FROM users WHERE id = (SELECT user_id FROM login_cookies WHERE cookie_value = '$unique_login_cookie')";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);

    // Data pengguna
    $userId = $user['id'];
    $username = $user['username'];
    $fullName = $user['full_name'];
    $regisDate = $user['registration_date'];
    $level = $user['level'];
    $pic = $user['pic'];
} else {
    // Pengguna tidak ditemukan, mungkin cookie tidak valid
    header('Location: auth-login'); // Redirect pengguna ke halaman login
    exit();
}

// Query untuk mengambil data histori dari tabel domains
$historyQuery = mysqli_query($conn, "SELECT * FROM domains WHERE owner = '$username'");
if ($historyQuery) {
    $historyData = mysqli_fetch_all($historyQuery, MYSQLI_ASSOC);

    // Balik urutan array
    $historyData = array_reverse($historyData);
} else {
    echo "Gagal menjalankan kueri: " . mysqli_error($conn);
}

$NotepadQuery = mysqli_query($conn, "SELECT * FROM notepad WHERE owner = '$username'");
if ($NotepadQuery) {
    $NotepadData = mysqli_fetch_all($NotepadQuery, MYSQLI_ASSOC);

    // Balik urutan array
    $NotepadData = array_reverse($NotepadData);
} else {
    echo "Gagal menjalankan kueri: " . mysqli_error($conn);
}


// Fungsi untuk mengganti password
function changePassword($user_id, $current_password, $new_password, $confirm_password, $conn) {
    $errorMessage = '';
    $successMessage = '';
    
    // Ambil password saat ini dari database berdasarkan user_id
    $query = "SELECT password FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $db_password = $row['password'];
        
        // Verifikasi apakah current_password sesuai dengan password di database
        if (password_verify($current_password, $db_password)) {
            // Verifikasi apakah new_password dan confirm_password sama
            if ($new_password === $confirm_password) {
                // Hash password baru
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                
                // Update password dalam database
                $update_query = "UPDATE users SET password = ? WHERE id = ?";
                $update_stmt = $conn->prepare($update_query);
                $update_stmt->bind_param("si", $hashed_password, $user_id);
                if ($update_stmt->execute()) {
                    $successMessage = "Password berhasil diubah.";
                } else {
                    $errorMessage = "Terjadi kesalahan saat mengubah password.";
                }
            } else {
                $errorMessage = "Password baru dan konfirmasi password tidak sesuai.";
            }
        } else {
            $errorMessage = "Password saat ini tidak sesuai.";
        }
    } else {
        $errorMessage = "User tidak ditemukan.";
    }

    return array('error' => $errorMessage, 'success' => $successMessage);
}

// Buat query SQL untuk mengambil data
$sql = "SELECT * FROM settings";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $siteTitle = $row['site_title'];
        $siteDescription = $row['site_description'];
        $siteLogo = $row['site_logo'];
        $siteFavicon = $row['favicon'];
    }
} else {
    echo "Tidak ada data ditemukan.";
}

// Inisialisasi variabel $verified dengan nilai default false
$verified = false;

// Cek apakah $levelUser adalah Administrator
if ($level === "Administrator") {
    // Jika ya, atur $verified menjadi true
    $verified = '<i class="bi bi-patch-check-fill text-primary" data-bs-toggle="tooltip"
    title="Verified"></i>';
} else {

}

?>