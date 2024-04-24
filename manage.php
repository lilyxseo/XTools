<?php
include 'menu.php';
require 'functions.php';

// Periksa apakah formulir disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Periksa apakah formulir disubmit
    if (isset($_POST["submit"])) {
        // Ambil nilai dari setiap input
        $menu_title = $_POST["menu_title"];
        $menu_icon = isset($_POST["menu_icon"]) ? $_POST["menu_icon"] : NULL;
        $menu_link = $_POST["menu_link"];
        $menu_parent = !empty($_POST["menu_parent"]) ? $_POST["menu_parent"] : 0;
        $menu_category = $_POST["menu_category"];

        // Persiapkan array kosong untuk menyimpan permission
        $permissions = [];

        // Periksa apakah ada checkbox yang dicentang
        if (isset($_POST["permission_administrator"])) {
            $permissions[] = $_POST["permission_administrator"];
        }
        if (isset($_POST["permission_member"])) {
            $permissions[] = $_POST["permission_member"];
        }

        // Konversi array ke JSON
        $menu_permission = json_encode($permissions);

        // Query untuk menyimpan data ke database dengan prepared statement
        $query = "INSERT INTO menu (title, icon, link, permissions, parent_id, category) VALUES (?, ?, ?, ?, ?, ?)";

        // Persiapkan statement
        $stmt = mysqli_prepare($conn, $query);

        // Bind parameter ke placeholders
        mysqli_stmt_bind_param($stmt, "ssssis", $menu_title, $menu_icon, $menu_link, $menu_permission, $menu_parent, $menu_category);

        // Eksekusi statement
        if (mysqli_stmt_execute($stmt)) {
            $successMessage = "Menu berhasil disimpan!";
            // Copy file blank.php dan ubah namanya sesuai dengan menu_link
            $blankFile = "blank.php";
            $newFileName = "$menu_link.php";
            if (copy($blankFile, $newFileName)) {
                // Ubah nama file yang disalin
                rename($newFileName, "$menu_link.php");
            } else {
                $errorMessage = "Gagal menyalin file $blankFile.";
            }
            header("Location: manage");
            exit; // Hindari eksekusi kode selanjutnya setelah redirect
        } else {
            $errorMessage = "Gagal menyimpan menu: " . mysqli_error($conn);
        }

        // Tutup statement dan koneksi
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    } else {
        $errorMessage = "Gagal menyimpan menu. Pastikan semua kolom diisi.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle?> - <?= $siteTitle ?></title>

    <?php include'view/css.txt'?>

    <!-- Custom CSS -->
    <style>
        .menu {
            list-style: none;
            font-size: 18px;
        }
        .menu a {
            text-decoration: none;
            color: var(--bs-card-color);
        }
        .sidebar-item-structure {
            padding-left: 20px;
        }
        .submenu {
            list-style: none;
            padding-left: 20px;
        }
        .form-group {
            margin-bottom: 1.3rem;
        }
        .form-body {
            font-size: 17px;
        }
        .struktur {
            font-size: 16px;
            padding-left: 2.5rem;
        }
        .struktur li {
            margin: 3px;
        }
    </style>

    <!-- Meta Tag -->
    <?php include 'view/meta.txt'?>
</head>

<body>
    <script src="assets/static/js/initTheme.js"></script>
    <div id="app">
        <?php include'view/sidebar.txt'?>
        <div id="main" class='layout-navbar navbar-fixed'>
            <?php include'view/navbar.txt'?>
            
            <div id="main-content">
                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <h3>Manage Menu</h3>
                                <p class="text-subtitle text-muted">Customize your menu by adding new items.
                                </p>
                            </div>
                            <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Settings</li>
                                        <li class="breadcrumb-item active" aria-current="page"><?= $pageTitle; ?></li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="card">
                            <div class="card-header pb-2">
                                <h4 class="card-title">Add Menu</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body pt-2">
                                <form class="form form-horizontal" method="post" action="">
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="menu-title">Title</label>
                                                </div>
                                                <div class="col-md-8 form-group">
                                                    <input type="text" id="menu-title" class="form-control" name="menu_title" placeholder="Judul Menu">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="menu-icon">Icon</label>
                                                </div>
                                                <div class="col-md-8 form-group">
                                                    <input type="text" id="menu-icon" class="form-control" name="menu_icon" placeholder="Kosongin kalo submenu">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="menu-link">Link</label>
                                                </div>
                                                <div class="col-md-8 form-group">
                                                    <input type="text" id="menu-link" class="form-control" name="menu_link" placeholder="Isi nama file">
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Permission</label>
                                                </div>
                                                <div class="col-md-8 form-group">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="permission_administrator" name="permission_administrator" value="Administrator">
                                                        <label class="form-check-label" for="permission_administrator">Administrator</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="permission_member" name="permission_member" value="Member">
                                                        <label class="form-check-label" for="permission_member">Member</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="menu-parent-id">Parent</label>
                                                </div>
                                                    <div class="col-md-8 form-group">
                                                        <select class="form-select" name="menu_parent">
                                                            <option selected value="0">Choose Parent</option>
                                                            <?php

                                                            // Periksa koneksi
                                                            if (!$conn) {
                                                                die("Koneksi gagal: " . mysqli_connect_error());
                                                            }

                                                            // Query untuk mengambil data parent dari database
                                                            $query = "SELECT id, title FROM menu WHERE parent_id = '0'";
                                                            $result = mysqli_query($conn, $query);

                                                            // Periksa apakah query berhasil dieksekusi
                                                            if (mysqli_num_rows($result) > 0) {
                                                                // Menampilkan opsi dari hasil query
                                                                while ($row = mysqli_fetch_assoc($result)) {
                                                                    echo '<option value="' . $row["id"] . '">' . $row["title"] . '</option>';
                                                                }
                                                            } else {
                                                                echo '<option value="" disabled>No parent available</option>';
                                                            }

                                                            ?>
                                                        </select>
                                                    </div>
                                                <div class="col-md-4">
                                                    <label for="menu-category">Menu Category</label>
                                                </div>
                                                <div class="col-md-8 form-group">
                                                    <input type="text" id="menu-category" class="form-control" name="menu_category" placeholder="Isi kalo menu utama, kosongin kalo submenu">
                                                </div>
                                                <div class="col-sm-12 d-flex justify-content-end mt-3">
                                                    <button name="submit" type="submit" class="btn btn-outline-primary me-1 mb-1">Add Menu</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Structure Menu</h4>
                        </div>
                        <div class="card-body">
                        <ul class="struktur menu">
                            <?php
                            // Membuat array asosiatif untuk mengelompokkan menu berdasarkan kategori
                            $groupedMenuItems = array();
                            foreach ($menuItems as $menuItem) {
                                $category = $menuItem['category'];
                                $groupedMenuItems[$category][] = $menuItem;
                            }

                            // Loop untuk setiap kategori
                            foreach ($groupedMenuItems as $category => $categoryItems) :
                                // Hanya tampilkan kategori jika memiliki setidaknya satu menu yang diizinkan untuk user saat ini
                                $hasVisibleMenu = false;
                                foreach ($categoryItems as $menuItem) {
                                    $allowedRoles = $menuItem['permissions'];
                                    $isVisibleMenu = in_array($userRole, $allowedRoles);
                                    if ($isVisibleMenu) {
                                        $hasVisibleMenu = true;
                                        break;
                                    }
                                }

                                if ($hasVisibleMenu) :
                            ?>
                                    <li class="sidebar-title"><?= $category ?></li>

                                    <?php foreach ($categoryItems as $menuItem) : ?>
                                        <?php
                                        // Menentukan apakah menu atau submenu aktif
                                        $isActiveMenu = ($currentPage == $menuItem['link']);
                                        $hasSubmenu = !empty($menuItem['submenu']);
                                        $isActiveSubmenu = false;

                                        // Jika ada submenu, periksa setiap submenu
                                        if ($hasSubmenu) {
                                            foreach ($menuItem['submenu'] as $submenuItem) {
                                                if ($currentPage == $submenuItem['link']) {
                                                    $isActiveSubmenu = true;
                                                    break;
                                                }
                                            }
                                        }

                                        // Cek izin berdasarkan level member
                                        $allowedRoles = $menuItem['permissions'];

                                        // Hanya tampilkan menu jika level member diizinkan
                                        $isVisibleMenu = in_array($userRole, $allowedRoles);
                                        ?>

                                        <?php if ($isVisibleMenu) : ?>
                                            <li class="sidebar-item-structure <?= ($isActiveMenu || $isActiveSubmenu ? 'active' : ''); ?> <?= ($hasSubmenu ? 'has-sub' : ''); ?>">
                                                <a href="#">
                                                    <i class="bi <?= $menuItem['icon'] ?>"></i>
                                                    <span><?= $menuItem['title'] ?></span>
                                                </a>
                                                <?php if ($hasSubmenu) : ?>
                                                    <ul class="submenu">
                                                        <?php foreach ($menuItem['submenu'] as $submenuItem) : ?>
                                                            <?php
                                                            // Cek izin submenu berdasarkan level member
                                                            $isVisibleSubmenu = in_array($userRole, $submenuItem['permissions']);
                                                            ?>
                                                            <?php if ($isVisibleSubmenu) : ?>
                                                                <li class="submenu-item <?= ($currentPage == $submenuItem['link'] ? 'active' : ''); ?>">
                                                                    <a href="#" class="submenu-link"><?= $submenuItem['title'] ?></a>
                                                                </li>
                                                            <?php endif; ?>
                            <?php endforeach; ?>
                            </ul>
                            <?php endif; ?>
                            </li>
                            <?php endif; ?>
                            <?php endforeach; ?>
                            <?php
                                endif;
                            endforeach;
                            ?>
                            </ul>
                        </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3">
                    <div class="card">
                        <div class="card-header pb-2">
                            <h4 class="card-title">Delete Menu</h4>
                        </div>
                        <div class="card-body pt-3">
                            <div class="form-grup mb-3">
                                <label for="string" class="form-label">Select Menu</label>
                                <select class="form-select" name="menu_delete" id="menu_delete">
                                    <option selected>Choose Menu</option>
                                    <?php
                                    // Periksa koneksi
                                    if (!$conn) {
                                        die("Koneksi gagal: " . mysqli_connect_error());
                                    }
                                    // Query untuk mengambil data parent dari database
                                    $query = "SELECT id, title FROM menu";
                                    $result = mysqli_query($conn, $query);
                                    // Periksa apakah query berhasil dieksekusi
                                    if (mysqli_num_rows($result) > 0) {
                                        // Menampilkan opsi dari hasil query
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo '<option value="' . $row["id"] . '">' . $row["title"] . '</option>';
                                        }
                                    } else {
                                        echo '<option value="" disabled>No menu available</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-12 d-flex justify-content-end">
                                <button type="button" name="delete" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">Delete</button>
                                <div class="modal fade text-left" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Penghapusan</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda yakin ingin menghapus data ini?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <?php
                                                // Menampilkan tautan hapus dengan ID menu yang dipilih
                                                echo '<a id="deleteLink" class="btn btn-danger" href="delete.php?menu=">Hapus</a>';
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>

            <?php include 'view/footer.txt'?>
        </div>
    </div>

    <?php include'view/js.txt'?>
    
    <!-- Custom JS -->
    <?php
// Script PHP untuk mengatur URL tautan hapus
echo '<script>
    document.getElementById("menu_delete").addEventListener("change", function() {
        var selectedMenuId = this.value;
        var deleteLink = document.getElementById("deleteLink");
        deleteLink.href = "delete.php?menu=" + selectedMenuId;
    });
</script>';
?>
    <!-- Alert JavaScript untuk pesan sukses atau kesalahan -->
    <?php if (isset($successMessage)): ?>
                <script>
                    alert("<?= $successMessage ?>");
                </script>
            <?php endif; ?>
            <?php if (isset($errorMessage)): ?>
                <script>
                    alert("<?= $errorMessage ?>");
                </script>
            <?php endif; ?>
</body>

</html>
