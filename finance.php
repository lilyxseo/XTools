<?php
include 'menu.php';
require 'functions.php';

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
                        <h3>Lorem, ipsum.</h3>
                        <p class="text-subtitle text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab, cumque!</p>
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
                            <div class="col-12 col-lg-4 col-md-4 col-xl-4">
                                <div class="card">
                                    <div class="card-body px-4 py-3-5">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h6 class="font-extrabold mb-0">Total uang kamu 
                                                    </h6>
                                                    <i class="bi-bank2 fs-5 mb-0"></i>
                                                </div>
                                                <h6 class="text-secondary">Rp. 3.500.000</h6>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                            <!-- Card Pemasukan -->
                            <div class="col-6 col-lg-3 col-md-6">
                                <div class="card">
                                    <div class="card-body px-4 py-3-5">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h6 class="font-extrabold mb-0">Pemasukan 
                                                    </h6>
                                                    <i class="bi-arrow-up-right text-success fs-5 mb-0"></i>
                                                </div>
                                                <h6 class="text-success">Rp. 3.500.000</h6>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                            <!-- Card Pengeluaran -->
                            <div class="col-6 col-lg-3 col-md-6">
                                <div class="card">
                                    <div class="card-body px-4 py-3-5">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h6 class="font-extrabold mb-0">Pengeluaran 
                                                    </h6>
                                                    <i class="bi-arrow-down-right text-danger fs-5 mb-0"></i>
                                                </div>
                                                <h6 class="text-danger">Rp. 3.500.000</h6>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Chart Statistik -->
                            <div class="col-12 col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Statistik Pemasukan</h4>
                                    </div>
                                    <div class="card-body">
                                        <div id="chart"></div>
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
                                                <tr>
                                                    <td class="d-none">1</td>
                                                    <td>
                                                        <div class="card mb-3">
                                                            <div class="card-body p-1 pb-0">
                                                                <div class="row align-items-center">
                                                                    <div class="col-auto">
                                                                        <div class="stats-icon bg-success mb-2">
                                                                            <i class="bi-cash fs-4"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <h6 class="mb-0">Gajian</h6>
                                                                        <p class="text-muted text-sm mb-1">8 Mei 2024</p>
                                                                    </div>
                                                                    <div class="col-auto">
                                                                        <p class="mb-0 text-success">+ Rp. 700.000</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="d-none">2</td>
                                                    <td>      
                                                        <div class="card mb-3">
                                                            <div class="card-body p-1 pb-0">
                                                                <div class="row align-items-center">
                                                                    <div class="col-auto">
                                                                        <div class="stats-icon bg-danger mb-2">
                                                                            <i class="bi-cake fs-4"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <h6 class="mb-0">Jajan</h6>
                                                                        <p class="text-muted text-sm mb-1">9 Mei 2024</p>
                                                                    </div>
                                                                    <div class="col-auto">
                                                                        <p class="mb-0 text-danger">- Rp. 100.000</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="d-none">3</td>
                                                    <td>
                                                        <div class="card mb-3">
                                                            <div class="card-body p-1 pb-0">
                                                                <div class="row align-items-center">
                                                                    <div class="col-auto">
                                                                        <div class="stats-icon bg-success mb-2">
                                                                            <i class="bi-cash fs-4"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <h6 class="mb-0">Bonus</h6>
                                                                        <p class="text-muted text-sm mb-1">9 Mei 2024</p>
                                                                    </div>
                                                                    <div class="col-auto">
                                                                        <p class="mb-0 text-success">+ Rp. 200.000</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
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
    <script src="assets/extensions/apexcharts/apexcharts.min.js"></script>
    <script src="assets/extensions/jquery/jquery.min.js"></script>
    <script src="assets/extensions/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="assets/static/js/pages/datatables.js"></script>
    <script>
        var barOptions = {
        series: [
            {
            name: "Pemasukan",
            data: [44, 55, 57, 56, 61, 58, 212],
            },
            {
            name: "Pengeluaran",
            data: [76, 85, 101, 98, 87, 105, 120],
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
            var bar = new ApexCharts(document.querySelector("#chart"), barOptions);

            bar.render();

    </script>
</body>

</html>