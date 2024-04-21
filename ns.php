<?php
include 'menu.php';
require 'functions.php';

// var_dump ($historyData);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle?> - <?= $siteTitle ?></title>

    <?php include'view/css.txt'?>

    <!-- Custom CSS  -->
    <link rel="stylesheet" href="./assets/compiled/css/table-datatable-jquery.css">
    <link rel="stylesheet" href="assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css">

    <!-- Meta Tag -->
    <?php include 'view/meta.txt'?>
</head>

<body>
    <script src="assets/static/js/initTheme.js"></script>
    <div id="app">
        <?php include 'view/sidebar.txt'?>
        <div id="main" class='layout-navbar navbar-fixed'>
            <?php include 'view/navbar.txt'?>
            
            <div id="main-content">
                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <h3>Name Server Checker</h3>
                                <p class="text-subtitle text-muted">Date create, expired, registar, and name server
                                    checker
                                </p>
                            </div>
                            <div class="col-12 col-md-6 order-md-2 order-first">
                                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Tools</li>
                                        <li class="breadcrumb-item active" aria-current="page">NS Checker</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>  

                    <section class="section">
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Domain Checker</h4>
                                    </div>
                                    <div class="card-body">
                                        <form method="post" action="">
                                            <div class="form-group mb-3">
                                                <input type="hidden" id="searchDate" name="searchDate"
                                                    value="<?php echo date('Y-m-d H:i'); ?>">
                                                <label for="domains" class="form-label">Masukkan domain (one per
                                                    line):</label>
                                                <textarea class="form-control" id="domains" name="q" rows="10"></textarea>
                                            </div>
                                            <div class="col-sm-12 d-flex justify-content-end">
                                                <button type="submit"
                                                    class="btn btn-outline-primary me-1 mb-1">Submit</button>
                                                <button type="reset" class="btn btn-outline-danger me-1 mb-1"
                                                    onclick="Redirect()">Reset</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Result</h4>
                                </div>
                                <?php
                                if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["q"])) {
                                    $domains = $_POST["q"];
                                    $domainList = preg_split('/\R/', $domains);
                                    $searchDate = $_POST["searchDate"]; // Ambil tanggal pencarian dari input tersembunyi

                                    echo '<div class="card-body" id="domain-info">';
                                    
                                    foreach ($domainList as $domain) {
                                        // Validasi domain sebelum mengirim permintaan
                                        if (preg_match('/^[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $domain)) {
                                            $url = "https://www.whatsmydns.net/api/domain?q=" . urlencode($domain);
                                            $ch = curl_init($url);
                                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                            $response = curl_exec($ch);

                                            if ($response === false) {
                                                echo 'Kesalahan cURL untuk ' . $domain . ': ' . curl_error($ch) . '<br>';
                                            } else {
                                                $jsonData = json_decode($response, true);

                                                if (isset($jsonData['data']['registered']) && $jsonData['data']['registered'] === true) {
                                                    $domainName = $jsonData['data']['domain'];
                                                    
                                                    // Mengambil tanggal pembuatan dalam format timestamp
                                                    $createdTimestamp = strtotime($jsonData['data']['created']);
                                                    // Mengonversi timestamp ke format "tahun, bulan, tanggal, jam"
                                                    $createdDate = date('Y-m-d',$createdTimestamp);
                                                    
                                                    // Mengambil tanggal berakhir dalam format timestamp (perbaikan)
                                                    $expiryTimestamp = strtotime($jsonData['data']['expires']);
                                                    // Mengonversi timestamp ke format "tahun, bulan, tanggal, jam"
                                                    $expiryDate = date('Y-m-d', $expiryTimestamp); // Perbaikan: gunakan $expiryTimestamp

                                                    $registrar = $jsonData['data']['registrar'];

                                                    // Ekstrak "Name Servers" dari respons WHOIS
                                                    $whoisData = $jsonData['data']['whois'];
                                                    $whoisText = implode("\n", $whoisData); // Menggabungkan array menjadi string
                                                    preg_match_all('/Name Server: (.+)$/m', $whoisText, $matches);

                                                    // Mengatur format Name Servers
                                                    $nameServers = '';
                                                    foreach ($matches[1] as $index => $nameServer) {
                                                        $nameServers .= "Name Server " . ($index + 1) . ": " . $nameServer . "<br>";
                                                    }
                                                    // Modifikasi query SQL untuk memeriksa apakah domain sudah ada
                                                    $checkDomainQuery = $conn->prepare("SELECT * FROM domains WHERE domain_name = ?");
                                                    $checkDomainQuery->bind_param("s", $domainName);
                                                    $checkDomainQuery->execute();
                                                    $existingDomain = $checkDomainQuery->get_result()->fetch_assoc();

                                                    if ($existingDomain) {
                                                        // Hapus data lama jika domain sudah ada
                                                        $deleteDomainQuery = $conn->prepare("DELETE FROM domains WHERE domain_name = ?");
                                                        $deleteDomainQuery->bind_param("s", $domainName);
                                                        $deleteDomainQuery->execute();
                                                    }

                                                    // Memasukkan data baru ke dalam tabel domains bersama dengan tanggal pencarian
                                                    $insertQuery = $conn->prepare("INSERT INTO domains (domain_name, created_date, expiry_date, registrar, name_servers, search_date, owner) VALUES (?, ?, ?, ?, ?, ?, ?)");
                                                    $insertQuery->bind_param("sssssss", $domainName, $createdDate, $expiryDate, $registrar, $nameServers, $searchDate, $username);
                                                    $insertQuery->execute();

                                                    // Menampilkan hasil ke layar
                                                    echo "<div class='divider'>";
                                                    echo "<div class='divider-text'>Domain: $domainName</div><br>";
                                                    echo "</div>";
                                                    echo "Created: $createdDate<br>";
                                                    echo "Expired: $expiryDate<br>";
                                                    echo "Registrar: $registrar<br>";
                                                    echo $nameServers;
                                                        } else {
                                                            // Domain tidak terdaftar
                                                            echo "Domain $domain tidak terdaftar<br>";
                                                        }
                                                    }

                                                    curl_close($ch);
                                                } else {
                                                    echo "Format domain tidak valid: $domain<br>";
                                                }
                                            }

                                            echo '</div>'; // Menutup div "card-body"
                                        }
                                        ?>
                                </div>
                            </div>
                        </div>
                    </section>
                <section class="section">
                    <div class="col-12 col-lg-12">
                        <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">
                                History
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table" id="table1">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Domain</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($historyData as $index => $row) { ?>
                                        <tr>
                                            <td><?php echo $index + 1; ?></td>
                                            <td><?php echo $row['domain_name']; ?></td>
                                            <td><?php echo $searchDateWithoutSeconds = date('Y-m-d H:i', strtotime($row['search_date'])); ?></td>
                                            <td>
                                                <button class="btn icon icon-left btn-outline-primary me-2 text-nowrap" data-bs-toggle="modal" data-bs-target="#modal-<?php echo $index; ?>"><i class="bi bi-eye-fill"></i> Show</button>
                                                <button class="btn icon icon-left btn-outline-danger me-2 text-nowrap" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal-<?php echo $index; ?>"><i class="bi bi-x-circle"></i> Remove</button>
                                            </td>
                                        </tr>
                                    <?php } ?>

                                    <?php foreach ($historyData as $index => $row) { ?>
                                        <div class="modal fade text-left" id="modal-<?php echo $index; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="myModalLabel33">Detail Info</h4>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                            <i data-feather="x"></i>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <label for="domain<?php echo $index; ?>">Domain: </label>
                                                        <div class="form-group">
                                                            <input id="domain<?php echo $index; ?>" type="text" placeholder="domain" class="form-control" value="<?php echo $row['domain_name']; ?>" disabled>
                                                        </div>
                                                        <label for="create<?php echo $index; ?>">Create Date: </label>
                                                        <div class="form-group">
                                                            <input id="create<?php echo $index; ?>" type="Create Date" placeholder="Create Date" class="form-control" value="<?php echo $row['created_date']; ?>" disabled>
                                                        </div>
                                                        <label for="expired<?php echo $index; ?>">Expired Date: </label>
                                                        <div class="form-group">
                                                            <input id="expired<?php echo $index; ?>" type="Expired Date" placeholder="Expired Date" class="form-control" value="<?php echo $row['expiry_date']; ?>" disabled>
                                                        </div>
                                                        <label for="registar<?php echo $index; ?>">Registar: </label>
                                                        <div class="form-group">
                                                            <input id="registar<?php echo $index; ?>" type="Registar" placeholder="Registar" class="form-control" value="<?php echo $row['registrar']; ?>" disabled>
                                                        </div>
                                                        <?php 
                                                        $nameServers = $row['name_servers']; // Ambil teks name_servers dari database
                                                        // Ganti tag <br> dengan spasi bawah (newline)
                                                        $nameServers = str_replace('<br>', "\n", $nameServers);
                                                        ?>
                                                        <label for="nameserver<?php echo $index; ?>">Nameserver: </label>
                                                        <div class="form-group">
                                                            <textarea id="nameserver<?php echo $index; ?>" placeholder="Nameserver" class="form-control" disabled rows="4"><?php echo $nameServers; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">
                                                            <span class="d-sm-block">Close</span>
                                                        </button>
                                                    </div>
                                                </div>
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
                                                        <a class="btn btn-danger" href="delete.php?ns=<?php echo $row['id']; ?>">Hapus</a>
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
                </section>
                <?php include'view/footer.txt'; ?>
            </div>
        </div>
    </div>
    <?php include'view/js.txt'?>
    
    <!-- Custom JS  -->
    <script src="assets/extensions/jquery/jquery.min.js"></script>
    <script src="assets/extensions/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        function Redirect() {
            window.location.href = "ns.php"; // Arahkan ke halaman ns.php
        }
    </script>
    <script src="assets/static/js/pages/datatables.js"></script>
</body>

</html>