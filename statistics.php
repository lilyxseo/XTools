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
    <link rel="stylesheet" href="assets/extensions/flatpickr/flatpickr.min.css">
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
                            <div class="col-12 col-lg-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Data Pengeluaran</h4>
                                    </div>
                                    <div class="card-body">
                                        <div id="pie"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Chart Statistik -->
                            <div class="col-12 col-lg-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Tambah data</h4>
                                    </div>
                                    <div class="card-body">
                                        <form action="process_data.php" method="POST">
                                            <div class="mb-3">
                                                <label for="judul" class="form-label">Judul:</label>
                                                <input type="text" class="form-control" id="judul" name="judul" placeholder="Gajian" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="nominal" class="form-label">Nominal:</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">Rp.</span>
                                                    <input type="text" class="form-control" id="nominal1" name="nominal" placeholder="1.000.000" required pattern="[0-9]*" required>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="keterangan" class="form-label">Keterangan:</label>
                                                <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Gajian bulan ini" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Jenis:</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="jenis" id="pemasukan" value="pemasukan" checked>
                                                    <label class="form-check-label" for="pemasukan">Pemasukan</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="jenis" id="pengeluaran" value="pengeluaran">
                                                    <label class="form-check-label" for="pengeluaran">Pengeluaran</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 d-flex justify-content-end mt-3">
                                                <button type="submit" class="btn btn-outline-primary me-1 mb-1">Tambah Data</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Pilih Tanggal</h4>
                                    </div>
                                    <div class="card-body">
                                        <form method="get">
                                            <input type="text" name="date" class="form-control flatpickr-range mb-3 flatpickr-input" placeholder="Select date.." readonly="readonly">
                                            <div class="col-sm-12 d-flex justify-content-end mt-3">
                                                <button type="submit" name="site_submit" class="btn btn-outline-primary me-1 mb-1">Kirim</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Uang saat ini</h4>
                                    </div>
                                    <div class="card-body">
                                        <form method="get">
                                            <div class="mb-3">
                                                <label for="nominal" class="form-label">Nominal:</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">Rp.</span>
                                                    <input type="text" class="form-control" id="nominal2" name="nominal" placeholder="1.000.000" value="3.500.000" required pattern="[0-9]*" required>
                                                </div>
                                                <div class="col-sm-12 d-flex justify-content-end mt-3">
                                                    <button type="submit" name="site_submit" class="btn btn-outline-primary me-1 mb-1">Kirim</button>
                                                </div>
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
                                                <tr>
                                                    <td class="d-none">1</td>
                                                    <td>
                                                        <div class="card mb-3">
                                                            <div class="card-body p-1 pb-0">
                                                                <div class="row align-items-center">
                                                                    <div class="col-auto">
                                                                        <div class="stats-icon bg-success mb-2">
                                                                            <i class="bi-arrow-up-right fs-4"></i>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <h6 class="mb-0">THR</h6>
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
                                                                            <i class="bi-arrow-down-right fs-4"></i>
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
                                                                            <i class="bi-arrow-up-right fs-4"></i>
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
          series: [25, 15, 44, 55, 41, 17, 12],
          chart: {
          width: '100%',
          type: 'pie',
        },
        labels: ["Sen", "Sel", "Rab", "Kam", "Jum", "Sab", "Min"],
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