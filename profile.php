<?php
session_start();
include 'menu.php';
require 'functions.php';
$swal = null;
function isImageFile($file) {
    $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');

    // Dapatkan ekstensi file
    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    // Periksa apakah ekstensi file ada dalam daftar yang diizinkan
    if (in_array($fileExtension, $allowedExtensions)) {
        return true;
    }

    return false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['upload_picture'])) {
        if (isset($_FILES['profile_picture'])) {
            if (isImageFile($_FILES['profile_picture'])) {
                $uploadDir = 'assets/compiled/jpg/'; // Direktori tempat menyimpan foto

                // Mendapatkan ekstensi file yang diunggah
                $imageFileType = strtolower(pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION));
                
                // Membuat nama file unik berdasarkan timestamp
                $uniqueFileName = time() . '.' . $imageFileType;
                $uploadFile = $uploadDir . $uniqueFileName;

                if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $uploadFile)) {
                    // File berhasil diunggah, sekarang perbarui nama file baru ke dalam database
                    $newPic = $uniqueFileName; // Gunakan nama file unik
                    $query = "UPDATE users SET pic = '$newPic' WHERE id = " . $user['id'];
                    $updateResult = mysqli_query($conn, $query);

                    if ($updateResult) {
                        $swal = '
                            Swal2.fire({
                                icon: "success",
                                title: "Success",
                            })
                            setTimeout(function() {
                                window.location.href = "profile";
                            }, 2000);
                        ';
                    } else {
                        $errorMessage = "Gagal memperbarui foto profil.";
                    }
                } else {
                    $errorMessage = "Gagal mengunggah file.";
                }
            } else {
                $errorMessage = "Hanya file gambar dengan ekstensi jpg, jpeg, png, dan gif yang diizinkan.";
            }
        }
    }
}



if (isset($_POST['update_profile'])) {
    // Menangani pembaruan data pengguna
    $newName = $_POST['name'];
    $newUsername = $_POST['username'];

    // Memastikan data yang valid dan sesuai kebutuhan
    if (!empty($newName) && !empty($newUsername)) {
        // Memeriksa apakah username yang baru sudah digunakan oleh pengguna lain
        $checkQuery = "SELECT id FROM users WHERE username = '$newUsername' AND id != " . $user['id'];
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) == 0) {
            // Jika username tersedia, lanjutkan pembaruan data
            $updateQuery = "UPDATE users SET full_name = '$newName', username = '$newUsername' WHERE id = " . $user['id'];
            $updateResult = mysqli_query($conn, $updateQuery);

            if ($updateResult) {
                $swal = '
                Swal2.fire({
                    icon: "success",
                    title: "Success",
                })
                setTimeout(function() {
                    window.location.href = "profile";
                }, 2000);
            ';
            } else {
                $errorMessage = "Gagal memperbarui data pengguna.";
            }
        } else {
            // Menampilkan pesan kesalahan jika username sudah dipakai
            $errorMessage = "Username sudah digunakan oleh pengguna lain.";
        }
    } else {
        // Menampilkan pesan kesalahan jika data tidak valid
        $errorMessage = "Nama dan Username harus diisi.";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - <?= $siteTitle ?></title>

    <?php include'view/css.txt'?>

    <!-- Custom CSS  -->
    <link rel="stylesheet" href="assets/extensions/sweetalert2/sweetalert2.min.css">

    <!-- Meta Tag -->
    <?php include 'view/meta.txt'?>
</head>

<body>
    <script src="assets/static/js/initTheme.js"></script>
    <div id="app">
        <?php include 'view/sidebar.txt'?>
        <div id="main" class='layout-navbar navbar-fixed'>
            <?php include 'view/navbar.txt'?>

                <div id="main-content">
                
                    <div class="page-heading">
                        <div class="page-title">
                            <div class="row">
                                <div class="col-12 col-md-6 order-md-1 order-last">
                                    <h3>Account Profile</h3>
                                    <p class="text-subtitle text-muted">A page where users can change profile information</p>
                                </div>
                                <div class="col-12 col-md-6 order-md-2 order-first">
                                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                            <li class="breadcrumb-item">Account</li>
                                            <li class="breadcrumb-item active" aria-current="page">Profile</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                        <section class="section">
                            <div class="row">
                                <div class="col-12 col-lg-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-center align-items-center flex-column">
                                                <div class="avatar avatar-2xl">
                                                    <img id="current-avatar" src="assets/compiled/jpg/<?php echo $pic ?>" alt="Avatar" draggable="false">
                                                </div>

                                                <h3 class="mt-3"><?php echo $fullName ?> <span class="h4"><?= $verified ?></span></h3>
                                                <p class="text-small"><?php echo $level ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
                                            <form action="" method="post" enctype="multipart/form-data">
                                                <label for="profile_picture" class="form-label">Change Picture</label>
                                                <div class="input-group">
                                                    <input type="file" class="form-control" name="profile_picture" id="profile_picture" accept="image/*">
                                                    <button class="btn btn-outline-primary" type="submit" name="upload_picture">Upload</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-8">
                                    <div class="card">
                                        <div class="card-body">
                                            <form action="#" method="post"> <!-- Ganti # dengan URL yang sesuai -->
                                                <?php if (isset($errorMessage)) : ?>
                                                    <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
                                                <?php endif; ?>
                                                <?php if (isset($successMessage)) : ?>
                                                    <div class="alert alert-success"><?php echo $successMessage; ?></div>
                                                <?php endif; ?>
                                                <div class="form-group">
                                                    <label for="name" class="form-label">Name</label>
                                                    <input type="text" name="name" id="name" class="form-control" placeholder="Your Name" value="<?php echo $fullName ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="username" class="form-label">Username</label>
                                                    <input type="text" name="username" id="username" class="form-control" placeholder="Your Username" value="<?php echo $username ?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="regis" class="form-label">Registered Since</label>
                                                    <input type="text" name="regis" id="regis" class="form-control" placeholder="The Time You Register" value="<?php echo$searchDateWithoutSeconds = date('Y-m-d H:i', strtotime($regisDate)); ?>" disabled>
                                                </div>
                                                <div class="form-group">
                                                    <label for="level" class="form-label">Level</label>
                                                    <input type="txt" name="level" id="level" class="form-control" placeholder="Your Level" value="<?php echo $level ?>" disabled>
                                                </div>
                                                <div class="form-group mt-3">
                                                    <button type="submit" name="update_profile" class="btn btn-outline-primary">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>

            <?php include'view/footer.txt'?>
        </div>
    </div>
    
    <?php include'view/js.txt'?>

    <!-- Custom JS  -->
    <script src="assets/extensions/sweetalert2/sweetalert2.min.js"></script>
    <script src="assets/static/js/pages/sweetalert2.js"></script>
    <script>
        <?= $swal; ?>
    </script>
</body>
</html>