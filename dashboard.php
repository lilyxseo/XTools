<?php
include 'menu.php';
require 'functions.php';

// Fungsi untuk mengambil data dari API Indodax
function getIndodaxData($url) {
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    return json_decode($response, true);
}

// URL API Indodax
$apiUrl = 'https://indodax.com/api/tickers';

// Mendapatkan data dari API Indodax
$data = getIndodaxData($apiUrl);

// Array koin yang ingin ditampilkan
$coins = array(
    'btc_idr' => array(
        'name' => 'Bitcoin',
        'image' => 'https://indodax.com/v2/logo/svg/color/btc.svg',
        'amount' => 0.0001648
    ),
    'token_idr' => array(
        'name' => 'TokenFI',
        'image' => 'https://indodax.com/v2/logo/svg/color/token.svg',
    ),
    'ondo_idr' => array(
        'name' => 'Ondo',
        'image' => 'https://indodax.com/v2/logo/svg/color/ondo.svg',
    ),
    'doge_idr' => array(
        'name' => 'Dogecoin',
        'image' => 'https://indodax.com/v2/logo/svg/color/doge.svg',
    ),
    // Tambahkan koin lain jika diperlukan
);

// Menghitung total aset dalam IDR
$totalAsset = 0;
foreach ($coins as $key => $coin) {
    if (isset($data['tickers'][$key]['last'])) {
        $totalAsset += $coin['amount'] * $data['tickers'][$key]['last'];
    }
}

$assetSaya = number_format($totalAsset, 2, ',', '.');


// Pemasukan
$pemasukan_per_hari = array();

$sql = "SELECT DATE(tanggal) AS tanggal, SUM(REPLACE(nominal, '.', '')) AS total_nominal FROM finance_histori WHERE tipe = 'Pemasukan' GROUP BY DATE(tanggal)";
$result1 = $conn->query($sql);

while ($row = $result1->fetch_assoc()) {
    $tanggal = $row['tanggal'];
    $pemasukan_per_hari[$tanggal] = floatval($row['total_nominal']);
}

$pemasukan_chart_data = array();

$timestamp_sekarang = time();
$tanggal_awal_minggu = date('Y-m-d', strtotime('last Monday', $timestamp_sekarang));

for ($i = 0; $i < 7; $i++) {
    $tanggal = date('Y-m-d', strtotime("$tanggal_awal_minggu +$i day"));
    $pemasukan_chart_data[] = isset($pemasukan_per_hari[$tanggal]) ? $pemasukan_per_hari[$tanggal] : 0;
}

$pemasukanJSON = json_encode($pemasukan_chart_data);

// Pengeluaran
$pengeluaran_per_hari = array();

$sql = "SELECT DATE(tanggal) AS tanggal, SUM(REPLACE(nominal, '.', '')) AS total_nominal FROM finance_histori WHERE tipe = 'Pengeluaran' GROUP BY DATE(tanggal)";
$result1 = $conn->query($sql);

while ($row = $result1->fetch_assoc()) {
    $tanggal = $row['tanggal'];
    $pengeluaran_per_hari[$tanggal] = floatval($row['total_nominal']);
}

$pengeluaran_chart_data = array();

$timestamp_sekarang = time();
$tanggal_awal_minggu = date('Y-m-d', strtotime('last Monday', $timestamp_sekarang));

for ($i = 0; $i < 7; $i++) {
    $tanggal = date('Y-m-d', strtotime("$tanggal_awal_minggu +$i day"));
    $pengeluaran_chart_data[] = isset($pengeluaran_per_hari[$tanggal]) ? $pengeluaran_per_hari[$tanggal] : 0;
}

$pengeluaranJSON = json_encode($pengeluaran_chart_data);

// Total Uang
$total_uang_per_hari = array();

$sql = "SELECT DATE(tanggal) AS tanggal, MAX(REPLACE(total_duit, '.', '')) AS total_duit FROM finance_histori GROUP BY DATE(tanggal)";
$result1 = $conn->query($sql);

