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
        'amount' => 161.46623363
    ),
    'ondo_idr' => array(
        'name' => 'Ondo',
        'image' => 'https://indodax.com/v2/logo/svg/color/ondo.svg',
        'amount' => 11.05221801
    ),
    'doge_idr' => array(
        'name' => 'Dogecoin',
        'image' => 'https://indodax.com/v2/logo/svg/color/doge.svg',
        'amount' => 110.6385164
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
function formatRupiah($number) {
    return number_format($number, 0, ',', '.');
}

$assetSaya = formatRupiah($totalAsset);

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



// Kategori form tambah data
// Fetch categories from database for Pengeluaran
$sql = "SELECT DISTINCT kategori FROM finance_histori WHERE tipe = 'Pengeluaran' ORDER BY kategori ASC";
$result = $conn->query($sql);

$pengeluaran = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Gunakan ucwords() untuk mengubah huruf depan menjadi besar
        $row['kategori'] = ucwords(strtolower($row['kategori']));
        $pengeluaran[] = $row;
    }
}

// Fetch categories from database for Pemasukan
$sql = "SELECT DISTINCT kategori FROM finance_histori WHERE tipe = 'Pemasukan' ORDER BY kategori ASC";
$result = $conn->query($sql);

$pemasukan = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Gunakan ucwords() untuk mengubah huruf depan menjadi besar
        $row['kategori'] = ucwords(strtolower($row['kategori']));
        $pemasukan[] = $row;
    }
}

function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Fungsi tambah data
if (isset($_POST["tambahData"])) {
    $judul = clean_input($_POST["judul"]);
    $nominal_input = clean_input($_POST["nominal"]);
    $nominal_angka = str_replace('.', '', $nominal_input);
    $nominal_angka = str_replace(',', '.', $nominal_angka);
    $kategori = clean_input($_POST["kategori"]);
    $keterangan = clean_input($_POST["keterangan"]);
    $jenis = clean_input($_POST["jenis"]);

    $nominalFormatted = number_format($nominal_angka, 0, ',', '.');

    $sql_select_total_uang = "SELECT nominal FROM finance_total";
    $result = $conn->query($sql_select_total_uang);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $totalUang = floatval(str_replace('.', '', $row["nominal"]));
    } else {
        $totalUang = 0;
    }

    if ($jenis == 'Pemasukan') {
        $totalUang += $nominal_angka;
    } elseif ($jenis == 'Pengeluaran') {
        $totalUang -= $nominal_angka;
    }

    $totalUangFormatted = number_format($totalUang, 0, ',', '.');

    $sql_update_total_uang = "UPDATE finance_total SET nominal = '$totalUangFormatted'";
    $conn->query($sql_update_total_uang);

    $sql_insert_transaksi = "INSERT INTO finance_histori (judul, tanggal, nominal, kategori, keterangan, tipe, total_duit) VALUES ('$judul', NOW(), '$nominalFormatted', '$kategori', '$keterangan', '$jenis', '$totalUangFormatted')";
    
    if ($conn->query($sql_insert_transaksi) === TRUE) {
        $success_message = "Data berhasil ditambahkan";
    } else {
        $error_message = "Error: " . $sql_insert_transaksi . "<br>" . $conn->error;
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
  <link rel="stylesheet" href="./assets/compiled/css/iconly.css">
  <link rel="stylesheet" href="assets/extensions/sweetalert2/sweetalert2.min.css">
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
                            <div class="col-12 col-lg-7">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Statistik Minggu Ini</h4>
                                    </div>
                                    <div class="card-body">
                                        <div id="bar"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-5">
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
                                                            <input type="text" class="form-control" id="nominal2" name="nominal" placeholder="500.000" required pattern="[0-9]+(?:\.[0-9]{1,2})?*" required inputmode='numeric'>
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
    <script src="assets/extensions/sweetalert2/sweetalert2.min.js"></script>
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
</body>

</html>