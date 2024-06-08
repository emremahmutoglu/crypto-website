<?php
session_start();

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header("Location: login.php");
    exit;
}

require 'database.php';  // Veritabanı bağlantı ayarlarını içeren dosya

$user_id = $_SESSION['user_id']; // Kullanıcı ID'sini oturumdan al

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Kullanıcı bilgilerini almak için sorgu
$sql = "SELECT profil_resmi FROM kullanicilar WHERE KullaniciID = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$user = $stmt->fetch();

// Favori coinleri almak için sorgu
$stmt = $pdo->prepare("SELECT coins.* FROM favorites JOIN coins ON favorites.coin_id = coins.coin_id WHERE favorites.user_id = ?");
$stmt->execute([$user_id]);
$favorites = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Sitem</title>
    <link rel="stylesheet" href="index.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

    <style>
        .bxs-star {
            color: gold; /* Sarı renk yıldız */
        }
    </style>

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
            <div class="text">Favoriler</div>
            <div class="market-data-container">
                <div class="market-header-row">
                <div class="market-column-header">Favorite</div>
                    <div class="market-column-header">#</div>
                    <div class="market-column-header">Name</div>
                    <div class="market-column-header">Price</div>
                    <div class="market-column-header">1h %</div>
                    <div class="market-column-header">24h %</div>
                    <div class="market-column-header">7d %</div>
                    <div class="market-column-header">Market Cap</div>
                    <div class="market-column-header">Volume (24h)</div>
                    <div class="market-column-header">Circulating Supply</div>
                </div>
                <?php if (!empty($favorites)): ?>
                    <?php $counter = 1; ?>
                    <?php foreach ($favorites as $favorite): ?>
                        <div class="market-data-row">
                            <div class="market-data"><i class='bx bxs-star' id="star<?php echo $counter; ?>" onclick="toggleStar(<?php echo $counter; ?>, '<?php echo $favorite['coin_id']; ?>');"></i></div>
                            <div class="market-data"><?php echo $counter++; ?></div>
                            <div class="market-data"><?php echo htmlspecialchars($favorite['name']); ?></div>
                            <div class="market-data">$<?php echo number_format($favorite['price'], 2); ?></div>
                            <div class="market-data <?php echo ($favorite['percent_change_1h'] >= 0) ? 'positive' : 'negative'; ?>">
                                <?php echo number_format($favorite['percent_change_1h'], 2); ?>%
                            </div>
                            <div class="market-data <?php echo ($favorite['percent_change_24h'] >= 0) ? 'positive' : 'negative'; ?>">
                                <?php echo number_format($favorite['percent_change_24h'], 2); ?>%
                            </div>
                            <div class="market-data <?php echo ($favorite['percent_change_7d'] >= 0) ? 'positive' : 'negative'; ?>">
                                <?php echo number_format($favorite['percent_change_7d'], 2); ?>%
                            </div>
                            <div class="market-data">$<?php echo number_format($favorite['market_cap']); ?></div>
                            <div class="market-data">$<?php echo number_format($favorite['volume_24h']); ?></div>
                            <div class="market-data"><?php echo number_format($favorite['circulating_supply']); ?></div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Favorileriniz boş.</p>
                <?php endif; ?>
            </div>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            updateData();
        });

        function updateData() {
            fetch('fetch_data.php')
            .then(response => response.text())
            .then(data => {
                // Veriler güncellendiğinde yapılacak işlemler burada yer alabilir.
                console.log('Veriler güncellendi: ' + data);
            })
            .catch(error => {
                console.error('Veri güncelleme hatası: ' + error);
                // Kullanıcıya hata mesajını gösterecek kod burada yer alabilir.
            });
        }
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        function toggleStar(index, coinId) {
            var star = document.getElementById('star' + index);
            var action = star.classList.contains('bxs-star') ? 'remove' : 'add'; // Yıldız doluysa çıkarılacak, boşsa eklenecek.

            star.classList.toggle('bx-star');
            star.classList.toggle('bxs-star');

            // AJAX kullanarak favori durumunu backend'e gönder
            $.post('update_favorites.php', {coin_id: coinId, action: action}, function(response) {
                console.log(response); // İsteğin sonucunu konsola log'la
            });
        }   
    </script>






</body>

</html>