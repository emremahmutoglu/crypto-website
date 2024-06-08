<?php
session_start();
require 'database.php';

// Kullanıcı bilgilerini almak için sorgu
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT Isim, Soyisim, phone, EPosta, profil_resmi FROM kullanicilar WHERE KullaniciID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yatirim Radari</title>
    <link rel="stylesheet" href="index.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <style>

        .green-icon {
            color: #21ce99;
            font-size: 18px;
            padding-left: 10px;
        }

        .red-icon {
            color: red;
            font-size: 18px;
            padding-left: 10px;
        }

        .bit-icon {
            color: yellow;
            font-size: 18px;
            padding-left: 5px;
        }

        .candle-icon {
            color: #21ce99;
            font-size: 18px;
            padding-left: 5px;
        }

        .ates-icon{
            color: red;
            font-size: 24px;
        }

        .dollar-icon {
            color: #21ce99;
            font-size: 18px;
            padding-left: 5px;
        }

        .no-data-message {
            color: white; /* Yazı rengi */
            font-weight: bold; /* Kalın yazı */
            margin: 20px;
            text-align: center; /* Metni ortala */
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
                <button onclick="location.href='register.php'" style="font-weight: bold;">Kayıt Ol</button>
                <button onclick="location.href='login.php'" style="font-weight: bold;">Giriş Yap</button>
                <?php endif; ?>
            </div>
            <div class="text" style="font-weight: bold;">Yatırım Radarı ile Bugünün Fiyatları</div>
            <!-- Add Trending, Top Community Accounts, and Fear & Greed Index sections -->
            <div class="anasayfa">
                <div class="content-slides">
                    <div class="slidedot">
                        <div class="slide active">
                            <span class="kututext"><i class='bx bxl-bitcoin bit-icon' ></i>  KRIPTO</span>
                            <a href="kripto.php" class="more">
                                <span>More</span>
                                <i class='bx bx-chevron-right' style="font-size: 12px;"></i>
                            </a>
                            <!-- Coin bilgileri burada gösterilecek -->
                            <div class="coin-container">
                                <?php
                                // Database bağlantı dosyanızı dahil edin
                                require 'database.php';

                                // SQL sorgusu ile en yüksek saatlik artış gösteren 3 koini al
                                $sql = "SELECT * FROM coins ORDER BY percent_change_1h DESC LIMIT 3";
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute();

                                // Sorgu sonuçlarını kontrol et ve HTML olarak yazdır
                                if ($stmt->rowCount() > 0) {
                                    while ($row = $stmt->fetch()) {
                                        $changeClass = $row["percent_change_1h"] >= 0 ? 'yuzde' : 'yuzdered';
                                        echo "<div class='coin-details'>";
                                        echo "<span class='fiyat'>" . htmlspecialchars($row["name"]) . "</span>";
                                        echo "<span class='$changeClass'>" . number_format($row["percent_change_1h"], 2) . "%</span>";
                                        echo "</div>";
                                    }
                                } else {
                                    echo "<p>Veri bulunamadı.</p>";
                                }
                                ?>
                            </div>
                        </div>

                        <div class="slide">
                            <i class='bx bx-candles candle-icon' ></i><span class="kututext">S&P500</span>
                            <a href="sp.php" class="more">
                                <span>More</span>
                                <i class='bx bx-chevron-right' style="font-size: 12px;"></i>
                            </a>
                            <!-- Coin bilgileri burada gösterilecek -->
                            <div class="coin-container">
                                <?php
                                // Database bağlantı dosyanızı dahil edin
                                require 'database.php';

                                // SQL sorgusu ile en yüksek saatlik artış gösteren 3 hisseyi al
                                $sql = "SELECT * FROM stocks ORDER BY percent_change DESC LIMIT 3";
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute();

                                // Sorgu sonuçlarını kontrol et ve HTML olarak yazdır
                                if ($stmt->rowCount() > 0) {
                                    while ($row = $stmt->fetch()) {
                                        $changeClass = $row["percent_change"] >= 0 ? 'yuzde' : 'yuzdered';
                                        echo "<div class='coin-details'>";
                                        echo "<span class='fiyat'>" . htmlspecialchars($row["symbol"]) . "</span>";
                                        echo "<span class='$changeClass'>" . number_format($row["percent_change"], 2) . "%</span>";
                                        echo "</div>";
                                    }
                                } else {
                                    echo "<p>Veri bulunamadı.</p>";
                                }
                                ?>
                            </div>
                        </div>

                        <div class="slide">
                            <i class="fa-regular fa-money-bill-1 dollar-icon"></i><span class="kututext">FOREX</span>
                            <a href="bist.php" class="more">
                                <span>More</span>
                                <i class='bx bx-chevron-right' style="font-size: 12px;"></i>
                            </a>
                            <!-- Coin bilgileri burada gösterilecek -->
                            <div class="coin-container">
                                <?php
                                // Database bağlantı dosyanızı dahil edin
                                require 'database.php';

                                // SQL sorgusu ile en yüksek saatlik artış gösteren 3 forex değerini al
                                $sql = "SELECT * FROM forex_data ORDER BY percent_change DESC LIMIT 3";
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute();

                                // Sorgu sonuçlarını kontrol et ve HTML olarak yazdır
                                if ($stmt->rowCount() > 0) {
                                    while ($row = $stmt->fetch()) {
                                        $changeClass = $row["percent_change"] >= 0 ? 'yuzde' : 'yuzdered';
                                        echo "<div class='coin-details'>";
                                        echo "<span class='fiyat'>" . htmlspecialchars($row["symbol"]) . "</span>";
                                        echo "<span class='$changeClass'>" . number_format($row["percent_change"], 2) . "%</span>";
                                        echo "</div>";
                                    }
                                } else {
                                    echo "<p>Veri bulunamadı.</p>";
                                }
                                ?>
                            </div>
                        </div>

                        <div class="navigation-dots">
                            <!-- Dots for navigation -->
                            <div class="dot active-dot" onclick="goToSlide(0)"></div>
                            <div class="dot" onclick="goToSlide(1)"></div>
                            <div class="dot" onclick="goToSlide(2)"></div>
                        </div>
                    </div>

                    <div class="ikincikutu" style="float: right;">
                        <img src="kullanimlik2_resized.gif" class="kutuiki" onclick="window.location='haber.php';">
                        <!-- Index details here -->
                    </div>

                    <div class="ucuncukutu" style="float: right;">
                        <span class="kututext">Fear & Greed Index</span>
                        <div class="fearGreedSvg"><?php include 'fear_greed.svg'; ?></div>
                        <div id="indexValue" class="index-value"></div>
                        <div class="index-label" id="index-label"></div>
                        <script src="fng.js"></script>
                    </div>
                </div>
                <div class="yukdus">
                    <div class="dusenler">
                        <i class='bx bx-trending-down red-icon' ></i><span class="yukdustext">Haftanın En Çok Düşenleri</span>
                        <div class="coin-container">
                            <?php
                            // Database bağlantı dosyanızı dahil edin
                            require 'database.php';

                            // SQL sorgusu ile en çok düşen 3 koini al
                            $sql = "SELECT * FROM coins ORDER BY percent_change_7d ASC LIMIT 3";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute();

                            // Sorgu sonuçlarını kontrol et ve HTML olarak yazdır
                            if ($stmt->rowCount() > 0) {
                                while ($row = $stmt->fetch()) {
                                    $changeClass = $row["percent_change_7d"] >= 0 ? 'yuzde' : 'yuzdered';
                                    echo "<div class='coin-details'>";
                                    echo "<span class='fiyat'>" . htmlspecialchars($row["name"]) . "</span>";
                                    echo "<span class='$changeClass'>" . number_format($row["percent_change_7d"], 2) . "%</span>";
                                    echo "</div>";
                                }
                            } else {
                                echo "<p>Veri bulunamadı.</p>";
                            }
                            ?>
                        </div>
                    </div>

                    <div class="yukselenler">
                        <i class='bx bx-trending-up green-icon'></i><span class="yukdustext">Haftanın En Çok Yükselenleri</span>
                        <div class="coin-container">
                            <?php
                            // Database bağlantı dosyanızı dahil edin
                            require 'database.php';

                            // SQL sorgusu ile en çok yükselen 3 koini al
                            $sql = "SELECT * FROM coins ORDER BY percent_change_7d DESC LIMIT 3";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute();

                            // Sorgu sonuçlarını kontrol et ve HTML olarak yazdır
                            if ($stmt->rowCount() > 0) {
                                while ($row = $stmt->fetch()) {
                                    $changeClass = $row["percent_change_7d"] >= 0 ? 'yuzde' : 'yuzdered';
                                    echo "<div class='coin-details'>";
                                    echo "<span class='fiyat'>" . htmlspecialchars($row["name"]) . "</span>";
                                    echo "<span class='$changeClass'>" . number_format($row["percent_change_7d"], 2) . "%</span>";
                                    echo "</div>";
                                }
                            } else {
                                echo "<p>Veri bulunamadı.</p>";
                            }
                            ?>
                        </div>
                    </div>

                    <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
                        <div class="favori-yukselenler">
                            <i class='bx bx-trending-up green-icon'></i><span class="yukdustext">Favorilerden En Çok Yükselenler</span>
                            <a href="favoriler.php" class="more">
                                <span>More</span>
                                <i class='bx bx-chevron-right' style="font-size: 12px;"></i>
                            </a>
                            <div class="coin-container">
                                <?php
                                $user_id = $_SESSION['user_id']; // Kullanıcı ID'sini oturumdan al
                                $sql = "SELECT c.name, c.percent_change_24h
                                        FROM favorites f
                                        JOIN coins c ON f.coin_id = c.coin_id
                                        WHERE f.user_id = ?
                                        ORDER BY c.percent_change_24h DESC
                                        LIMIT 3";
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute([$user_id]);

                                if ($stmt->rowCount() > 0) {
                                    while ($row = $stmt->fetch()) {
                                        $changeClass = $row["percent_change_24h"] >= 0 ? 'yuzde' : 'yuzdered';
                                        echo "<div class='coin-details'>";
                                        echo "<span class='fiyat'>" . htmlspecialchars($row["name"]) . "</span>";
                                        echo "<span class='$changeClass'>" . number_format($row["percent_change_24h"], 2) . "%</span>";
                                        echo "</div>";
                                    }
                                } else {
                                    echo "<p class='no-data-message'>Favorilerinizde veri bulunamadı.</p>";
                                }
                                ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="text2"><i class='bx bxs-hot ates-icon' ></i> POPULER</div>
                    <div class="market-data-container2">
                        <div class="market-header-row"> 
                            <!-- <div class="market-column-header">Favorite</div> -->
                            <div class="market-column-header">Rank</div>
                            <div class="market-column-header">Name</div>
                            <div class="market-column-header">Price</div>
                            <div class="market-column-header">1h %</div>
                            <div class="market-column-header">24h %</div>
                            <div class="market-column-header">7d %</div>
                            <div class="market-column-header">Market Cap</div>
                            <div class="market-column-header">Volume (24h)</div>
                            <div class="market-column-header">Circulating Supply</div>
                        </div>
                        <!-- PHP Kodu Popüler Coinleri Listeleme -->
                        <?php
                            require 'database.php'; // Veritabanı bağlantı dosyasını dahil et

                            $sql = "SELECT c.name, c.price, c.market_cap, c.volume_24h, c.circulating_supply, 
                                    c.percent_change_1h, c.percent_change_24h, c.percent_change_7d, 
                                    COUNT(f.coin_id) AS popularity 
                                    FROM favorites f
                                    JOIN coins c ON f.coin_id = c.coin_id
                                    GROUP BY f.coin_id 
                                    ORDER BY popularity DESC";
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute();

                            $rank = 1; // Sıralama için sayaç başlat

                            if ($stmt->rowCount() > 0) {
                                while ($row = $stmt->fetch()) {
                                    $changeClass1h = $row["percent_change_1h"] >= 0 ? 'positive' : 'negative';
                                    $changeClass24h = $row["percent_change_24h"] >= 0 ? 'positive' : 'negative';
                                    $changeClass7d = $row["percent_change_7d"] >= 0 ? 'positive' : 'negative';
                                    echo "<div class='market-data-row'>";
                                    //echo "<div class='market-data-cell'>" . htmlspecialchars($row["popularity"]) . "</div>";
                                    echo "<div class='market-data'>" . $rank++ . "</div>";
                                    echo "<div class='market-data'>" . htmlspecialchars($row["name"]) . "</div>";
                                    echo "<div class='market-data'>" . number_format($row["price"], 2) . "</div>";
                                    echo "<div class='market-data " . $changeClass1h . "'>" . number_format($row["percent_change_1h"], 2) . "%</div>";
                                    echo "<div class='market-data " . $changeClass24h . "'>" . number_format($row["percent_change_24h"], 2) . "%</div>";
                                    echo "<div class='market-data " . $changeClass7d . "'>" . number_format($row["percent_change_7d"], 2) . "%</div>";
                                    echo "<div class='market-data'>" . number_format($row["market_cap"], 0) . "</div>";
                                    echo "<div class='market-data'>" . number_format($row["volume_24h"], 0) . "</div>";
                                    echo "<div class='market-data'>" . number_format($row["circulating_supply"], 0) . "</div>";
                                    echo "</div>";
                                }
                            } else {
                                echo "<div class='market-data-row'><div class='market-data' colspan='10'>Veri bulunamadı.</div></div>";
                            }
                        ?>
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
            let currentSlide = 0;
            const slides = document.querySelectorAll('.content-slides .slide');
            const dots = document.querySelectorAll('.dot');

            function updateDots(newActive) {
                dots.forEach((dot, index) => {
                    if (index === newActive) {
                        dot.classList.add('active-dot');
                    } else {
                        dot.classList.remove('active-dot');
                    }
                });
            }

            function goToSlide(slideIndex) {
                slides[currentSlide].classList.remove('active');
                slides[slideIndex].classList.add('active');
                currentSlide = slideIndex;
                updateDots(slideIndex);
            }

            function showNextSlide() {
                let nextSlide = (currentSlide + 1) % slides.length;
                goToSlide(nextSlide);
            }

            setInterval(showNextSlide, 3000); // Her 3 saniyede bir sonraki slayta geçiş yap

            // Navigasyon noktaları için event listener ekleme
            dots.forEach((dot, index) => {
                dot.addEventListener('click', () => {
                    goToSlide(index);
                });
            });
        </script>

        <script>
            const dots = document.querySelectorAll('.dot');

            function updateDots(newActive) {
                dots.forEach((dot, index) => {
                    if (index === newActive) {
                        dot.classList.add('active-dot');
                    } else {
                        dot.classList.remove('active-dot');
                    }
                });
            }

            function goToSlide(slideIndex) {
                slides[currentSlide].classList.remove('active');
                slides[slideIndex].classList.add('active');
                currentSlide = slideIndex;
                updateDots(slideIndex);
            }

            setInterval(showNextSlide, 3000); // Existing function to change slides

            function showNextSlide() {
                let nextSlide = (currentSlide + 1) % slides.length;
                goToSlide(nextSlide);
            }

        </script>

        <style>
            @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
        </style>

</body>

</html>
