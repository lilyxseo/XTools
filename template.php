<?php
include 'menu.php';
require 'functions.php';

$directory = 'view'; // Ganti dengan path direktori sesuai kebutuhan
$phpFiles = array_filter(scandir($directory), function($file) {
    return pathinfo($file, PATHINFO_EXTENSION) === 'txt';
});

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Cek apakah ada permintaan POST untuk menyimpan file
    if (isset($_POST['file_content']) && isset($_POST['selected_file'])) {
        $selectedFile = $_POST['selected_file'];
        $fileContent = $_POST['file_content'];

        // Proses penyimpanan file di sini
        $result = file_put_contents('view/' . $selectedFile, $fileContent);

        if ($result !== false) {
            $successMessage = "File berhasil disimpan!";
        } else {
            $successMessage = "File gagal disimpan!";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/codemirror.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/theme/dracula.min.css">
    
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
                                <h3>Template Settings</h3>
                                <p class="text-subtitle text-muted">Manage your website's template settings here. Customize the look and feel of your site to make it uniquely yours.</p>
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
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <div class="card">
                                <div class="card-header pb-2">
                                    <h4 class="card-title">Edit File</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body pt-2">
                                        <?php if (isset($errorMessage)) : ?>
                                            <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
                                        <?php endif; ?>
                                        <?php if (isset($successMessage)) : ?>
                                            <div class="alert alert-success"><?php echo $successMessage; ?></div>
                                        <?php endif; ?>
                                        <form class="form form-horizontal" method="POST" action="" id="edit-form">
                                            <div class="form-body">
                                                <div class="row">
                                                    <!-- Tambahkan elemen select file -->
                                                    <div class="col-12 col-md-12 form-group">
                                                        <label for="select-file" class="form-label">Select File to Edit</label>
                                                        <select id="select-file" name="selected_file" class="form-control">
                                                            <option selected>Choose File</option>
                                                            <?php foreach ($phpFiles as $file) : ?>
                                                                <option value="<?= $file ?>"><?= $file ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <!-- Tambahkan textarea untuk mengedit file PHP -->
                                                    <div class="col-12 form-group" >
                                                        <label for="custom-html" class="form-label">Edit File Content</label>
                                                        <textarea id="custom-html" name="file_content"></textarea>
                                                    </div>
                                                    <div class="col-sm-12 d-flex justify-content-end mt-3">
                                                        <button type="submit" name="edit" class="btn btn-outline-primary me-1 mb-1">Save Changes</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    
    <!-- CodeMirror JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/mode/javascript/javascript.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/mode/css/css.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/mode/htmlmixed/htmlmixed.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/mode/php/php.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/mode/xml/xml.min.js"></script>
    <!-- <script>
        var selectFile = document.getElementById("select-file");
        var customHtmlTextarea = document.getElementById("custom-html");
        var editor;

        // Fungsi untuk mengambil konten file PHP
        function getFileContent(selectedFile) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    return xhr.responseText;
                }
            };

            // Ganti URL berikut dengan URL yang sesuai ke file PHP Anda
            xhr.open("GET", "view/" + selectedFile, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var fileContent = xhr.responseText;
                    customHtmlTextarea.value = fileContent;
                    editor.setValue(fileContent);
                }
            };
            xhr.send();
        }

        // Fungsi untuk mengubah konten CodeMirror
        function updateCodeMirrorContent() {
            var selectedFile = selectFile.value;
            getFileContent(selectedFile);
        }

        selectFile.addEventListener("change", updateCodeMirrorContent);

        // Inisialisasi CodeMirror untuk textarea
        editor = CodeMirror.fromTextArea(customHtmlTextarea, {
            mode: "htmlmixed", // Mode htmlmixed yang mencampur HTML, JavaScript, CSS, dan PHP
            lineNumbers: true, // Menampilkan nomor baris
            theme: "dracula" // Tema Dracula CodeMirror
        });

        // Pemilihan file pertama saat halaman dimuat
        updateCodeMirrorContent();

        // Atur lebar dan tinggi kode editor dengan JavaScript
        editor.setSize(null, 500); // editor adalah objek CodeMirror
        
    </script> -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
    var editor = CodeMirror.fromTextArea(document.getElementById('custom-html'), {
        mode: 'htmlmixed',
        lineNumbers: true,
        theme: 'dracula',
        indentUnit: 4,
        autofocus: true
    });

    // Ambil isi file terpilih dan masukkan ke dalam textarea CodeMirror
    document.getElementById('select-file').addEventListener('change', function () {
        var selectedFile = this.value;
        if (selectedFile) {
            // Kirim permintaan AJAX untuk membaca isi file yang dipilih
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Bersihkan editor sebelum mengatur nilai
                    editor.setValue('');
                    // Setel nilai editor
                    editor.setValue(xhr.responseText);
                }
            };
            xhr.open('GET', 'view/' + selectedFile, true);
            xhr.send();
        } else {
            // Bersihkan editor jika tidak ada file yang dipilih
            editor.setValue('');
        }
    });

    // Fungsi untuk mengambil isi CodeMirror dan memasukkannya kembali ke textarea sebelum mengirimkan formulir
    document.getElementById('edit-form').addEventListener('submit', function () {
        document.getElementById('custom-html').value = editor.getValue();
    });

    // Atur lebar dan tinggi kode editor dengan JavaScript
    editor.setSize(null, 500); // editor adalah objek CodeMirror
});

    </script>
</body>

</html>