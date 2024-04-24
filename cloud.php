<?php
include 'menu.php';
require 'functions.php';

// Inisialisasi variabel pesan
$errorMessage = '';
$successMessage = '';

// Pastikan tombol upload ditekan
if (isset($_POST['upload'])) {
    // Tentukan direktori penyimpanan file berdasarkan username
    $uploadDirectory = 'uploads/';

    // Buat direktori sesuai dengan nama pengguna jika belum ada
    if (!file_exists($uploadDirectory . $username)) {
        mkdir($uploadDirectory . $username, 0777, true);
    }

    // Loop melalui setiap file yang diunggah
    foreach ($_FILES['file']['name'] as $key => $fileName) {
        $fileTmpName = $_FILES['file']['tmp_name'][$key];
        $fileSize = $_FILES['file']['size'][$key];
        $fileError = $_FILES['file']['error'][$key];

        // Periksa apakah file diunggah dengan benar
        if ($fileError === UPLOAD_ERR_OK) {
            // Dapatkan ekstensi file
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

            // Periksa apakah ekstensi file termasuk yang akan diubah menjadi .txt
            if (in_array($fileExtension, ['html', 'php', 'php7', 'htm'])) {
                // Jika termasuk, tentukan nama file destinasi dengan ekstensi .txt
                $fileDestination = $uploadDirectory . $username . '/' . $fileName . '.txt';
            } else {
                // Jika tidak termasuk, gunakan nama file asli
                $fileDestination = $uploadDirectory . $username . '/' . $fileName;
            }

            // Pindahkan file ke direktori penyimpanan
            if (move_uploaded_file($fileTmpName, $fileDestination)) {
                // Tambahkan pesan sukses jika file berhasil diunggah
                $successMessage .= "File $fileName berhasil diunggah.<br>";
            } else {
                // Tambahkan pesan kesalahan jika file gagal diunggah
                $errorMessage .= "Error uploading file: $fileName <br>";
            }

            // Tambahkan log atau lakukan operasi lain sesuai kebutuhan
            // Misalnya: simpan nama file ke dalam database
        } else {
            // Tangani kesalahan pengunggahan file
            $errorMessage .= "Error uploading file: $fileName <br>";
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

    <?php include 'view/css.txt'?>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/extensions/filepond/filepond.css">
    <link rel="stylesheet" href="assets/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.css">
    <link rel="stylesheet" href="assets/extensions/toastify-js/src/toastify.css">

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
                                <h3>Cloud File</h3>
                                <p class="text-subtitle text-muted">Save your files in the cloud.
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
                    <div class="col-12 col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Upload File</h5>
                        </div>
                        <div class="card-content">
                            <div class="card-body pt-0">
                                <p class="card-text">Max Upload 50MB, Max File 3
                                </p>
                                <?php if (!empty($errorMessage)) : ?>
                                    <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
                                <?php endif; ?>
                                <?php if (!empty($successMessage)) : ?>
                                    <div class="alert alert-success"><?php echo $successMessage; ?></div>
                                <?php endif; ?>
                                <!-- File uploader with validation -->
                                <form method="post" enctype="multipart/form-data">
                                    <input type="file" name="file[]" class="with-validation-filepond" required multiple
                                        data-max-file-size="50MB" data-max-files="3">
                                    <div class="col-sm-12 d-flex justify-content-end">
                                        <button type="submit" name="upload" class="btn btn-outline-primary"><i class="bi bi-send"></i> Upload</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-12 col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">
                                    List Files
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table" id="table1">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama File</th>
                                                <th>Tanggal Upload</th>
                                                <th>Type</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $uploadDirectory = 'uploads/';
                                            $users = scandir($uploadDirectory);
                                            $index = 0;
                                            foreach ($users as $user) {
                                                if ($user != '.' && $user != '..' && is_dir($uploadDirectory . $user)) {
                                                    $files = scandir($uploadDirectory . $user);
                                                    foreach ($files as $file) {
                                                        if ($file != '.' && $file != '..') {
                                                            $index++;
                                                            // Ambil informasi file
                                                            $filePath = $uploadDirectory . $user . '/' . $file;
                                                            $fileInfo = pathinfo($filePath);
                                                            $fileType = strtoupper($fileInfo['extension']);
                                                            // Generate random hex color for badge
                                                            $fileTypeBadgeColor = '#' . substr(md5(rand()), 0, 6);
                                                            // Tampilkan data file pada tabel
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $index; ?></td>
                                                                <td><?php echo $fileInfo['filename']; ?></td>
                                                                <td><?php echo date("Y-m-d H:i:s", filemtime($filePath)); ?></td>
                                                                <td><span class="badge" style="background-color: <?php echo $fileTypeBadgeColor; ?>"><?php echo $fileType; ?></span></td>
                                                                <td>
                                                                    <a href="<?php echo $filePath; ?>" download class="btn icon icon-left btn-outline-primary me-2 text-nowrap">
                                                                        <i class="bi bi-cloud-download"></i>
                                                                    </a>
                                                                    <button type="button" name="delete" class="btn icon icon-left btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal-<?php echo $index; ?>">
                                                                        <i class="bi bi-trash"></i> 
                                                                    </button>
                                                                    <div class="modal fade text-left" id="confirmDeleteModal-<?php echo $index; ?>" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel-<?php echo $index; ?>" aria-hidden="true">
                                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title" id="confirmDeleteModalLabel-<?php echo $index; ?>">Konfirmasi Penghapusan</h5>
                                                                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                                        <span aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    Apakah Anda yakin ingin menghapus file <?php echo $file; ?>?
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                                    <a class="btn btn-danger" href="delete.php?file=<?php echo urlencode($file); ?>">Hapus</a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <?php
                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
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
    <script src="assets/extensions/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js"></script>
    <script src="assets/extensions/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.min.js"></script>
    <script src="assets/extensions/filepond-plugin-image-crop/filepond-plugin-image-crop.min.js"></script>
    <script src="assets/extensions/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js"></script>
    <script src="assets/extensions/filepond-plugin-image-filter/filepond-plugin-image-filter.min.js"></script>
    <script src="assets/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js"></script>
    <script src="assets/extensions/filepond-plugin-image-resize/filepond-plugin-image-resize.min.js"></script>
    <script src="assets/extensions/filepond/filepond.js"></script>
    <script src="assets/extensions/toastify-js/src/toastify.js"></script>
    <script src="assets/static/js/pages/filepond.js"></script>
</body>

</html>
