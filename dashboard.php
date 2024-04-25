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
    ),
    'token_idr' => array(
        'name' => 'TokeFI',
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
                                    <h4>Profile Visit</h4>
                                </div>
                                <div class="card-body">
                                    <div id="chart-profile-visit"></div>
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
            </section>
            </div>

            <?php include 'view/footer.txt'?>
        </div>
    </div>

    <?php include'view/js.txt'?>
    
    <!-- Custom JS -->
    <script src="assets/extensions/apexcharts/apexcharts.min.js"></script>
    <script src="assets/static/js/pages/dashboard.js"></script> 
</body>

</html>