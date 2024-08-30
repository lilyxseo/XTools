<?php
include 'menu.php';
require 'functions.php';

$thisMonth = date('Y-m-01');
$dateInput = $_GET['q'] ?? $thisMonth;

// Menentukan rentang tanggal atau offset hari
$parts = explode('-to-', $dateInput);

if (count($parts) == 2) {
    $days1 = intval($parts[0]);
    $days2 = intval($parts[1]);
    $startDate = date('Y-m-d', strtotime("-$days1 days"));
    $endDate = date('Y-m-d', strtotime("-$days2 days"));
    $date = "$startDate to $endDate";
} elseif (preg_match('/^\d+d$/', $dateInput)) {
    $days = intval($dateInput);
    $date = date('Y-m-d', strtotime("-$days days"));
} else {
    $date = "Format tidak valid";
}

// Mengelola pemilihan tanggal manual
if (isset($_GET['selectDate'])) {
    $dateInput = $_GET['date'];
    $today = date("Y-m-d");

    if (strpos($dateInput, ' to ') !== false) {
        list($startDate, $endDate) = explode(" to ", $dateInput);
        $differenceInStart = date_diff(date_create($today), date_create($startDate))->format('%a');
        $differenceInEnd = date_diff(date_create($today), date_create($endDate))->format('%a');
        $redirectURL = '?q=' . $differenceInStart . 'd-to-' . $differenceInEnd . 'd';
    } else {
        $differenceInDays = date_diff(date_create($today), date_create($dateInput))->format('%a');
        $redirectURL = '?q=' . $differenceInDays . 'd';
    }

    header('Location: ' . $redirectURL);
    exit();
}

// Fungsi untuk membersihkan input
function clean_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Mengambil total nominal dari database
$sql = "SELECT nominal FROM finance_total";
$result = mysqli_query($conn, $sql);
$totalUang = (mysqli_num_rows($result) > 0) ? mysqli_fetch_assoc($result)["nominal"] : 0;

// Menangani penambahan data baru
if (isset($_POST["tambahData"])) {
    $judul = clean_input($_POST["judul"]);
    $nominal_input = clean_input($_POST["nominal"]);
    $nominal_angka = floatval(str_replace(['.', ','], ['', '.'], $nominal_input));
    $kategori = clean_input($_POST["kategori"]);
    $keterangan = clean_input($_POST["keterangan"]);
    $jenis = clean_input($_POST["jenis"]);

    // Mengambil total uang saat ini
    $result = $conn->query("SELECT nominal FROM finance_total");
    $totalUang = ($result->num_rows > 0) ? floatval(str_replace('.', '', $result->fetch_assoc()["nominal"])) : 0;

    // Menghitung total uang berdasarkan jenis transaksi
    $totalUang = ($jenis == 'Pemasukan') ? $totalUang + $nominal_angka : $totalUang - $nominal_angka;

    $totalUangFormatted = number_format($totalUang, 0, ',', '.');

    // Memperbarui total uang di database
    $conn->query("UPDATE finance_total SET nominal = '$totalUangFormatted'");

    // Menyimpan transaksi ke database
    $sql_insert_transaksi = "INSERT INTO finance_histori (judul, tanggal, nominal, kategori, keterangan, tipe, total_duit) VALUES ('$judul', NOW(), '" . number_format($nominal_angka, 0, ',', '.') . "', '$kategori', '$keterangan', '$jenis', '$totalUangFormatted')";
    
    if ($conn->query($sql_insert_transaksi) === TRUE) {
        $success_message = "Data berhasil ditambahkan";
    } else {
        $error_message = "Error: " . $sql_insert_transaksi . "<br>" . $conn->error;
    }
}

// Menangani pembaruan nominal
if (isset($_POST["uangSekarang"])) {
    $nominalBaru = clean_input($_POST["nominalBaru"]);

    if ($conn->query("UPDATE finance_total SET nominal = '$nominalBaru'") === TRUE) {
        $success_message = "Data berhasil diubah!";
    } else {
        $error_message = "Error: " . $conn->error;
    }
}

