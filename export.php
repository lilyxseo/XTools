<?php
include 'menu.php';
require 'functions.php';

// Fungsi untuk mengekspor database
function exportDatabase($conn, $backupFolder) {
    // Mendapatkan daftar tabel dari database
    $daftar_tabel = array();
    $result = $conn->query("SHOW TABLES");
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_row()) {
            $daftar_tabel[] = $row[0];
        }
    }

    // Nama file untuk ekspor
    $nama_file = $backupFolder . "/backup_database_" . date('Y-m-d') . ".sql";

    // Membuka file untuk menulis
    $file_handle = fopen($nama_file, 'w');

    // Menulis header ke file
    fwrite($file_handle, "-- Backup database pada " . date('Y-m-d H:i:s') . "\n\n");

    // Mengambil struktur dan data dari setiap tabel
    foreach ($daftar_tabel as $tabel) {
        // Mendapatkan struktur tabel
        $result = $conn->query("SHOW CREATE TABLE $tabel");
        $row = $result->fetch_row();
        $create_table_query = $row[1];
        fwrite($file_handle, "$create_table_query;\n\n");

        // Mendapatkan data dari tabel
        $result = $conn->query("SELECT * FROM $tabel");
        if ($result->num_rows > 0) {
            fwrite($file_handle, "INSERT INTO $tabel VALUES\n");
            $rows = array();
            while ($row = $result->fetch_assoc()) {
                $row_values = array();
                foreach ($row as $value) {
                    $row_values[] = "'" . $conn->real_escape_string($value) . "'";
                }
                $rows[] = '(' . implode(', ', $row_values) . ')';
            }
            fwrite($file_handle, implode(",\n", $rows) . ";\n\n");
        }
    }

    // Menutup koneksi dan file
    fclose($file_handle);

    // Mengembalikan nama file yang diekspor
    return $nama_file;
}

if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Path tempat menyimpan file ekspor
$backupFolder = "backup";

// Buat folder backup jika belum ada
if (!file_exists($backupFolder)) {
    mkdir($backupFolder, 0777, true);
}

// Cek apakah tombol "Export Database" ditekan
if(isset($_POST["export"])) {
    // Panggil fungsi exportDatabase dengan objek koneksi database dan path folder backup
    $nama_file = exportDatabase($conn, $backupFolder);
    
    $successMessage = "Database berhasil diekspor!";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle?> - <?= $siteTitle ?></title>

    <!-- Include CSS files -->
    <?php include 'view/css.txt'?>

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
                                <h3>Export Database</h3>
                                <p class="text-subtitle text-muted">Database Export: Easily Backup Your Database Data.</p>
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
                    <div class="col-12 col-lg-4">
                        <div class="card">
                            <div class="card-header pb-2">
                                <h4 class="card-title">Export</h4>
                            </div>
                            <form action="" method="post">
                                <div class="card-body pt-3">
                                    <?php if (isset($errorMessage)) : ?>
                                            <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
                                        <?php endif; ?>
                                        <?php if (isset($successMessage)) : ?>
                                            <div class="alert alert-success"><?php echo $successMessage; ?></div>
                                        <?php endif; ?>
                                    <div class="col-sm-12 d-flex justify-content-center">
                                        <button type="submit" name="export" class="btn btn-outline-primary"><i class="bi bi-cloud-download"></i> Export Database</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-12 col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">
                                    List backup
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table" id="table1">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama File</th>
                                                <th>Tanggal Backup</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $backupFolder = 'backup/';
                                            $backupFiles = scandir($backupFolder);
                                            $index = 0;
                                            foreach ($backupFiles as $file) {
                                                // Periksa apakah file cocok dengan pola nama yang diinginkan
                                                if (strpos($file, 'backup_database_') === 0) {
                                                    $index++;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $index; ?></td>
                                                        <td><?php echo $file; ?></td>
                                                        <td><?php echo date("Y-m-d H:i:s", filemtime($backupFolder . $file)); ?></td>
                                                        <td>
                                                            <a href="<?php echo $backupFolder . $file; ?>" download class="btn icon icon-left btn-outline-primary me-2 text-nowrap">
                                                                <i class="bi bi-cloud-download"></i> Download
                                                            </a>
                                                            <button type="button" name="delete" class="btn icon icon-left btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal-<?php echo $index; ?>"> <i class="bi bi-trash"></i> Hapus</button>
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
                                                                            <a class="btn btn-danger" href="delete.php?db=<?php echo urlencode($file); ?>">Hapus</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php }
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include JS files -->
    <?php include 'view/js.txt'?>
    
    <!-- Custom JS -->
</body>

</html>
