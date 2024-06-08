<?php
session_start();
require 'database.php';

// Kullanıcı bilgilerini almak için sorgu
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM kullanicilar WHERE KullaniciID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();
} else {
    // Eğer kullanıcı oturum açmamışsa giriş sayfasına yönlendir
    header("Location: login.php");
    exit();
}

// Form gönderildiğinde bilgileri güncelleme
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['change_password'])) {
    $isim = $_POST['isim'];
    $soyisim = $_POST['soyisim'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $profil_resmi = $_POST['profil_resmi'];

    // Veritabanında kullanıcı bilgilerini güncelleme
    $sql = "UPDATE kullanicilar SET Isim = ?, Soyisim = ?, phone = ?, EPosta = ?, profil_resmi = ? WHERE KullaniciID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$isim, $soyisim, $phone, $email, $profil_resmi, $user_id]);

    // Güncelleme sonrası kullanıcı bilgilerini yeniden almak
    $sql = "SELECT * FROM kullanicilar WHERE KullaniciID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();

    $success_message = "Profiliniz başarıyla güncellendi.";
}

// Şifre değiştirme işlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    $eski_sifre = $_POST['eski_sifre'];
    $yeni_sifre = $_POST['yeni_sifre'];
    $yeni_sifre_tekrar = $_POST['yeni_sifre_tekrar'];

    // Mevcut şifreyi kontrol et (düz metin olarak)
    if ($eski_sifre === $user['Sifre']) {
        if ($yeni_sifre === $yeni_sifre_tekrar) {
            $sql = "UPDATE kullanicilar SET Sifre = ? WHERE KullaniciID = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$yeni_sifre, $user_id]);
            $success_message = "Şifreniz başarıyla güncellendi.";
            // Kullanıcı bilgilerini yeniden alarak güncelle
            $sql = "SELECT * FROM kullanicilar WHERE KullaniciID = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$user_id]);
            $user = $stmt->fetch();
        } else {
            $error_message = "Yeni şifreler eşleşmiyor.";
        }
    } else {
        $error_message = "Eski şifreniz yanlış.";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Düzenleme</title>
    <link rel="stylesheet" href="profil_duzenle.css">
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
            <div class="form-container">
                <h2>Profil Düzenleme</h2>
                <div class="profile-img-wrapper">
                    <img src="<?php echo htmlspecialchars($user['profil_resmi']); ?>" alt="Profil Resmi" class="profile-img" onclick="document.getElementById('profile-popup').style.display='flex'">
                    <div class="edit-icon"><span>Avatarı Değiştir</span> <i class='bx bx-edit-alt'></i></div>
                </div>
                <?php if (isset($success_message)) : ?>
                    <p><?php echo $success_message; ?></p>
                <?php endif; ?>
                <?php if (isset($error_message)) : ?>
                    <p style="color: red;"><?php echo $error_message; ?></p>
                <?php endif; ?>
                <form action="profil_duzenle.php" method="POST">
                    <div class="form-group">
                        <label for="isim">İsim:</label>
                        <input type="text" name="isim" value="<?php echo htmlspecialchars($user['Isim']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="soyisim">Soyisim:</label>
                        <input type="text" name="soyisim" value="<?php echo htmlspecialchars($user['Soyisim']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Telefon:</label>
                        <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" pattern="\d{11}" required>
                    </div>
                    <div class="form-group">
                        <label for="email">E-posta:</label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($user['EPosta']); ?>" required>
                    </div>
                    <input type="hidden" name="profil_resmi" value="<?php echo htmlspecialchars($user['profil_resmi']); ?>" id="selected-profile-img">
                    <div class="form-group">
                        <button type="submit">Güncelle</button>
                    </div>
                </form>
                <button class="change-password-btn" onclick="document.getElementById('popup').style.display='flex'">Şifreyi Değiştir</button>
            </div>
        </div>
    </div>

    <!-- Profil resmi değiştirme pop-up -->
    <div id="profile-popup" class="popup">
        <div class="popup-content">
            <h3>Profil Resmini Değiştir</h3>
            <div class="profile-images">
                <img src="profil_resimleri/bear.png" alt="Bear" class="profile-option" onclick="selectProfileImage('profil_resimleri/bear.png')">
                <img src="profil_resimleri/bull.png" alt="Bull" class="profile-option" onclick="selectProfileImage('profil_resimleri/bull.png')">
                <img src="profil_resimleri/doge_kahve.jpg" alt="Doge Kahve" class="profile-option" onclick="selectProfileImage('profil_resimleri/doge_kahve.jpg')">
                <img src="profil_resimleri/doge.jpg" alt="Doge" class="profile-option" onclick="selectProfileImage('profil_resimleri/doge.jpg')">
                <img src="profil_resimleri/pepe.jpg" alt="Pepe" class="profile-option" onclick="selectProfileImage('profil_resimleri/pepe.jpg')">
                <img src="profil_resimleri/shiba.png" alt="Shiba" class="profile-option" onclick="selectProfileImage('profil_resimleri/shiba.png')">
            </div>
            <button onclick="document.getElementById('profile-popup').style.display='none'">İptal</button>
        </div>
    </div>

    <!-- Şifre değiştirme pop-up -->
    <div id="popup" class="popup">
        <div class="popup-content">
            <h3>Şifre Değiştir</h3>
            <form action="profil_duzenle.php" method="POST">
                <input type="hidden" name="change_password" value="1">
                <div class="form-group">
                    <label for="eski_sifre">Eski Şifre:</label>
                    <input type="password" name="eski_sifre" required>
                </div>
                <div class="form-group">
                    <label for="yeni_sifre">Yeni Şifre:</label>
                    <input type="password" name="yeni_sifre" required>
                </div>
                <div class="form-group">
                    <label for="yeni_sifre_tekrar">Yeni Şifre (Tekrar):</label>
                    <input type="password" name="yeni_sifre_tekrar" required>
                </div>
                <div class="form-group">
                    <button type="submit">Değiştir</button>
                </div>
            </form>
            <button onclick="document.getElementById('popup').style.display='none'">İptal</button>
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

        function selectProfileImage(imagePath) {
            document.getElementById('selected-profile-img').value = imagePath;
            document.querySelector('.profile-img').src = imagePath;
            document.getElementById('profile-popup').style.display = 'none';
        }
    </script>
</body>
</html>
