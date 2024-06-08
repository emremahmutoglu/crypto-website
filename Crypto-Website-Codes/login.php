<?php
session_start();
$hostName = "localhost";
$userName = "root";
$password = "12345678";
$dbName = "master";
$message = ""; // Başlangıçta mesaj boş

$conn = new mysqli($hostName, $userName, $password, $dbName);

$_SESSION['user_id'] = $kullanici_id;

if ($conn->connect_error) {
    die("Connection failed: " . $conn.connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);

    $sql = "SELECT * FROM kullanicilar WHERE EPosta = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($password == $user['Sifre']) {
            $_SESSION['logged_in'] = true; // Set the session variable on successful login
            $_SESSION['user_id'] = $user['KullaniciID'];
            $_SESSION['user_name'] = $user['Isim']; // Store user's first name
            $_SESSION['user_surname'] = $user['Soyisim']; // Store user's surname
            echo '<script type="text/javascript"> window.location.href = "http://localhost/m%c3%bch3projem/" </script>';
        } else {
            $message = "<p style='color: red;'>Incorrect email or password</p>";
        }
    } else {
        $message = "<p style='color: red;'>Incorrect email or password</p>";
    }
    $conn->close();


}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap</title>
    <link rel="stylesheet" href="login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <div class="login-container">
        <form class="login-form" action="login.php" method="post">
            <div class="form-header">
                <i class='bx bxs-balloon' style="font-size: 50px;"></i>
                <?php echo $message; // Mesajı burada göster ?>
            </div>
            <div class="input-group">
                <input type="email" name="email" placeholder="E-mail" required>
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="Şifre" required>
            </div>
            <button type="submit">Giriş Yap</button>
        </form>
    </div>
</body>
</html>
