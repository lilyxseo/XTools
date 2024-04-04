<?php
include 'menu.php';
require 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['encrypt'])) {
        // Fungsi encrypt
        $inputString = $_POST['string1'];

        // Menggunakan password_hash() untuk menghasilkan hash bcrypt
        $hashedString = password_hash($inputString, PASSWORD_BCRYPT);

        // Tampilkan pesan sukses atau hasil sesuai kebutuhan Anda
        $enc = $hashedString;
    } elseif (isset($_POST['decrypt'])) {
        // Fungsi decrypt
        $inputHash = $_POST['hash'];
        $inputString = $_POST['string2'];

        // Menggunakan password_verify() untuk memverifikasi string dengan hash bcrypt
        $isMatch = password_verify($inputString, $inputHash);

        // Lakukan sesuatu berdasarkan hasil verifikasi
        if ($isMatch) {
            $dec = "<div class='alert alert-light-success color-success'>String matches the hash!</div>";
        } else {
            $dec = "<div class='alert alert-light-danger color-danger'>String does not match the hash.</div>";
        }
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
                                <h3>Bcrypt Generator</h3>
                                <p class="text-subtitle text-muted">Generate secure bcrypt hashes for your passwords with our online Bcrypt Generator.</p>
                            </div>
                            <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Tools</li>
                                        <li class="breadcrumb-item active" aria-current="page">Bcrypt Generator</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-6">
                        <div class="card">
                            <div class="card-header pb-2">
                                <h4 class="card-title">Encrypt</h4>
                            </div>
                            <!-- Bagian Encrypt Form -->
                            <form action="" method="post">
                                <div class="card-body pt-3">
                                    <?php if (isset($enc)) : ?>
                                        <div class="alert alert-light-success color-success"><?php echo $enc; ?></div>
                                    <?php endif; ?>
                                    <div class="form-grup mb-3">
                                        <label for="string" class="form-label">Enter your string</label>
                                        <input type="text" class="form-control" id="string" name="string1" value="<?php echo isset($_POST['string1']) ? htmlspecialchars($_POST['string1']) : ''; ?>">
                                    </div>
                                    <div class="col-sm-12 d-flex justify-content-end">
                                        <button type="submit" name="encrypt" class="btn btn-outline-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">
                        <div class="card">
                            <div class="card-header pb-2">
                                <h4 class="card-title">Decrypt</h4>
                            </div>
                            <!-- Bagian Decrypt Form -->
                            <form action="" method="post">
                                <div class="card-body pt-3">
                                    <?php if (isset($dec)) : ?>
                                        <?php echo $dec; ?>
                                    <?php endif; ?>
                                    <div class="form-grup mb-3">
                                        <label for="hash" class="form-label">Enter your hash</label>
                                        <input type="text" class="form-control" id="hash" name="hash" value="<?php echo isset($_POST['hash']) ? htmlspecialchars($_POST['hash']) : ''; ?>">
                                    </div>
                                    <div class="form-grup mb-3">
                                        <label for="string" class="form-label">Enter your string</label>
                                        <input type="text" class="form-control" id="string" name="string2" value="<?php echo isset($_POST['string2']) ? htmlspecialchars($_POST['string2']) : ''; ?>">
                                    </div>
                                    <div class="col-sm-12 d-flex justify-content-end">
                                        <button type="submit" name="decrypt" class="btn btn-outline-primary">Check</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
            </div>

            <?php include 'view/footer.txt'?>
        </div>
    </div>

    <?php include'view/js.txt'?>
    
    <!-- Custom JS -->
</body>

</html>