<?php
include 'menu.php';
require 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["current_password"]) && isset($_POST["new_password"]) && isset($_POST["confirm_password"])) {
        $current_password = $_POST["current_password"];
        $new_password = $_POST["new_password"];
        $confirm_password = $_POST["confirm_password"];
        
        // Panggil fungsi changePassword
        $result = changePassword($userId, $current_password, $new_password, $confirm_password, $conn);

        // Periksa apakah ada pesan kesalahan atau pesan sukses
        if (!empty($result['error'])) {
            $errorMessage = $result['error'];
        }
        if (!empty($result['success'])) {
            $successMessage = $result['success'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security - <?= $siteTitle ?></title>

    <?php include'view/css.txt'?>

    <!-- Meta Tag -->
    <?php include 'view/meta.txt'?>
</head>

<body>
    <script src="assets/static/js/initTheme.js"></script>
    <div id="app">
        <?php include'view/sidebar.txt'?>
        <div id="main" class='layout-navbar navbar-fixed'>
            <?php include 'view/navbar.txt'?>

            <div id="main-content"> 
                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <h3>Account Security</h3>
                                <p class="text-subtitle text-muted">A page where this page can change account security settings</p>
                            </div>
                            <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                        <li class="breadcrumb-item">Account</li>
                                        <li class="breadcrumb-item active" aria-current="page">Security</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <section class="section">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header pb-2">
                                        <h5 class="card-title">Change Password</h5>
                                            <?php if (isset($errorMessage)) : ?>
                                                <div class="alert alert-danger mb-0"><?php echo $errorMessage; ?></div>
                                            <?php endif; ?>
                                            <?php if (isset($successMessage)) : ?>
                                                <div class="alert alert-success mb-0"><?php echo $successMessage; ?></div>
                                            <?php endif; ?>
                                    </div>
                                    <div class="card-body pt-2">
                                        <form method="post" action="">
                                            <div class="form-group my-2">
                                                <label for="current_password" class="form-label">Current Password</label>
                                                <input type="password" name="current_password" id="current_password" class="form-control"
                                                    placeholder="Enter your current password" value="">
                                            </div>
                                            <div class="form-group my-2">
                                                <label for="new_password" class="form-label">New Password</label>
                                                <input type="password" name="new_password" id="new_password" class="form-control"
                                                    placeholder="Enter new password" value="">
                                            </div>
                                            <div class="form-group my-2">
                                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                                <input type="password" name="confirm_password" id="confirm_password" class="form-control"
                                                    placeholder="Enter confirm password" value="">
                                            </div>

                                            <div class="form-group my-2 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-outline-primary">Save Changes</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title">Delete Account</h5>
                                    </div>
                                    <div class="card-body">
                                        <form method="post" action="">
                                            <p>Your account will be permanently deleted and cannot be restored, click "Touch me!" to continue</p>
                                            <div class="form-check">
                                                <div class="checkbox">
                                                    <input type="checkbox" id="iaggree" class="form-check-input">
                                                    <label for="iaggree">Touch me! If you agree to delete permanently</label>
                                                </div>
                                            </div>
                                            <div class="form-group my-2 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-outline-danger" id="btn-delete-account" disabled>Delete</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>

            <?php include 'view/footer.txt'?>
        </div>
    </div>
    
    <?php include'view/js.txt'?>

    <!-- Custom JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    const checkbox = document.getElementById("iaggree")
    const buttonDeleteAccount = document.getElementById("btn-delete-account")
    checkbox.addEventListener("change", function() {
        const checked = checkbox.checked;
        if (checked) {
            buttonDeleteAccount.removeAttribute("disabled");
        } else {
            buttonDeleteAccount.setAttribute("disabled", true);
        }
    });

    buttonDeleteAccount.addEventListener("click", function(event) {
        event.preventDefault(); // Mencegah pengiriman form langsung
        Swal.fire({
            title: 'Delete Account',
            text: 'Are you sure you want to permanently delete your account? This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete my account',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Tindakan yang akan diambil jika pengguna mengonfirmasi
                window.location.href = 'delete-account.php'; // Ganti dengan URL yang sesuai
            }
        });
    });
</script>
</body>

</html>