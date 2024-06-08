<?php
session_start();
require 'database.php';

// Kullanıcı bilgilerini almak için sorgu
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if ($user_id) {
    $sql = "SELECT Isim, Soyisim, profil_resmi FROM kullanicilar WHERE KullaniciID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();
}

// Yeni coin eklemek için form gönderildi mi kontrol et
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'add') {
    $coin_id = $_POST['coin_id'];
    $quantity = $_POST['quantity'];
    $cost = $_POST['cost'];

    $sql = "INSERT INTO portfoy (user_id, coin_id, quantity, cost) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id, $coin_id, $quantity, $cost]);

    header("Location: portfoy.php");
    exit;
}

// Kullanıcının portföyündeki coinleri veritabanından çek
$sql = "SELECT p.id, c.name as coin_name, p.quantity, p.cost, c.price as current_price, (c.price * p.quantity - p.cost * p.quantity) as status
        FROM portfoy p
        JOIN coins c ON p.coin_id = c.coin_id
        WHERE p.user_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$portfoy = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portföy</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="portfoy.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    <style>
        .positive {
            color: green;
        }
        .negative {
            color: red;
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
                        <i class='bx bx-candles'></i>
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
            <div class="text" style="font-weight: bolder;">Portföy</div>
            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
            <div class="portfoy-form">
                <h2>Coin Ekle</h2>
                <form method="POST" action="portfoy.php">
                    <input type="hidden" name="action" value="add">
                    <label for="coin_id">Coin Seç:</label>
                    <select name="coin_id" id="coin_id" required>
                        <?php
                        $sql = "SELECT coin_id, name FROM coins";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();
                        $coins = $stmt->fetchAll();
                        foreach ($coins as $coin) {
                            echo "<option value='" . htmlspecialchars($coin['coin_id']) . "'>" . htmlspecialchars($coin['name']) . "</option>";
                        }
                        ?>
                    </select>
                    <label for="quantity">Adet:</label>
                    <input type="number" step="0.00000001" name="quantity" id="quantity" required>
                    <label for="cost">Maliyet:</label>
                    <input type="number" step="0.00000001" name="cost" id="cost" required>
                    <button type="submit">Coin Ekle</button>
                </form>
            </div>
            <div class="portfoy-table">
                <h2>Portföyünüz</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Coin</th>
                            <th>Adet</th>
                            <th>Maliyet</th>
                            <th>Mevcut Fiyat</th>
                            <th>K/Z</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($portfoy as $row): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['coin_name']); ?></td>
                            <td><?php echo htmlspecialchars(number_format($row['quantity'], 3)); ?></td>
                            <td><?php echo htmlspecialchars(number_format($row['cost'], 2)); ?></td>
                            <td><?php echo htmlspecialchars(number_format($row['current_price'], 2)); ?></td>
                            <td class="<?php echo ($row['status'] >= 0) ? 'positive' : 'negative'; ?>">
                                <?php echo htmlspecialchars(number_format($row['status'], 2)); ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php else: ?>
                <p style="text-align: center; font-weight: bold;">Portföyünüzü görmek için lütfen giriş yapın.</p>
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
