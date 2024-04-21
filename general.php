<?php
include 'menu.php';
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
// Ambil data dari form yang di-post
    $siteTitle = $_POST['site_title'];
    $siteDescription = $_POST['site_description'];
    $siteLogo = ''; // Inisialisasi variabel $siteLogo
    $siteFavicon = ''; // Inisialisasi variabel $siteFavicon

    // Periksa apakah pengguna tidak mengubah "Site Logo" dan "Favicon"
    if (empty($siteLogo)) {
        $siteLogo = "logo.svg"; // Nilai default untuk "Site Logo"
    }

    if (empty($siteFavicon)) {
        $siteFavicon = "favicon.svg"; // Nilai default untuk "Favicon"
    }

    // Buat query SQL untuk mengupdate data dalam tabel website_settings
    $sql = "UPDATE settings SET 
            site_title = '$siteTitle',
            site_description = '$siteDescription',
            site_logo = '$siteLogo',
            favicon = '$siteFavicon'
            WHERE id = 1"; // Sesuaikan dengan kondisi yang sesuai

    if ($conn->query($sql) === TRUE) {
        $successMessage = "Data berhasil diperbarui!";
    } else {
        $errorMessage = "Gagal memperbarui foto profil.";
    }
}
?> 
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?> - <?= $siteTitle ?></title>

    <?php include'view/css.txt'?>

    <!-- Custom CSS -->

    <!-- Meta Tag -->
    <?php include 'view/meta.txt'?>

</head>

<body>
    <script src="assets/static/js/initTheme.js"></script>
    <div id="app">
        <?php include 'view/sidebar.txt' ?>
        <div id="main" class='layout-navbar navbar-fixed'>
            <?php include 'view/navbar.txt' ?>

            <div id="main-content">
                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <h3>General Settings</h3>
                                <p class="text-subtitle text-muted">Manage your website's general settings here. Customize the look and feel of your site to make it uniquely yours.</p>
                            </div>
                            <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                        <li class="breadcrumb-item">Settings</li>
                                        <li class="breadcrumb-item active" aria-current="page">General</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="card">
                                <div class="card-header pb-2">
                                    <h4 class="card-title">Website Settings</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body pt-2">
                                        <?php if (isset($errorMessage)) : ?>
                                            <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
                                        <?php endif; ?>
                                        <?php if (isset($successMessage)) : ?>
                                            <div class="alert alert-success"><?php echo $successMessage; ?></div>
                                        <?php endif; ?>
                                        <form class="form form-horizontal" method="post" action="">
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label for="site-title">Site Title</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <input type="text" id="site-title" class="form-control" name="site_title" placeholder="Site Title" value="<?php echo $siteTitle; ?>">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="site-description">Site Description</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <textarea id="site-description" class="form-control" name="site_description" placeholder="Site Description" rows="8"><?php echo $siteDescription; ?></textarea>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="site-logo">Site Logo</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <img class="my-2" src="assets/compiled/svg/<?php echo $siteLogo; ?>" alt="Site Logo" width="100" height="40">
                                                        <input type="file" id="site-logo" class="form-control" name="logo">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="site-favicon">Favicon</label>
                                                    </div>
                                                    <div class="col-md-8 form-group">
                                                        <img class="my-2" src="assets/compiled/svg/<?php echo $siteFavicon; ?>" alt="Favicon" width="40" height="40">
                                                        <input type="file" id="site-favicon" class="form-control" name="site_favicon">
                                                    </div>
                                                    <div class="col-sm-12 d-flex justify-content-end mt-3">
                                                        <button type="submit" class="btn btn-outline-primary me-1 mb-1">Save Changes</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php include 'view/footer.txt' ?>
                </div>
            </div>
        </div>
    </div>
    <?php include'view/js.txt'?>
    
    <!-- Custom JS  -->
</body>

</html>
