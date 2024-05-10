<?php
include 'menu.php';
require 'functions.php';

$thisMonth = date('Y-m-01');

$dateInput = isset($_GET['q']) ? $_GET['q'] : $thisMonth;

$parts = explode('-to-', $dateInput);

if (count($parts) == 2) {
    $days1 = intval($parts[0]);
    $days2 = intval($parts[1]);
    $startDate = date('Y-m-d', strtotime("-$days1 days"));
    $endDate = date('Y-m-d', strtotime("-$days2 days"));
    $date = "$startDate to $endDate";
} else if (preg_match('/^\d+d$/', $dateInput)) {
    $days = intval($dateInput);
    $date = date('Y-m-d', strtotime("-$days days"));
} else {
    $date = "Invalid format";
}

if(isset($_GET['selectDate'])) {
    $dateInput = $_GET['date'];

    if (strpos($dateInput, ' to ') !== false) {
        list($startDate, $endDate) = explode(" to ", $dateInput);

        $today = date("Y-m-d");
        $differenceInStart = date_diff(date_create($today), date_create($startDate))->format('%a');
        $differenceInEnd = date_diff(date_create($today), date_create($endDate))->format('%a');

        $redirectURL = '?q=' . $differenceInStart . 'd-to-' . $differenceInEnd . 'd';
    } else {
        $today = date("Y-m-d");
        $differenceInDays = date_diff(date_create($today), date_create($dateInput))->format('%a');

        $redirectURL = '?q=' . $differenceInDays . 'd';
    }

    header('Location: ' . $redirectURL);
    exit();
}


function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$sql = "SELECT nominal FROM finance_total";
$result = mysqli_query($conn, $sql);
                                                
if (mysqli_num_rows($result) > 0) {
$row = mysqli_fetch_assoc($result);
$totalUang = $row["nominal"];
} else {
$totalUang = 0;
}

if (isset($_POST["tambahData"])) {
    $judul = clean_input($_POST["judul"]);
    $nominal_input = clean_input($_POST["nominal"]);
    $nominal_angka = str_replace('.', '', $nominal_input); // Hapus titik dari format rupiah
    $nominal_angka = str_replace(',', '.', $nominal_angka); // Ganti koma dengan titik untuk mengonversi ke format angka
    $kategori = clean_input($_POST["kategori"]);
    $keterangan = clean_input($_POST["keterangan"]);
    $jenis = clean_input($_POST["jenis"]);

    $nominalFormatted = number_format($nominal_angka, 0, ',', '.'); // Konversi ke format rupiah untuk ditampilkan

    // Ambil nilai total uang dari database
    $sql_select_total_uang = "SELECT nominal FROM finance_total";
    $result = $conn->query($sql_select_total_uang);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $totalUang = floatval(str_replace('.', '', $row["nominal"])); // Hapus titik dan konversi ke angka float
    } else {
        $totalUang = 0;
    }

    // Lakukan operasi tambah atau kurang
    if ($jenis == 'Pemasukan') {
        $totalUang += $nominal_angka;
    } elseif ($jenis == 'Pengeluaran') {
        $totalUang -= $nominal_angka;
    }

    $totalUangFormatted = number_format($totalUang, 0, ',', '.'); // Konversi kembali ke format rupiah untuk disimpan di database

    // Simpan total uang yang telah diupdate ke database
    $sql_update_total_uang = "UPDATE finance_total SET nominal = '$totalUangFormatted'";
    $conn->query($sql_update_total_uang);

    // Masukkan data transaksi ke dalam database
    $sql_insert_transaksi = "INSERT INTO finance_histori (judul, tanggal, nominal, kategori, keterangan, tipe, total_duit) VALUES ('$judul', NOW(), '$nominalFormatted', '$kategori', '$keterangan', '$jenis', '$totalUangFormatted')";
    
    if ($conn->query($sql_insert_transaksi) === TRUE) {
        $success_message = "Data berhasil ditambahkan";
    } else {
        $error_message = "Error: " . $sql_insert_transaksi . "<br>" . $conn->error;
    }
}

if (isset($_POST["uangSekarang"])) {
    $nominalBaru = clean_input($_POST["nominalBaru"]);

    $sql_update = "UPDATE finance_total SET nominal = '$nominalBaru';";
    if ($conn->query($sql_update) === TRUE) {
        $success_message = "Data berhasil diubah!";
    } else {
        $error_message = "Error: " . $sql . "<br>" . $conn->error;
    }
}


