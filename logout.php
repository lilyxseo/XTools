<?php
session_start();

// Hancurkan semua sesi
session_destroy();

// Hapus cookie jika ada
if (isset($_COOKIE['unique_login_cookie'])) {
    setcookie('unique_login_cookie', '', time() - 36000, '/'); // Waktu kedaluwarsa yang telah berlalu
}

// Redirect pengguna ke halaman login atau halaman lain yang sesuai
header("Location: auth-login"); // Ganti "login.php" dengan halaman yang sesuai
exit();
?>