while ($row = $result1->fetch_assoc()) {
    $tanggal = $row['tanggal'];
    $total_uang_per_hari[$tanggal] = floatval($row['total_duit']);
}

$total_uang_chart_data = array();

$timestamp_sekarang = time();
$tanggal_awal_minggu = date('Y-m-d', strtotime('last Monday', $timestamp_sekarang));

for ($i = 0; $i < 7; $i++) {
    $tanggal = date('Y-m-d', strtotime("$tanggal_awal_minggu +$i day"));
    $total_uang_chart_data[] = isset($total_uang_per_hari[$tanggal]) ? $total_uang_per_hari[$tanggal] : 0;
}

$total_uang_JSON = json_encode($total_uang_chart_data);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle?> - <?= $siteTitle ?></title>

    <?php include'view/css.txt'?>

    <!-- Custom CSS -->
  <link rel="stylesheet" href="./assets/compiled/css/iconly.css">
  <style>
    .coin i {
            font-size: .68rem;
            vertical-align: middle;
        }
        .coin span {
            align-items: center;
            justify-content: center;
        }
        .price {
            font-size: .95rem;
        }
        html[data-bs-theme="dark"] .price {
            font-size: .95rem;
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
            <?php include 'view/navbar.txt'?>
            <div id="main-content">
                <section class="row">
                    <div class="col-12 col-lg-9">
                        <div class="row" id="cryptoTable">
                                    <?php
                                    // Loop melalui data koin dan tampilkan di widget
                                    foreach ($coins as $key => $coin) {
                                        $coinData = $data['tickers'][$key];
                                        $price = 'Rp. ' . number_format($coinData['last'], 0, ',', '.');
                                    
                                        // Hitung persentase perubahan
                                        $change = $coinData['high'] - $coinData['low'];
                                        $changePercent = (($change / $coinData['buy']) * 100);
                                        
                                        // Tentukan kelas CSS berdasarkan perubahan (harga naik atau turun)
                                        $changeClass = $changePercent < 0 ? 'badge bg-danger font-semibold' : 'badge bg-success font-semibold';
                                    ?>
                                    <div class="col-6 col-lg-3 col-md-6">
                                        <div class="card">
                                            <div class="card-body px-4 py-3-5">
                                                <div class="row">
                                                    <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-center">
                                                        <div class="mb-4">
                                                            <img src="<?= $coin['image'] ?>" alt="<?= $coin['name'] ?>" width="60">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7 ps-0 coin">
                                                        <h6 class="font-extrabold"><?= $coin['name'] ?></h6>
                                                        <h1 class="font-semibold mb-2 text-muted price"><?= $price ?></h1>
                                                        <span class="<?= $changeClass ?>"><i class="bi bi-caret-<?= $changePercent < 0 ? 'down' : 'up' ?>-fill"></i> <?= number_format(abs($changePercent), 2) ?>%</span>
                                                    </div>
                                                </div> 
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Statistik Minggu Ini</h4>
                                    </div>
                                    <div class="card-body">
                                        <div id="bar"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3">
                        <div class="card">
                            <div class="card-body py-4 px-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-xl">
                                        <img src="./assets/compiled/jpg/1699242339.gif" draggable="false">
                                    </div>
                                    <div class="ms-3 name">
                                        <h5 class="font-bold">Abi Baydarus</h5>
                                        <h6 class="text-muted mb-0">@bydrz</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                        <div class="card">
                            <div class="card-body px-4 py-3-5">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="font-extrabold mb-0">Total asset crypto 
                                            </h6>
                                            <i class="bi-currency-bitcoin fs-5 mb-0"></i>
                                        </div><h6 class='text-secondary'>Rp. <?= $assetSaya; ?> </h6>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <?php include 'view/footer.txt'?>
        </div>
    </div>

    <?php include'view/js.txt'?>
    
    <!-- Custom JS -->
    <script src="assets/extensions/apexcharts/apexcharts.min.js"></script>
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
                {
                    name: "Uang Saya",
                    data: <?= $total_uang_JSON; ?>,
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
        bar.render();
    </script>
</body>

</html>