<?php
include 'conn.php';
// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}


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
}


// Query untuk mengambil data menu utama
$sql = "SELECT * FROM menu WHERE parent_id = '0'";
$result = $conn->query($sql);

$menuItems = array(); // Inisialisasi array menuItems

if ($result->num_rows > 0) {
    // Loop melalui data dan membangun struktur menuItems
    while ($row = $result->fetch_assoc()) {
        $menuItem = array(
            'title' => $row["title"],
            'icon' => $row["icon"],
            'link' => $row["link"],
            'permissions' => json_decode($row["permissions"], true), // Mengonversi string JSON menjadi array PHP
            'submenu' => array(),
            'category' => $row["category"]
        );

        // Query untuk mengambil submenu
        $submenu_sql = "SELECT * FROM menu WHERE parent_id = " . $row["id"] . " ORDER BY title ASC";
        $submenu_result = $conn->query($submenu_sql);

        if ($submenu_result->num_rows > 0) {
            while ($submenu_row = $submenu_result->fetch_assoc()) {
                $submenuItem = array(
                    'title' => $submenu_row["title"],
                    'link' => $submenu_row["link"],
                    'permissions' => json_decode($submenu_row["permissions"], true) // Mengonversi string JSON menjadi array PHP
                );

                $menuItem['submenu'][] = $submenuItem;
            }
        }

        $menuItems[] = $menuItem;
    }
}


// Periksa izin pengguna (gantilah ini dengan peran pengguna yang sesuai)
$userRole = $level;

$currentPage = pathinfo(basename($_SERVER['SCRIPT_FILENAME']), PATHINFO_FILENAME);

$visibleMenuItems = array_filter($menuItems, function ($menuItem) use ($userRole, $currentPage) {
    return in_array($userRole, $menuItem['permissions']);
});

$activeMenu = null; // Membuat variabel untuk menyimpan menu aktif

$activeSubMenu = null; // Membuat variabel untuk submenu aktif

foreach ($visibleMenuItems as $menuItem) {
    $isActive = ($currentPage == $menuItem['link']);

    if (!$isActive && !empty($menuItem['submenu'])) {
        foreach ($menuItem['submenu'] as $submenuItem) {
            if ($currentPage == $submenuItem['link']) {
                $isActive = true;
                $activeSubMenu = $submenuItem;
                break; // Keluar dari loop submenu jika ditemukan yang aktif
            }
        }
    }

    if ($isActive) {
        $activeMenu = $menuItem;
        break; // Keluar dari loop jika sudah ditemukan menu aktif
    }
}

// Query untuk mendapatkan data menu berdasarkan currentPage
$queryMenu = "SELECT * FROM menu WHERE link = '$currentPage'";
$resultMenu = $conn->query($queryMenu);

// Array untuk menyimpan data menu
$dataMenu = array();

if ($resultMenu->num_rows > 0) {
    // Jika data menu ditemukan, simpan ke dalam array
    while ($rowMenu = $resultMenu->fetch_assoc()) {
        $dataMenu[] = array(
            'title' => $rowMenu['title'],
            'icon' => $rowMenu['icon'],
            'link' => $rowMenu['link'],
            'permissions' => json_decode($rowMenu['permissions'], true),
            'submenu' => array(),
            'category' => $rowMenu['category']
        );
    }
}
// Query untuk mendapatkan parent_id berdasarkan currentPage
$queryParentId = "SELECT * FROM menu WHERE link = '$currentPage'";
$resultParentId = $conn->query($queryParentId);

// Variabel untuk menyimpan parent_id
$parent_id = null;

if ($resultParentId->num_rows > 0) {
    // Jika data parent_id ditemukan, ambil nilainya
    $rowParentId = $resultParentId->fetch_assoc();
    $parent_id = $rowParentId['parent_id'];
}

// Jika parent_id adalah 0, ganti query untuk mencari kategori
if ($parent_id == 0) {
    $queryMenuId = "SELECT category FROM menu WHERE link = '$currentPage'";
} else {
    $queryMenuId = "SELECT title FROM menu WHERE id = '$parent_id'";
}

$resultMenuId = $conn->query($queryMenuId);

// Jika data ditemukan, ambil kolom yang sesuai
if ($resultMenuId->num_rows > 0) {
    $rowMenuId = $resultMenuId->fetch_assoc();
    if ($parent_id == 0) {
        // Ambil title jika parent_id adalah 0
        $menuId = $rowMenuId['category'];
    } else {
        // Ambil category jika parent_id bukan 0
        $menuId = $rowMenuId['title'];
    }
}



if ($activeSubMenu !== null) {
    $pageTitle = $activeSubMenu['title'];
} elseif ($activeMenu !== null) {
    $pageTitle = $activeMenu['title'];
} else {
    $pageTitle = "Halaman Tidak Ditemukan";
}



?>
