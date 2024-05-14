<?php
include 'menu.php';
require 'functions.php';

$uploadDirectory = "uploads/";

// Buat direktori sesuai dengan nama pengguna jika belum ada
if (!file_exists($uploadDirectory . $username)) {
    mkdir($uploadDirectory . $username, 0777, true);
}

// Inisialisasi variabel pesan
$errorMessage = '';
$successMessage = '';
// Inisialisasi variabel pesan
$errorMessage1 = '';
$successMessage1 = '';

// Pastikan tombol upload ditekan
if (isset($_POST['upload'])) {

    $uploadDirectory = "uploads/";

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


// Pastikan request yang diterima adalah POST dan tombol "rename" telah ditekan
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["rename"])) {
    // Periksa apakah input newFileName ada dalam request
    if (isset($_POST["newFileName"])) {
        // Simpan nama file baru dari input form
        $newFileName = $_POST["newFileName"];

        // Periksa apakah input oldFileName ada dalam request
        if (isset($_POST["oldFileName"])) {
            // Simpan nama file lama
            $oldFileName = $_POST["oldFileName"];

            // Lakukan penggantian nama file
            if (rename("uploads/$username/" . $oldFileName, "uploads/$username/" . $newFileName)) {
                $successMessage1 .= "Nama file berhasil diubah.";
            } else {
                $errorMessage1 .= "Gagal mengubah nama file.";
            }
        } else {
            $errorMessage1 .= "Nama file lama tidak ditemukan.";
        }
    } else {
        $errorMessage1 .= "Nama file baru tidak ditemukan dalam permintaan.";
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
    <link rel="stylesheet" href="assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="./assets/compiled/css/table-datatable-jquery.css">

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
                                        <?php foreach ($dataMenu as $menuItem): ?>
                                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                            <li class="breadcrumb-item active" aria-current="page"><?= $menuId; ?></li>
                                            <li class="breadcrumb-item active" aria-current="page"><?= $menuItem['title'];; ?></li>
                                        <?php endforeach; ?>
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
                            <?php if (!empty($errorMessage1)) : ?>
                                    <div class="alert alert-danger"><?php echo $errorMessage1; ?></div>
                                <?php endif; ?>
                                <?php if (!empty($successMessage1)) : ?>
                                    <div class="alert alert-success"><?php echo $successMessage1; ?></div>
                                <?php endif; ?>
                                <div class="table-responsive">
                                    <table class="table" id="table2">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama File</th>
                                                <th>Tanggal Upload</th>
                                                <th>Type</th>
                                                <th class="text-center">Action <span class="invisible">LilyXploittt</span></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $uploadDirectory = "uploads/";
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
                                                                <td><?php echo date("Y-m-d", filemtime($filePath)); ?></td>
                                                                <td><span class="badge" style="background-color: <?php echo $fileTypeBadgeColor; ?>"><?php echo $fileType; ?></span></td>
                                                                <td>
                                                                    <a href="<?php echo $filePath; ?>" download class="btn icon icon-left btn-outline-primary me-2 text-nowrap">
                                                                        <i class="bi bi-cloud-download"></i>
                                                                    </a>
                                                                    <a href="<?php echo $filePath; ?>" class="btn icon icon-left btn-outline-warning me-2 text-nowrap">
                                                                        <i class="bi bi-eye"></i> 
                                                                    </a>
                                                                    <button type="button" name="edit" class="btn icon icon-left btn btn-outline-info me-2" data-bs-toggle="modal" data-bs-target="#editFileModal-<?php echo $index; ?>">
                                                                        <i class="bi bi-pencil"></i> 
                                                                    </button>
                                                                    <button type="button" name="delete" class="btn icon icon-left btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal-<?php echo $index; ?>">
                                                                        <i class="bi bi-trash"></i> 
                                                                    </button>
                                                                    <!-- Modal for Edit File -->
                                                                    <div class="modal fade text-left" id="editFileModal-<?php echo $index; ?>" tabindex="-1" role="dialog" aria-labelledby="editFileModalLabel-<?php echo $index; ?>" aria-hidden="true">
                                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title" id="editFileModalLabel-<?php echo $index; ?>">Edit Nama File</h5>
                                                                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                                        <span aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <!-- Form for editing file name -->
                                                                                    <!-- You can add input fields and form elements here -->
                                                                                    <form action="" method="POST">
                                                                                        <div class="mb-3">
                                                                                            <label for="newFileName" class="form-label">Nama File Baru:</label>
                                                                                            <input type="text" class="form-control" id="newFileName" name="newFileName" placeholder="Masukkan nama file baru" required value="<?php echo $file; ?>">
                                                                                        </div>
                                                                                        <input type="hidden" name="oldFileName" value="<?php echo $file; ?>">
                                                                                        <div class="modal-footer">
                                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                                            <button type="buttoon" name="rename" class="btn btn-primary">Simpan</button>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!-- End of Modal for Edit File -->
                                                                    <!-- Modal for Delete Confirmation -->
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
                                                                    <!-- End of Modal for Delete Confirmation -->
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
    <script src="assets/extensions/jquery/jquery.min.js"></script>
    <script src="assets/extensions/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="assets/static/js/pages/datatables.js"></script>
    <script>
$(document).ready(function() {
    // Hancurkan DataTable sebelum inisialisasi baru
    if ($.fn.DataTable.isDataTable('#table1')) {
        $('#table1').DataTable().destroy();
    }

    // Inisialisasi DataTables
    $('#table1').DataTable({
        "columnDefs": [
            { "type": "date", "targets": 2 } // Menggunakan tipe data "date" untuk kolom ke-3 (indeks 2)
        ],
        "order": [[ 2, "desc" ]] // Mengurutkan berdasarkan kolom ke-3 (indeks 2) secara descending
        // konfigurasi DataTable lainnya
    });

    // Reset variabel index
    var index = 0;

    // Perbarui nomor urut
    $('#table1 tbody tr').each(function() {
        index++;
        $(this).find('td:first').text(index);
    });
});
    </script>
</body>

</html>