// Mengambil kategori pengeluaran dari database
$pengeluaran = [];
$result = $conn->query("SELECT DISTINCT kategori FROM finance_histori WHERE tipe = 'Pengeluaran'");
while ($row = $result->fetch_assoc()) {
    $pengeluaran[] = ['kategori' => ucwords(strtolower($row['kategori']))];
}

// Mengambil kategori pemasukan dari database
$pemasukan = [];
$result = $conn->query("SELECT DISTINCT kategori FROM finance_histori WHERE tipe = 'Pemasukan'");
while ($row = $result->fetch_assoc()) {
    $pemasukan[] = ['kategori' => ucwords(strtolower($row['kategori']))];
}

// Mengambil data pemasukan per hari
$pemasukan_per_hari = [];
$result = $conn->query("SELECT DATE(tanggal) AS tanggal, SUM(REPLACE(nominal, '.', '')) AS total_nominal FROM finance_histori WHERE tipe = 'Pemasukan' GROUP BY DATE(tanggal)");
while ($row = $result->fetch_assoc()) {
    $pemasukan_per_hari[$row['tanggal']] = floatval($row['total_nominal']);
}

// Mengambil data pengeluaran per hari
$pengeluaran_per_hari = [];
$result = $conn->query("SELECT DATE(tanggal) AS tanggal, SUM(REPLACE(nominal, '.', '')) AS total_nominal FROM finance_histori WHERE tipe = 'Pengeluaran' GROUP BY DATE(tanggal)");
while ($row = $result->fetch_assoc()) {
    $pengeluaran_per_hari[$row['tanggal']] = floatval($row['total_nominal']);
}

// Mengambil data total uang per hari
$total_uang_per_hari = [];
$result = $conn->query("SELECT DATE(tanggal) AS tanggal, MAX(REPLACE(total_duit, '.', '')) AS total_duit FROM finance_histori GROUP BY DATE(tanggal)");
while ($row = $result->fetch_assoc()) {
    $total_uang_per_hari[$row['tanggal']] = floatval($row['total_duit']);
}

// Persiapan data untuk chart
$timestamp_sekarang = time();
$tanggal_awal_minggu = date('Y-m-d', strtotime('last Monday', $timestamp_sekarang));

$pemasukan_chart_data = $pengeluaran_chart_data = $total_uang_chart_data = [];

for ($i = 0; $i < 7; $i++) {
    $tanggal = date('Y-m-d', strtotime("$tanggal_awal_minggu +$i day"));
    $pemasukan_chart_data[] = $pemasukan_per_hari[$tanggal] ?? 0;
    $pengeluaran_chart_data[] = $pengeluaran_per_hari[$tanggal] ?? 0;
    $total_uang_chart_data[] = $total_uang_per_hari[$tanggal] ?? 0;
}

$pemasukanJSON = json_encode($pemasukan_chart_data);
$pengeluaranJSON = json_encode($pengeluaran_chart_data);
$total_uang_JSON = json_encode($total_uang_chart_data);

