<?php
session_start();
include 'menu.php';
require 'functions.php';

$swal = NULL;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit'])) {
        // Formulir pertama (untuk menambah data)
        $title = htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8');
        $content = htmlspecialchars($_POST['content'], ENT_QUOTES, 'UTF-8');
        $createDate = htmlspecialchars($_POST['createDate'], ENT_QUOTES, 'UTF-8');
        $owner = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');

        $sql = "INSERT INTO notepad (title, content, date, owner) VALUES ('$title', '$content', '$createDate', '$owner')";

        if ($conn->query($sql) === TRUE) {
            $swal = '
                Swal2.fire({
                    icon: "success",
                    title: "Success",
                })
                setTimeout(function() {
                    window.location.href = "notepad";
                }, 2000);
            ';
        } else {
            echo "Terjadi kesalahan: " . $conn->error;
        }
    } elseif (isset($_POST['update'])) {
        // Formulir kedua (untuk memperbarui data)
        $editId = $_POST['editId'];
        $editTitle = htmlspecialchars($_POST['editTitle'], ENT_QUOTES, 'UTF-8');
        $updateDate = htmlspecialchars($_POST['updateDate'], ENT_QUOTES, 'UTF-8');
        $editContent = htmlspecialchars($_POST['editContent'], ENT_QUOTES, 'UTF-8');

        // Update database dengan data yang diubah
        $updateSql = "UPDATE notepad SET title='$editTitle', content='$editContent', date='$updateDate' WHERE id='$editId'";

        if ($conn->query($updateSql) === TRUE) {
            $swal = '
                Swal2.fire({
                    icon: "success",
                    title: "Success",
                })
                setTimeout(function() {
                    window.location.href = "notepad";
                }, 2000);
            ';
        } else {
            echo "Terjadi kesalahan saat memperbarui data: " . $conn->error;
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
    <link rel="stylesheet" href="assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="./assets/compiled/css/table-datatable-jquery.css">
    <link rel="stylesheet" href="assets/extensions/sweetalert2/sweetalert2.min.css">

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
                                    <h3>Notepad Online</h3>
                                    <p class="text-subtitle text-muted">Create, edit, and save your notes online.
                                    </p>
                                </div>
                                <div class="col-12 col-md-6 order-md-2 order-first">
                                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Tools</li>
                                            <li class="breadcrumb-item active" aria-current="page">Notepad Online</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                </div>

                <div class="row">
                    <div class="col-12 col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Create Notepad</h4>
                            </div>
                            <div class="card-body">
                                <form method="post" action="">
                                    <div class="form-group">
                                        <label for="notepad-title" class="form-label">Notepad Title</label>
                                        <input type="text" id="notepad-title" class="form-control" name="title" placeholder="Enter the title of your note here...." required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <input type="hidden" id="createDate" name="createDate"
                                            value="<?php echo date('Y-m-d H:i'); ?>">
                                        <label for="contect" class="form-label">Content of the notepad</label>
                                        <textarea class="form-control" id="contect" name="content" rows="15" placeholder="" required></textarea>
                                    </div>
                                    <div class="col-sm-12 d-flex justify-content-end">
                                        <button type="submit"
                                            class="btn btn-outline-primary me-1 mb-1" name="submit" id="submit">Submit</button>
                                        <button type="reset" class="btn btn-outline-danger me-1 mb-1">Reset</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-12 col-lg-6">
                        <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">
                                Your Notepad
                            </h5>
                        </div>
                        <div class="card-body">
                        <?php if (isset($errorMessage)) : ?>
                            <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
                        <?php endif; ?>
                        <?php if (isset($successMessage)) : ?>
                            <div class="alert alert-success"><?php echo $successMessage; ?></div>
                        <?php endif; ?>
                            <div class="table-responsive">
                                <table class="table" id="table1">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Title</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($NotepadQuery as $index => $row) { ?>
                                        <tr>
                                            <td><?php echo $index + 1; ?></td>
                                            <td><?php echo $row['title']; ?></td>
                                            <td><?php echo $searchDateWithoutSeconds = date('Y-m-d H:i', strtotime($row['date'])); ?></td>
                                            <td>
                                                <button class="btn icon icon-left btn-outline-primary me-2 text-nowrap" data-bs-toggle="modal" data-bs-target="#modal-<?php echo $index; ?>"><i class="bi bi-eye-fill"></i> Show</button>
                                                <button class="btn icon icon-left btn-outline-danger me-2 text-nowrap" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal-<?php echo $index; ?>"><i class="bi bi-x-circle"></i> Remove</button>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                    <?php foreach ($NotepadQuery as $index => $row) { ?>
                                        <div class="modal fade text-left" id="modal-<?php echo $index; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                                <form action="" method="POST">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="myModalLabel33">Detail Info</h4>
                                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                <i data-feather="x"></i>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="hidden" name="editId" value="<?php echo $row['id']; ?>">
                                                            <input type="hidden" id="updateDate" name="updateDate" value="<?php echo date('Y-m-d H:i'); ?>">
                                                            <label for="title<?php echo $index; ?>">Notepad Title: </label>
                                                            <div class="form-group">
                                                                <input name="editTitle" id="title<?php echo $index; ?>" type="text" placeholder="title" class="form-control" value="<?php echo $row['title']; ?>">
                                                            </div>
                                                            <?php 
                                                            $content = str_replace('<br>', "\n", $row["content"]);
                                                            ?>
                                                            <label for="create<?php echo $index; ?>">Content notepad: </label>
                                                            <div class="form-group">
                                                                <textarea name="editContent" id="content<?php echo $index; ?>" placeholder="content" class="form-control" rows="15"><?php echo $content; ?></textarea>
                                                            </div>
                                                            <label for="create<?php echo $index; ?>">Create Date: </label>
                                                            <div class="form-group">
                                                                <input id="create<?php echo $index; ?>" type="create Date" placeholder="create Date" class="form-control" value="<?php echo $searchDateWithoutSeconds = date('Y-m-d H:i', strtotime($row['date'])); ?>" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button name="update" type="submit" class="btn btn-outline-primary" data-bs-dismiss="modal">
                                                                <span class="d-sm-block">Save</span>
                                                            </button>
                                                            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">
                                                                <span class="d-sm-block">Close</span>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
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
                                                        Apakah Anda yakin ingin menghapus data ini?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <a class="btn btn-danger" href="delete.php?np=<?php echo $row['id']; ?>">Hapus</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </tbody>
                                </table>
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
    <script src="assets/extensions/sweetalert2/sweetalert2.min.js"></script>
    <script src="assets/static/js/pages/sweetalert2.js"></script>
    <script src="assets/extensions/jquery/jquery.min.js"></script>
    <script src="assets/extensions/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="assets/static/js/pages/datatables.js"></script>
    <script>
    <?= $swal; ?>
    </script>
</body>

</html>
