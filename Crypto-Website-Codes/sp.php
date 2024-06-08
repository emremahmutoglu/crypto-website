<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'database.php'; // Veritabanı bağlantı dosyasını dahil et

$user = null;
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id']; // Kullanıcı ID'sini oturumdan al

    // Kullanıcı bilgilerini almak için sorgu
    $sql = "SELECT profil_resmi FROM kullanicilar WHERE KullaniciID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();

    // Profil resmini oturuma kaydet
    if ($user) {
        $_SESSION['profil_resmi'] = $user['profil_resmi'];
    }
}

// Twelve Data API Key
$apiKey = 'Your Api Key';

// API URL for multiple stocks
$symbols = 'AAPL,MSFT,AMZN,NVDA,GOOGL,TSLA,META'; // You can add more symbols separated by commas
$apiUrl = "https://api.twelvedata.com/quote?symbol=$symbols&apikey=$apiKey";

// Check if it is time to refresh the data
if (!isset($_SESSION['last_api_call']) || time() > $_SESSION['last_api_call'] + 3600) {
    // Update the time of the API call
    $_SESSION['last_api_call'] = time();

    $curl = curl_init($apiUrl);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification in local/testing environment

    $response = curl_exec($curl);

    if ($response === false) {
        $error = curl_error($curl);
        curl_close($curl);
        die('Curl failed: ' . $error);
    }

    curl_close($curl);
    $_SESSION['stock_data'] = json_decode($response, true); // Decoding as an associative array
}

$stockData = $_SESSION['stock_data'] ?? []; // Use the stored stock data or an empty array if not set

// API'den gelen verileri döngü içinde işle
foreach ($stockData as $stock) {
    $stmt = $pdo->prepare("INSERT INTO stocks (symbol, open, high, low, close, previous_close, volume, `change`, percent_change, timestamp) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW()) ON DUPLICATE KEY UPDATE open = VALUES(open), high = VALUES(high), low = VALUES(low), close = VALUES(close), previous_close = VALUES(previous_close), volume = VALUES(volume), `change` = VALUES(`change`), percent_change = VALUES(percent_change), timestamp = NOW()");
    $stmt->execute([
        $stock['symbol'],
        $stock['open'],
        $stock['high'],
        $stock['low'],
        $stock['close'],
        $stock['previous_close'],
        $stock['volume'],
        $stock['change'],
        $stock['percent_change']
    ]);
}

// Bağlantıyı kapat
$pdo = null;
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Sitem - S&P 500</title>
    <link rel="stylesheet" href="index.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="header">
        <div class="sidebar">
            <div class="logo_content">
                <div class="logo">
                    <i class='bx bx-bitcoin'></i>
                    <div class="logo_name">Yatirim Radari</div>
                </div>
                <i class='bx bx-menu' id="btn"></i>
            </div>
            <ul class="nav_list">
                <li>
                    <a href="index.php">
                        <i class='bx bx-home'></i>
                        <span class="links_name">AnaSayfa</span>
                    </a>
                    <span class="tooltip">AnaSayfa</span>
                </li>


                <li>
                    <a href="favoriler.php">
                        <i class='bx bx-star'></i>
                        <span class="links_name">Favoriler</span>
                    </a>
                    <span class="tooltip">Favoriler</span>
                </li>


                <li>
                    <a href="kripto.php">
                        <i class='bx bx-bitcoin'></i>
                        <span class="links_name">Kripto</span>
                    </a>
                    <span class="tooltip">Kripto</span>
                </li>


                <li>
                    <a href="sp.php">
                        <i class='bx bx-candles' ></i>
                        <span class="links_name">S&P500</span>
                    </a>
                    <span class="tooltip">S&P500</span>
                </li>


                <li>
                    <a href="bist.php">
                        <i class="fa-regular fa-money-bill-1"></i>
                        <span class="links_name">FOREX</span>
                    </a>
                    <span class="tooltip">FOREX</span>
                </li>

                <li>
                    <a href="chart/btc.php">
                        <i class='bx bx-line-chart'></i>
                        <span class="links_name">GRAFİK</span>
                    </a>
                    <span class="tooltip">GRAFİK</span>
                </li>

                <li>
                    <a href="forum.php">
                        <i class='bx bx-message'></i>
                        <span class="links_name">Forum</span>
                    </a>
                    <span class="tooltip">Forum</span>
                </li>
                
                <li>
                    <a href="portfoy.php">
                        <i class='bx bx-wallet'></i>
                        <span class="links_name">Portföy</span>
                    </a>
                    <span class="tooltip">Portföy</span>
                </li>
            </ul>
            <div class="profile_content">
                <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
                    <div class="profile">                       
                        <div class="profile_details">
                            <a href="profil_duzenle.php">
                                <img src="<?php echo htmlspecialchars($user['profil_resmi']); ?>" alt="Profil Resmi">
                            </a>
                            <div class="name_job">
                                <div class="name"><?php echo $_SESSION['user_name'] . " " . $_SESSION['user_surname']; ?></div>
                            </div>
                        </div>
                        <a href="logout.php"><i class='bx bx-log-out' id="log_out"></i></a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="home_content">
            <div class="header-buttons">
                <?php if (!isset($_SESSION['logged_in'])): ?>
                    <button onclick="location.href='register.php'">Kayıt Ol</button>
                    <button onclick="location.href='login.php'">Giriş Yap</button>
                <?php endif; ?>
            </div>
            <div class="text">S&P500</div>
            <div class="market-data-container">
                <div class="market-header-row">
                    <div class="market-column-header">Symbol</div>
                    <div class="market-column-header">Open</div>
                    <div class="market-column-header">High</div>
                    <div class="market-column-header">Low</div>
                    <div class="market-column-header">Close</div>
                    <div class="market-column-header">Previous Close</div>
                    <div class="market-column-header">Volume</div>
                    <div class="market-column-header">Change</div>
                    <div class="market-column-header">Change %</div>
                </div>
                <?php if (!empty($stockData)): ?>
                <?php foreach ($stockData as $stock): ?>
                    <div class="market-data-row">
                        <div class="market-data"><?php echo htmlspecialchars($stock['symbol']); ?></div>
                        <div class="market-data">$<?php echo number_format($stock['open'], 2); ?></div>
                        <div class="market-data">$<?php echo number_format($stock['high'], 2); ?></div>
                        <div class="market-data">$<?php echo number_format($stock['low'], 2); ?></div>
                        <div class="market-data">$<?php echo number_format($stock['close'], 2); ?></div>
                        <div class="market-data">$<?php echo number_format($stock['previous_close'], 2); ?></div>
                        <div class="market-data"><?php echo number_format($stock['volume']); ?></div>
                        <div class="market-data">$<?php echo number_format($stock['change'], 2); ?></div>
                        <div class="market-data <?php echo $stock['percent_change'] >= 0 ? 'positive' : 'negative'; ?>">
                            <?php echo number_format($stock['percent_change'], 2); ?>%
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No data available.</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        let btn = document.querySelector("#btn");
        let sidebar = document.querySelector(".sidebar");
        let searchBtn = document.querySelector(".bx-search");

        btn.onclick = function () {
            sidebar.classList.toggle("active");
        }
        searchBtn.onclick = function () {
            sidebar.classList.toggle("active");
        }
    </script>

</body>
</html>