$sql = "SELECT DISTINCT kategori FROM finance_histori WHERE tipe = 'Pengeluaran'";
$result = $conn->query($sql);

// Memeriksa apakah ada hasil dari query
if ($result->num_rows > 0) {
  // Inisialisasi array untuk menyimpan data label
  $labelsFromDatabase = array();

  // Mendapatkan hasil query satu per satu
  while ($row = $result->fetch_assoc()) {
    // Mengubah huruf besar pertama di setiap kata
    $kategori = ucwords($row["kategori"]);

    // Menambahkan data label ke array jika belum ada
    if (!in_array($kategori, $labelsFromDatabase)) {
      $labelsFromDatabase[] = $kategori;
    }
  }

  // Mengkonversi array ke format JSON untuk digunakan di JavaScript
  $labelsJSON = json_encode($labelsFromDatabase);
} else {
  // Jika tidak ada hasil dari query
  echo "Tidak ada data yang ditemukan.";
}



// Mengambil data nominal dari database
$sql = "SELECT kategori, nominal FROM finance_histori WHERE tipe = 'Pengeluaran'";
$result = $conn->query($sql);

// Memeriksa apakah ada hasil dari query
if ($result->num_rows > 0) {
    // Inisialisasi array untuk menyimpan total nominal
    $totalNominals = array();

    // Mendapatkan hasil query satu per satu
    while ($row = $result->fetch_assoc()) {
        // Menghilangkan karakter pemisah dan mengonversi ke tipe data float
        $nominal = floatval(str_replace(',', '', str_replace('.', '', $row["nominal"])));
        
        // Mengubah huruf besar pertama di setiap kata kategori
        $kategori = ucwords($row["kategori"]);

        // Menambahkan nominal ke kategori yang sama atau membuat entri baru jika belum ada
        if (array_key_exists($kategori, $totalNominals)) {
            $totalNominals[$kategori] += $nominal;
        } else {
            $totalNominals[$kategori] = $nominal;
        }
    }

    // Mengonversi nilai nominal ke format rupiah tanpa tanda petik
    foreach ($totalNominals as $key => $value) {
        // Mengonversi nilai menjadi pecahan dengan dua desimal
        $totalNominals[$key] = round($value, 2);
    }

    // Mengonversi array ke format array numerik untuk digunakan di JavaScript
    $totalNominalsJSON = json_encode(array_values($totalNominals));
} else {
    // Jika tidak ada hasil dari query
    echo "Tidak ada data yang ditemukan.";
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
    <link rel="stylesheet" href="./assets/compiled/css/table-datatable-jquery.css">
    <link rel="stylesheet" href="assets/extensions/flatpickr/flatpickr.min.css">
    <link rel="stylesheet" href="assets/extensions/sweetalert2/sweetalert2.min.css">
    <style>
        .input-group-prepend {
            flex: 0 0 auto;
        }

        .input-group-text {
            border-top-left-radius: .25rem;
            border-bottom-left-radius: .25rem;
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
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Statistics Finance</h3>
                        <p class="text-subtitle text-muted">Track recent transactions, monitor investment progress, and make informed decisions for your financial future.!</p>
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
                <!-- Your content -->
                <div class="row">
                    <div class="col-12 col-lg-8">
                        <div class="row justify-content-center" id="">
                            <!-- Card Uang Tersisa -->
                            <div class="col-12 col-lg-4 col-md-12 col-xl-4">
                                <div class="card">
                                    <div class="card-body px-4 py-3-5">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h6 class="font-extrabold mb-0">Total uang kamu 
                                                    </h6>
                                                    <i class="bi-bank2 fs-5 mb-0"></i>
                                                    <?php 
                                                    $sql = "SELECT nominal FROM finance_total";
                                                    $result = mysqli_query($conn, $sql);
                                                                                                    
                                                    if (mysqli_num_rows($result) > 0) {
                                                    $row = mysqli_fetch_assoc($result);
                                                    $uangSaya = $row["nominal"];
                                                    } else {
                                                    $uangSaya = 0;
                                                    }
                                                    ; ?>
                                                </div><h6 class='text-secondary'>Rp. <?= $uangSaya; ?> </h6>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                            <!-- Card Pemasukan -->
                            <div class="col-6 col-lg-3 col-md-6">
                                <div class="card">
                                    <div class="card-body px-4 py-3-5">
                                        <?php 
                                            $sql = "SELECT IFNULL(SUM(REPLACE(nominal, '.', '') + 0), 0) AS total_nominal
                                            FROM finance_histori
                                            WHERE tipe = 'Pemasukan'
                                            AND MONTH(tanggal) = MONTH(CURRENT_DATE())
                                            AND YEAR(tanggal) = YEAR(CURRENT_DATE())";

                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                            $row = $result->fetch_assoc();
                                            $total_nominal = $row["total_nominal"];

                                            // Tambahkan format rupiah pada total nominal
                                            $nominal = number_format($total_nominal, 0, ',', '.');
                                            } else {
                                            $nominal = 0;
                                            }
                                        ?>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h6 class="font-extrabold mb-0">Pemasukan</h6>
                                                    <i class="bi-arrow-up-right text-success fs-5 mb-0"></i>
                                                </div>
                                                <h6 class="text-success">Rp. <?= $nominal; ?></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Card Pengeluaran -->
                            <div class="col-6 col-lg-3 col-md-6">
                                <div class="card">
                                    <div class="card-body px-4 py-3-5">
                                    <?php 
                                            $sql = "SELECT IFNULL(SUM(REPLACE(nominal, '.', '') + 0), 0) AS total_nominal
                                            FROM finance_histori
                                            WHERE tipe = 'Pengeluaran'
                                            AND MONTH(tanggal) = MONTH(CURRENT_DATE())
                                            AND YEAR(tanggal) = YEAR(CURRENT_DATE())";

                                            $result = $conn->query($sql);

                                            if ($result->num_rows > 0) {
                                            $row = $result->fetch_assoc();
                                            $total_nominal = $row["total_nominal"];

                                            // Tambahkan format rupiah pada total nominal
                                            $nominal = number_format($total_nominal, 0, ',', '.');
                                            } else {
                                            $nominal = 0;
                                            }
                                        ?>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h6 class="font-extrabold mb-0">Pengeluaran 
                                                    </h6>
                                                    <i class="bi-arrow-down-right text-danger fs-5 mb-0"></i>
                                                </div>
                                                <h6 class="text-danger">Rp. <?= $nominal; ?></h6>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Bar Statistik -->
                            <div class="col-12 col-lg-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Statistik Pemasukan</h4>
                                    </div>
                                    <div class="card-body">
                                        <div id="bar"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- Pie Statistik -->
                            <div class="col-12 col-lg-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Statistik Pengeluaran</h4>
                                    </div>
                                    <div class="card-body">
                                        <div id="pie"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <!-- Pilih Tanggal -->
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Pilih Tanggal</h4>
                                    </div>
                                    <div class="card-body">
                                        <form method="get">
                                            <input type="text" name="date" class="form-control flatpickr-range mb-3 flatpickr-input" placeholder="Select date.." readonly="readonly">
                                            <div class="col-sm-12 d-flex justify-content-end mt-3">
                                                <button type="submit" name="selectDate" class="btn btn-outline-primary me-1 mb-1">Kirim</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- Uang saat ini -->
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Uang saat ini</h4>
                                    </div>
                                    <div class="card-body">
                                        <form method="post">
                                            <div class="mb-3">
                                                <label for="nominal" class="form-label">Nominal:</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">Rp.</span>
                                                    <?php 
                                                    $sql = "SELECT nominal FROM finance_total";
                                                    $result = mysqli_query($conn, $sql);
                                                    
                                                    if (mysqli_num_rows($result) > 0) {
                                                        $row = mysqli_fetch_assoc($result);
                                                        $nominal = $row["nominal"];
                                                    
                                                        echo "<input type='text' class='form-control' id='nominal2' name='nominalBaru' placeholder='1.000.000' value='$nominal' required pattern='[0-9]+(?:\.[0-9]{1,2})?*' required>";
                                                    }
                                                    ; ?>
                                                </div>
                                                <div class="col-sm-12 d-flex justify-content-end mt-3">
                                                    <button type="submit" name="uangSekarang" class="btn btn-outline-primary me-1 mb-1">Kirim</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- Tambah kategori -->
                                <!-- <div class="card">
                                    <div class="card-header">
                                        <h4>Tambah Kategori</h4>
                                    </div>
                                    <div class="card-body">
                                        <form method="get">
                                            <input type="text" name="date" class="form-control" placeholder="Makanan..">
                                            <div class="col-sm-12 d-flex justify-content-end mt-3">
                                                <button type="submit" name="site_submit" class="btn btn-outline-primary me-1 mb-1">Kirim</button>
                                            </div>
                                        </form>
                                    </div>
                                </div> -->
                            </div>
                            <!-- Tambah data -->
                            <div class="col-12 col-lg-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Tambah data</h4>
                                    </div>
                                    <div class="card-body">
                                        <form action="" method="POST">
                                            <div class="mb-3">
                                                <label for="judul" class="form-label">Judul:</label>
                                                <input type="text" class="form-control" id="judul" name="judul" placeholder="Gajian" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="nominal" class="form-label">Nominal:</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">Rp.</span>
                                                    <input type="text" class="form-control" id="nominal1" name="nominal" placeholder="1.000.000" required pattern="[0-9]+(?:\.[0-9]{1,2})?*" required>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="kategori" class="form-label">Kategori:</label>
                                                <input type="text" class="form-control" id="kategori" name="kategori" placeholder="Investasi">
                                            </div>
                                            <div class="mb-3">
                                                <label for="keterangan" class="form-label">Keterangan:</label>
                                                <textarea class="form-control" id="keterangan" name="keterangan" placeholder="Gajian bulan ini" rows="4" cols="30" ></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Jenis:</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="jenis" id="pemasukan" value="Pemasukan" checked>
                                                    <label class="form-check-label" for="pemasukan">Pemasukan</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="jenis" id="pengeluaran" value="Pengeluaran">
                                                    <label class="form-check-label" for="pengeluaran">Pengeluaran</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 d-flex justify-content-end mt-3">
                                                <button type="submit" name="tambahData" class="btn btn-outline-primary me-1 mb-1">Kirim</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Card Transaksi Terakhir -->
                    <div class="col-12 col-lg-4">
                        <section class="section">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">
                                        Transaksi Terakhir
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive datatable-minimal overflow-hidden">
                                        <table class="table" id="table2">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                            $dateInput = isset($_GET['q']) ? $_GET['q'] : date('Y-m-d');

                                            $parts = explode('-to-', $dateInput);

                                            if (count($parts) == 2) {
                                                $startDate = date('Y-m-d', strtotime($parts[0]));
                                                $endDate = date('Y-m-d', strtotime($parts[1]));
                                                $sql = "SELECT id, judul, DATE_FORMAT(tanggal, '%d %b %Y') AS tanggal, nominal, tipe 
                                                        FROM finance_histori
                                                        WHERE DATE(tanggal) BETWEEN '$startDate' AND '$endDate'";
                                            } else if (preg_match('/^(\d+)d$/', $dateInput, $matches)) {
                                                $days = intval($matches[1]);
                                                if ($days > 0) {
                                                    $endDate = date('Y-m-d', strtotime("-1 days"));
                                                    $startDate = date('Y-m-d', strtotime("-$days days"));
                                                    $sql = "SELECT id, judul, DATE_FORMAT(tanggal, '%d %b %Y') AS tanggal, nominal, tipe 
                                                            FROM finance_histori
                                                            WHERE DATE(tanggal) BETWEEN '$startDate' AND '$endDate'";
                                                } else {
                                                    $sql = "SELECT id, judul, DATE_FORMAT(tanggal, '%d %b %Y') AS tanggal, nominal, tipe 
                                                            FROM finance_histori
                                                            WHERE DATE(tanggal) = CURDATE()";
                                                }
                                            } else {
                                                $dateInput = date('Y-m-01', strtotime($dateInput));
                                                $sql = "SELECT id, judul, DATE_FORMAT(tanggal, '%d %b %Y') AS tanggal, nominal, tipe 
                                                        FROM finance_histori
                                                        WHERE DATE_FORMAT(tanggal, '%Y-%m-01') = '$dateInput'";
                                            }

                                                    $result = $conn->query($sql);

                                                    if ($result->num_rows > 0) {
                                                        while($row = $result->fetch_assoc()) {
                                                            echo '<tr>';
                                                            echo '<td class="d-none">' . $row['id'] . '</td>';
                                                            echo '<td>';
                                                            echo '<div class="card mb-3">';
                                                            echo '<div class="card-body p-1 pb-0">';
                                                            echo '<div class="row align-items-center">';
                                                            echo '<div class="col-auto">';
                                                            if ($row['tipe'] == 'Pemasukan') {
                                                                echo '<div class="stats-icon bg-success mb-2"><i class="bi-arrow-up-right fs-4"></i></div>';
                                                            } elseif ($row['tipe'] == 'Pengeluaran') {
                                                                echo '<div class="stats-icon bg-danger mb-2"><i class="bi-arrow-down-right fs-4"></i></div>';
                                                            }
                                                            echo '</div>';
                                                            echo '<div class="col">';
                                                            echo '<h6 class="mb-0">' . $row['judul'] . '</h6>';
                                                            echo '<p class="text-muted text-sm mb-1">' . $row['tanggal'] . '</p>';
                                                            echo '</div>';
                                                            echo '<div class="col-auto">';
                                                            echo '<p class="mb-0 ';
                                                            if ($row['tipe'] == 'Pemasukan') {
                                                                echo 'text-success">+ Rp. ' . $row['nominal'];
                                                            } elseif ($row['tipe'] == 'Pengeluaran') {
                                                                echo 'text-danger">- Rp. ' . $row['nominal'];
                                                            }
                                                            echo '</p>';
                                                            echo '</div>';
                                                            echo '</div>';
                                                            echo '</div>';
                                                            echo '</div>';
                                                            echo '</td>';
                                                            echo '</tr>';
                                                        }
                                                    } else {
                                                        echo "0 hasil";
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>

            <?php include 'view/footer.txt'?>
        </div>
    </div>

    <?php include'view/js.txt'?>
    
    <!-- Custom JS -->
    <script src="assets/extensions/sweetalert2/sweetalert2.min.js"></script>
    <script>
        <?php
        // Tampilkan pesan kesalahan jika ada
        if (isset($error_message)) {
            echo "swal('Error', '$error_message', 'error');";
        }

        // Tampilkan pesan sukses jika ada
        if (isset($success_message)) {
            echo "Swal.fire({
                title: '$success_message',
                icon: 'success'
              });";
        }
        ?>
    </script>
    <script src="assets/extensions/apexcharts/apexcharts.min.js"></script>
    <script src="assets/extensions/flatpickr/flatpickr.min.js"></script>
    <script src="assets/extensions/jquery/jquery.min.js"></script>
    <script src="assets/extensions/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="assets/static/js/pages/datatables.js"></script>
    <script>
        var barOptions = {
        series: [
            {
            name: "Pemasukan",
            data: [44, 55, 57, 56, 61, 58, 112],
            },
            {
            name: "Pengeluaran",
            data: [76, 85, 101, 98, 87, 105, 120],
            },
            {
            name: "Uang Saya",
            data: [120, 140, 158, 154, 148, 163, 232],
            },
        ],
        chart: {
            type: "bar",
            height: 350,
        },
        plotOptions: {
            bar: {
            horizontal: false,
            columnWidth: "55%",
            endingShape: "rounded",
            },
        },
        dataLabels: {
            enabled: false,
        },
        colors: ['#198754', '#dc3545', '#6c757d'],
        stroke: {
            show: true,
            width: 2,
            colors: ["transparent"],
        },
        xaxis: {
            categories: ["Sen", "Sel", "Rab", "Kam", "Jum", "Sab", "Min"],
        },
        yaxis: {
            title: {
            text: "Rp. (Rupiah)",
            },
        },
        fill: {
            opacity: 1,
        },
        tooltip: {
            y: {
            formatter: function (val) {
                return "Rp. " + val;
            },
            },
        },
        };
        var bar = new ApexCharts(document.querySelector("#bar"), barOptions);   

        var options = {
          series: <?= $totalNominalsJSON; ?>,
          chart: {
          width: '100%',
          type: 'pie',
        },
        labels: <?= $labelsJSON; ?>,
        theme: {
          monochrome: {
            enabled: true
          }
        },
        plotOptions: {
          pie: {
            dataLabels: {
              offset: -5
            }
          }
        },
        dataLabels: {
          formatter(val, opts) {
            const name = opts.w.globals.labels[opts.seriesIndex]
            return [name, val.toFixed(1) + '%']
          }
        },
        legend: {
          show: false
        }
        };
        var pie = new ApexCharts(document.querySelector("#pie"), options);

        pie.render();
        bar.render();


        flatpickr('.flatpickr-range', {
        dateFormat: "Y-m-d", 
        mode: 'range',
        maxDate: "today"
        })

        var nominal1 = document.getElementById('nominal1');
        nominal1.addEventListener('keyup', function(e)
        {
            nominal1.value = formatRupiah(this.value);
        });
        var nomninal2 = document.getElementById('nominal2');
        nomninal2.addEventListener('keyup', function(e)
        {
            nomninal2.value = formatRupiah(this.value);
        });
        /* Fungsi */
        function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        // Menambahkan pemisah ribuan untuk jutaan, miliaran, dan seterusnya
        for (var i = 1; i < split.length; i++) {
            rupiah += ',' + split[i];
        }

        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
    </script>
</body>
</html>