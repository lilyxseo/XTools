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

    <?php include 'view/css.txt'?>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="./assets/compiled/css/table-datatable-jquery.css">
    <link rel="stylesheet" href="assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
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
            <?php include'view/navbar.txt'?>
            
            <div id="main-content">
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last">
                        <h3>Crypto Market</h3>
                        <p class="text-subtitle text-muted">Explore the latest trends and prices in the crypto market.</p>
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
                </div>
                <!-- Tabel
                <div class="col-12 col-lg-9">
                    <section class="section">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">
                                    Minimal jQuery Datatable
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive datatable-minimal">
                                    <table class="table" id="table2">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Price</th>
                                                <th>Change (24h)</th>
                                                <th>Change (7d)</th>
                                                <th>Volume (24h)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="odd">
                                                <td class="sorting_1">1</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="https://indodax.com/v2/logo/svg/color/btc.svg" alt="Btc" width="23" class="me-2">
                                                        <h6 class="m-0">Bitcoin <span class="text-muted">(BTC)</span></h6>
                                                    </div>
                                                </td>
                                                <td class="font-semibold">Rp. 1.088.885.000</td>
                                                <td class="text-danger font-semibold coin align-items-center">
                                                    <i class="bi bi-caret-down-fill"></i> 33.017.343.162
                                                </td>
                                                <td class="text-success font-semibold coin align-items-center">
                                                    <i class="bi bi-caret-up-fill"></i> 1.088.885.000
                                                </td>
                                                <td class="text-success font-semibold coin align-items-center">
                                                    <i class="bi bi-caret-up-fill"></i> 1.088.886.000
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <!-- end table -->
            </div>

            <?php include 'view/footer.txt'?>
        </div>
    </div>

    <?php include'view/js.txt'?>
    
    <!-- Custom JS -->
    <script src="assets/extensions/jquery/jquery.min.js"></script>
    <script src="assets/extensions/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="assets/static/js/pages/datatables.js"></script>
</body>

</html>