// Mengambil data nominal pengeluaran per kategori
$result = $conn->query("SELECT kategori, nominal FROM finance_histori WHERE tipe = 'Pengeluaran'");
$totalNominals = [];
while ($row = $result->fetch_assoc()) {
    $nominal = floatval(str_replace([',', '.'], '', $row["nominal"]));
    $kategori = ucwords($row["kategori"]);
    $totalNominals[$kategori] = ($totalNominals[$kategori] ?? 0) + $nominal;
}
$totalNominalsJSON = json_encode(array_values($totalNominals));

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
        .clickable {
        cursor: pointer;
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
                                        <h4>Statistik Minggu Ini</h4>
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
                                                <label for="nominal2" class="form-label">Nominal:</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">Rp.</span>
                                                    <?php 
                                                    $sql = "SELECT nominal FROM finance_total";
                                                    $result = mysqli_query($conn, $sql);
                                                    
                                                    if (mysqli_num_rows($result) > 0) {
                                                        $row = mysqli_fetch_assoc($result);
                                                        $nominal = $row["nominal"];
                                                    
                                                        echo "<input type='text' class='form-control' id='nominal2' name='nominalBaru' placeholder='1.000.000' value='$nominal' required pattern='[0-9]+(?:\.[0-9]{1,2})?*' required inputmode='numeric'>";
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
                                        <h4>Tambah Data</h4>
                                    </div>
                                    <div class="card-body">
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="pemasukan-tab" data-bs-toggle="tab" data-bs-target="#pemasukan-tab-pane" type="button" role="tab" aria-controls="pemasukan-tab-pane" aria-selected="true">Pemasukan</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="pengeluaran-tab" data-bs-toggle="tab" data-bs-target="#pengeluaran-tab-pane" type="button" role="tab" aria-controls="pengeluaran-tab-pane" aria-selected="false">Pengeluaran</button>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            <!-- Pemasukan Tab -->
                                            <div class="tab-pane fade show active" id="pemasukan-tab-pane" role="tabpanel" aria-labelledby="pemasukan-tab">
                                                <form action="" method="POST">
                                                    <div class="mb-3 mt-3">
                                                        <label for="judul" class="form-label">Judul:</label>
                                                        <input type="text" class="form-control" id="judul" name="judul" placeholder="Gajian" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="nominal1" class="form-label">Nominal:</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">Rp.</span>
                                                            <input type="text" class="form-control" id="nominal1" name="nominal" placeholder="500.000" required pattern="[0-9]+(?:\.[0-9]{1,2})?*" required inputmode='numeric'>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="kategori" class="form-label">Kategori:</label>
                                                        <select class="form-control" id="kategori" name="kategori">
                                                            <?php foreach($pemasukan as $pemasukans): ?>
                                                                <option value="<?= $pemasukans['kategori']; ?>"><?= $pemasukans['kategori']; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="keterangan" class="form-label">Keterangan:</label>
                                                        <textarea class="form-control" id="keterangan" name="keterangan" placeholder="Gajian bulan ini" rows="4" cols="30"></textarea>
                                                    </div>
                                                    <input type="hidden" name="jenis" value="Pemasukan">
                                                    <div class="col-sm-12 d-flex justify-content-end mt-3">
                                                        <button type="submit" name="tambahData" class="btn btn-outline-primary me-1 mb-1">Kirim</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- Pengeluaran Tab -->
                                            <div class="tab-pane fade" id="pengeluaran-tab-pane" role="tabpanel" aria-labelledby="pengeluaran-tab">
                                                <form action="" method="POST">
                                                    <div class="mb-3 mt-3">
                                                        <label for="judul" class="form-label">Judul:</label>
                                                        <input type="text" class="form-control" id="judul" name="judul" placeholder="Belanja" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="nominal3" class="form-label">Nominal:</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text">Rp.</span>
                                                            <input type="text" class="form-control" id="nominal3" name="nominal" placeholder="500.000" required pattern="[0-9]+(?:\.[0-9]{1,2})?*" required inputmode='numeric'>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="kategori" class="form-label">Kategori:</label>
                                                        <select class="form-control" id="kategori" name="kategori">
                                                            <?php foreach($pengeluaran as $pengeluarans): ?>
                                                                <option value="<?= $pengeluarans['kategori']; ?>"><?= $pengeluarans['kategori']; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="keterangan" class="form-label">Keterangan:</label>
                                                        <textarea class="form-control" id="keterangan" name="keterangan" placeholder="Belanja bulanan" rows="4" cols="30"></textarea>
                                                    </div>
                                                    <input type="hidden" name="jenis" value="Pengeluaran">
                                                    <div class="col-sm-12 d-flex justify-content-end mt-3">
                                                        <button type="submit" name="tambahData" class="btn btn-outline-primary me-1 mb-1">Kirim</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
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
                                                            WHERE DATE(tanggal) BETWEEN '$startDate' AND '$endDate' ORDER BY id DESC";
                                                } else if (preg_match('/^(\d+)d$/', $dateInput, $matches)) {
                                                    $days = intval($matches[1]);
                                                    if ($days > 0) {
                                                        $endDate = date('Y-m-d', strtotime("-1 days"));
                                                        $startDate = date('Y-m-d', strtotime("-$days days"));
                                                        $sql = "SELECT id, judul, DATE_FORMAT(tanggal, '%d %b %Y') AS tanggal, nominal, tipe 
                                                                FROM finance_histori
                                                                WHERE DATE(tanggal) BETWEEN '$startDate' AND '$endDate' ORDER BY id DESC";
                                                    } else {
                                                        $sql = "SELECT id, judul, DATE_FORMAT(tanggal, '%d %b %Y') AS tanggal, nominal, tipe 
                                                                FROM finance_histori
                                                                WHERE DATE(tanggal) = CURDATE() ORDER BY id DESC";
                                                    }
                                                } else {
                                                    $dateInput = date('Y-m-01', strtotime($dateInput));
                                                    $sql = "SELECT id, judul, DATE_FORMAT(tanggal, '%d %b %Y') AS tanggal, nominal, tipe 
                                                            FROM finance_histori
                                                            WHERE DATE_FORMAT(tanggal, '%Y-%m-01') = '$dateInput' ORDER BY id DESC";
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
                                                        echo '<h6 class="mb-0">' . ucwords($row['judul']) . '</h6>'; // Menggunakan ucwords() untuk membuat huruf pertama menjadi huruf besar
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
    <script src="assets/extensions/apexcharts/apexcharts.min.js"></script>
    <script src="assets/extensions/flatpickr/flatpickr.min.js"></script>
    <script src="assets/extensions/jquery/jquery.min.js"></script>
    <script src="assets/extensions/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        var barOptions = {
            series: [
                {
                    name: "Pemasukan",
                    data: <?= $pemasukanJSON; ?>,
                },
                {
                    name: "Pengeluaran",
                    data: <?= $pengeluaranJSON; ?>,
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
            colors: ['#198754', '#dc3545'],
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
                labels: {
                    formatter: function (value) {
                        // Format nilai menjadi format Rupiah
                        return "Rp. " + value.toLocaleString('id-ID');
                    }
                }
            },
            fill: {
                opacity: 1,
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        // Format nilai tooltip menjadi format Rupiah
                        return "Rp. " + val.toLocaleString('id-ID');
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
                    const name = opts.w.globals.labels[opts.seriesIndex];
                    return [name, val.toFixed(1) + '%']
                }
            },
            legend: {
                show: false
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return "Rp. " + val.toLocaleString('id-ID');
                    },
                },
            },
        };

        var pie = new ApexCharts(document.querySelector("#pie"), options);


        pie.render();
        bar.render();


        flatpickr('.flatpickr-range', {
        dateFormat: "Y-m-d", 
        mode: 'range',
        maxDate: "today"
        })
    </script>
    <script>
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
        var nomninal3 = document.getElementById('nominal3');
        nomninal3.addEventListener('keyup', function(e)
        {
            nomninal3.value = formatRupiah(this.value);
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
    <script>
        let jquery_datatable = $("#table1").DataTable({
        responsive: true
    });

    let customized_datatable = $("#table2").DataTable({
        responsive: true,
        pagingType: 'simple',
        dom:
            "<'row'<'col-3'l><'col-9'f>>" +
            "<'row dt-row'<'col-sm-12'tr>>" +
            "<'row'<'col-4'i><'col-8'p>>",
        language: {
            info: "Page _PAGE_ of _PAGES_",
            lengthMenu: "_MENU_ ",
            search: "",
            searchPlaceholder: "Search.."
        }
    });

    const setTableColor = () => {
        document.querySelectorAll('.dataTables_paginate .pagination').forEach(dt => {
            dt.classList.add('pagination-primary');
        });
    };

    const reverseTableData = () => {
        // Memanggil fungsi DataTables 'order' untuk membalikkan urutan data berdasarkan ID secara descending
        customized_datatable.order([0, 'desc']).draw();
    };

    setTableColor();
    jquery_datatable.on('draw', setTableColor);
    customized_datatable.on('draw', setTableColor);

    // Memanggil fungsi untuk membalikkan data tabel
    reverseTableData();
    </script>
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
</body>
</html>