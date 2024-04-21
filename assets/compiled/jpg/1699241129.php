<!DOCTYPE html>
<html>
<head>
    <title>Check Domain Information</title>
    <link rel="stylesheet" type="text/css" href="https://titisan.gay/assets/style.css"> <!-- Tautan ke berkas CSS -->
    <style>
    /* CSS untuk tombol "Ulangi" */
    button {
        background-color: #ff0000; /* Warna latar merah */
        border-radius: 5px;
        color: #ffffff; /* Warna teks putih */
        border: none; /* Hapus border */
        padding: 10px 20px; /* Spasi dalam tombol */
        cursor: pointer; /* Ubah kursor saat mengarahkan ke tombol */
        transition: background-color 0.3s, color 0.3s; /* Efek transisi saat hover */
    }

    button:hover {
        background-color: #ff5555; /* Warna latar merah yang sedikit berbeda saat hover */
        color: #ffffff; /* Warna teks tetap putih saat hover */
    }
</style>
</head>
<body>
    <h1>Check Domain Information</h1>
    <form method="post" onsubmit="return validateForm()">
        <label for="domains">Enter Domain Names (one per line):</label>
        <?php
        $domains = isset($_POST["q"]) ? $_POST["q"] : "";
        ?>
        <textarea id="domains" name="q" rows="5" cols="40" required><?php echo $domains; ?></textarea>
        <br>
        <input type="submit" value="Check">
        <button type="button" onclick="refreshPage()">Ulangi</button>
    </form>

    <h2>Results:</h2>
    <div id="results"></div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["q"])) {
        $domainList = preg_split('/\R/', $domains);

        foreach ($domainList as $domain) {
            // Validasi domain sebelum mengirim permintaan
            if (preg_match('/^[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $domain)) {
                $url = "https://www.whatsmydns.net/api/domain?q=$domain";
                $ch = curl_init($url);

                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $response = curl_exec($ch);

                if ($response === false) {
                    echo 'Error cURL for ' . $domain . ': ' . curl_error($ch) . '<br>';
                } else {
                    $jsonData = json_decode($response, true);

                    if (isset($jsonData['data']['registered']) && $jsonData['data']['registered'] === true) {
                        // Domain terdaftar
                        echo '<pre>';
                        echo "Domain: " . $jsonData['data']['domain'] . "\n\n";
                        echo "Created: " . $jsonData['data']['created'] . "\n";
                        echo "Expires: " . $jsonData['data']['expires'] . "\n\n";
                        echo "Registrar: " . $jsonData['data']['registrar'] . "\n";

                        $whoisData = $jsonData['data']['whois'];

                        $nameServers = array_filter($whoisData, function ($line) {
                            return strpos($line, 'Name Server:') !== false;
                        });

                        foreach ($nameServers as $nameServer) {
                            echo $nameServer . "\n";
                        }

                        echo '</pre>';
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
    }
    ?>

    <script>
    function refreshPage() {
        // Arahkan pengguna ke halaman "index.html"
        window.location.href = "ns";
    }

    function validateForm() {
        var domains = document.getElementById("domains").value;
        if (domains.trim() === "") {
            alert("Mohon masukkan domain terlebih dahulu.");
            return false; // Mencegah pengiriman formulir jika textarea kosong
        }
        return true; // Lanjutkan pengiriman formulir jika textarea diisi
    }
    </script>
<!-- Code injected by live-server -->
<script>
	// <![CDATA[  <-- For SVG support
	if ('WebSocket' in window) {
		(function () {
			function refreshCSS() {
				var sheets = [].slice.call(document.getElementsByTagName("link"));
				var head = document.getElementsByTagName("head")[0];
				for (var i = 0; i < sheets.length; ++i) {
					var elem = sheets[i];
					var parent = elem.parentElement || head;
					parent.removeChild(elem);
					var rel = elem.rel;
					if (elem.href && typeof rel != "string" || rel.length == 0 || rel.toLowerCase() == "stylesheet") {
						var url = elem.href.replace(/(&|\?)_cacheOverride=\d+/, '');
						elem.href = url + (url.indexOf('?') >= 0 ? '&' : '?') + '_cacheOverride=' + (new Date().valueOf());
					}
					parent.appendChild(elem);
				}
			}
			var protocol = window.location.protocol === 'http:' ? 'ws://' : 'wss://';
			var address = protocol + window.location.host + window.location.pathname + '/ws';
			var socket = new WebSocket(address);
			socket.onmessage = function (msg) {
				if (msg.data == 'reload') window.location.reload();
				else if (msg.data == 'refreshcss') refreshCSS();
			};
			if (sessionStorage && !sessionStorage.getItem('IsThisFirstTime_Log_From_LiveServer')) {
				console.log('Live reload enabled.');
				sessionStorage.setItem('IsThisFirstTime_Log_From_LiveServer', true);
			}
		})();
	}
	else {
		console.error('Upgrade your browser. This Browser is NOT supported WebSocket for Live-Reloading.');
	}
	// ]]>
</script>
</body>
</html>
