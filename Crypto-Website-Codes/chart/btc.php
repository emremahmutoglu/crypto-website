<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require '../database.php';

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$coin_id = 1; // BTC coin_id, coins tablosunda Bitcoin için olan ID

$is_favorite = false;
$favorites = [];

if ($user_id) {
    // Kullanıcının tüm favori coinlerini çek
    $stmt = $pdo->prepare("SELECT * FROM favorites WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $favorites = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Mevcut sayfa için favori durumu kontrolü
    foreach ($favorites as $favorite) {
        if ($favorite['coin_id'] == $coin_id) {
            $is_favorite = true;
            break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yatırım Radarı BTC/USDT Grafik</title>
    <link rel="stylesheet" href="chart.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="anasayfa">
        <div class="ust">
            <span class="name">Yatırım Radarı</span>
            <div class="anasayfa-butonu">
                <button onclick="goHome()"><i class='bx bxs-home ev-icon'></i> Ana Sayfa</button>
            </div>        
        </div>

        <div class="sol">
            <div class="koinkutu">
                <div class="baslik">
                    <span class="koin">BTC/USDT</span>
                    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
                        <i class='bx bxs-star favorite-icon' id="favoriteIcon" title="Favorilere Ekle" onclick="toggleFavorite()"></i>
                    <?php endif; ?>
                </div>
                <div class="detaylar">
                    <span class="fiyat" id="livePrice">Yükleniyor...</span>
                    <span class="volume" id="volume">Yükleniyor...</span>
                    <span class="degisimone" id="hourlyChange">Yükleniyor...</span>
                    <span class="degisimtwo" id="dailyChange">Yükleniyor...</span>
                    <span class="degisimthree" id="weeklyChange">Yükleniyor...</span>
                </div>
            </div>
            <div class="time-buttons">
                <button data-interval="1m" onclick="changeInterval('1m')">1m</button>
                <button data-interval="15m" onclick="changeInterval('15m')" class="active">15m</button>
                <button data-interval="1h" onclick="changeInterval('1h')">1h</button>
            </div>
        </div>
        <div class="chart" id="tvchart"></div>

        <div class="section-title">Coinler</div>
        <div class="coin-buttons">
            <button onclick="location.href='btc.php'">BTC/USDT</button>
            <button onclick="location.href='eth.php'">ETH/USDT</button>
            <button onclick="location.href='bnb.php'">BNB/USDT</button>
            <button onclick="location.href='sol.php'">SOL/USDT</button>
            <button onclick="location.href='xrp.php'">XRP/USDT</button>
        </div>

        <?php if (!empty($favorites)): ?>
            <div class="section-title">Favoriler</div>
            <div class="favorite-buttons">
                <?php
                $coinPageMap = [
                    'Bitcoin' => 'btc.php',
                    'Ethereum' => 'eth.php',
                    'BNB' => 'bnb.php',
                    'Solana' => 'sol.php',
                    'XRP' => 'xrp.php'
                ];
                foreach ($favorites as $favorite): 
                    if (!empty($favorite['coin_name'])): ?>
                        <button onclick="location.href='<?php echo $coinPageMap[$favorite['coin_name']]; ?>'">
                            <?php echo strtoupper($favorite['coin_name']); ?>
                        </button>
                    <?php endif; 
                endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <script src="https://unpkg.com/lightweight-charts/dist/lightweight-charts.standalone.production.js"></script>
    <script type="text/javascript" src="btc.js"></script>

    <script>
        function goHome() {
            window.location.href = 'http://localhost/m%c3%bch3projem/index.php';
        }

        let isFavorite = <?php echo $is_favorite ? 'true' : 'false'; ?>;

        function toggleFavorite() {
            const action = isFavorite ? 'remove' : 'add';
            const coinId = <?php echo $coin_id; ?>;
            const coinName = 'Bitcoin'; // Burada coin_name sabit olarak atanmıştır. Diğer coin sayfaları için bu değeri dinamik olarak güncelleyebilirsiniz.

            fetch('favorite.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ coin_id: coinId, coin_name: coinName, action: action })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    isFavorite = !isFavorite;
                    document.getElementById('favoriteIcon').classList.toggle('filled', isFavorite);
                    document.getElementById('favoriteIcon').title = isFavorite ? "Favorilerden Çıkar" : "Favorilere Ekle";
                    location.reload();
                } else if (data.status === 'error') {
                    alert('Lütfen giriş yapınız.');
                }
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            if (isFavorite) {
                document.getElementById('favoriteIcon').classList.add('filled');
                document.getElementById('favoriteIcon').title = "Favorilerden Çıkar";
            } else {
                document.getElementById('favoriteIcon').title = "Favorilere Ekle";
            }
        });
    </script>
</body>
</html>
