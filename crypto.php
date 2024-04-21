<?php

function get_prices($coin_pairs) {
    $prices = array();
    
    foreach ($coin_pairs as $coin_pair) {
        $url = "https://indodax.com/api/{$coin_pair}/ticker";
        $response = file_get_contents($url);
        
        if ($response !== false) {
            $data = json_decode($response, true);
            if (isset($data['ticker']['last'])) {
                $prices[$coin_pair] = $data['ticker']['last'];
            } else {
                $prices[$coin_pair] = 'Gagal mendapatkan harga';
            }
        } else {
            $prices[$coin_pair] = 'Gagal mendapatkan harga';
        }
    }
    
    return $prices;
}

$coin_pairs = array('btc_idr', 'token_idr', 'doge_idr', 'ondo_idr');  // List pair yang ingin ditampilkan
$prices = get_prices($coin_pairs);

foreach ($prices as $coin_pair => $price) {
    echo "Harga terakhir {$coin_pair}: {$price}<br>";
}

?>
