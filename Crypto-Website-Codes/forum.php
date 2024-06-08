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

// Yeni mesaj veya yanıt gönderildi mi kontrol et
if ($_SERVER["REQUEST_METHOD"] == "POST" && $user_id) {
    $coin_id = $_POST['coin_id'];
    $message = $_POST['message'];
    $reply_to = isset($_POST['reply_to']) ? $_POST['reply_to'] : null;

    $sql = "INSERT INTO forum_messages (user_id, coin_id, message, reply_to) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id, $coin_id, $message, $reply_to]);

    // Form tekrar gönderilmesini önlemek için sayfayı yeniden yönlendir
    header("Location: forum.php");
    exit;
}

// Mevcut mesajları veritabanından çek
$sql = "SELECT fm.id, fm.message, fm.message_date, k.Isim, k.Soyisim, k.profil_resmi, c.name as coin_name, fm.reply_to, fm.coin_id
        FROM forum_messages fm
        JOIN kullanicilar k ON fm.user_id = k.KullaniciID
        JOIN coins c ON fm.coin_id = c.coin_id
        ORDER BY fm.message_date DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$messages = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum</title>
    <link rel="stylesheet" href="forum.css">
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
                <button onclick="location.href='register.php'" style="font-weight: bold;">Kayıt Ol</button>
                <button onclick="location.href='login.php'" style="font-weight: bold;">Giriş Yap</button>
                <?php endif; ?>
            </div>
            <div class="text" style="font-weight: bold;">Forum</div>
            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
            <form method="POST" action="forum.php">
                <label for="coin_id">Coin Seç:</label>
                <select class="coinsec" name="coin_id" id="coin_id" required>
                    <?php
                    // Coinleri veritabanından çek ve seçenek olarak ekle
                    $sql = "SELECT coin_id, name FROM coins";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $coins = $stmt->fetchAll();
                    foreach ($coins as $coin) {
                        echo "<option value='" . htmlspecialchars($coin['coin_id']) . "'>" . htmlspecialchars($coin['name']) . "</option>";
                    }
                    ?>
                </select>
                <label for="message">Mesaj:</label>
                <textarea class="messagekutu" name="message" id="message" required></textarea>
                <input type="hidden" name="reply_to" id="reply_to" value="">
                <button type="submit">Gönder</button>
            </form>
            <?php else: ?>
                <p style="text-align: center; font-weight: bold;">Mesaj yazabilmek için lütfen giriş yapın.</p>
            <?php endif; ?>
            <div class="messages">
                <?php
                function displayMessage($msg, $level = 0) {
                    global $messages;
                    echo "<div class='message' style='margin-left: " . (20 * $level) . "px;'>";
                    echo "<p><strong>" . htmlspecialchars($msg['Isim']) . " " . htmlspecialchars($msg['Soyisim']) . " (" . htmlspecialchars($msg['coin_name']) . ")</strong> - " . htmlspecialchars($msg['message_date']) . "</p>";
                    echo "<p>" . htmlspecialchars($msg['message']) . "</p>";
                    echo "<button class='reply-button' onclick='replyTo(" . $msg['id'] . ", " . $msg['coin_id'] . ")'>Yanıtla</button>";
                    foreach ($messages as $reply) {
                        if ($reply['reply_to'] == $msg['id']) {
                            displayMessage($reply, $level + 1);
                        }
                    }
                    echo "</div>";
                }

                foreach ($messages as $msg) {
                    if ($msg['reply_to'] == null) {
                        displayMessage($msg);
                    }
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

        function replyTo(messageId, coinId) {
            document.getElementById('reply_to').value = messageId;
            document.getElementById('coin_id').value = coinId;
            document.getElementById('message').focus();
        }
    </script>
</body>
</html>
