<?php
session_start();
require 'database.php';

$apiKey = '79c9eec3-5b9a-4123-927c-e56c61383f76';
$apiUrl = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest';
$headers = [
    'Accepts: application/json',
    'X-CMC_PRO_API_KEY: ' . $apiKey
];

$curl = curl_init($apiUrl);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
$response = curl_exec($curl);

if ($response === false) {
    curl_close($curl);
    die('Curl failed: ' . curl_error($curl));
}

curl_close($curl);
$cryptoData = json_decode($response, true);

if (!empty($cryptoData['data'])) {
    foreach ($cryptoData['data'] as $coin) {
        try {
            $stmt = $pdo->prepare("INSERT INTO coins (coin_id, name, price, percent_change_1h, percent_change_24h, percent_change_7d, market_cap, volume_24h, circulating_supply) VALUES (:coin_id, :name, :price, :percent_change_1h, :percent_change_24h, :percent_change_7d, :market_cap, :volume_24h, :circulating_supply) ON DUPLICATE KEY UPDATE name = :update_name, price = :update_price, percent_change_1h = :update_percent_change_1h, percent_change_24h = :update_percent_change_24h, percent_change_7d = :update_percent_change_7d, market_cap = :update_market_cap, volume_24h = :update_volume_24h, circulating_supply = :update_circulating_supply");

            $stmt->execute([
                ':coin_id' => $coin['id'],
                ':name' => $coin['name'],
                ':price' => $coin['quote']['USD']['price'],
                ':percent_change_1h' => $coin['quote']['USD']['percent_change_1h'],
                ':percent_change_24h' => $coin['quote']['USD']['percent_change_24h'],
                ':percent_change_7d' => $coin['quote']['USD']['percent_change_7d'],
                ':market_cap' => $coin['quote']['USD']['market_cap'],
                ':volume_24h' => $coin['quote']['USD']['volume_24h'],
                ':circulating_supply' => $coin['circulating_supply'],
                // Update values
                ':update_name' => $coin['name'],
                ':update_price' => $coin['quote']['USD']['price'],
                ':update_percent_change_1h' => $coin['quote']['USD']['percent_change_1h'],
                ':update_percent_change_24h' => $coin['quote']['USD']['percent_change_24h'],
                ':update_percent_change_7d' => $coin['quote']['USD']['percent_change_7d'],
                ':update_market_cap' => $coin['quote']['USD']['market_cap'],
                ':update_volume_24h' => $coin['quote']['USD']['volume_24h'],
                ':update_circulating_supply' => $coin['circulating_supply']
            ]);
        } catch (PDOException $e) {
            echo "Veritabanı hatası: " . $e->getMessage();
        }
    }
} else {
    echo "API'dan veri çekilemedi.";
}
?>
