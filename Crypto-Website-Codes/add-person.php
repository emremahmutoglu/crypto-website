<?php
$hostName = "localhost";
$userName = "root";
$password = "12345678";
$dbName = "master";
$conn = new mysqli($hostName, $userName, $password, $dbName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first-name'];
    $last_name = $_POST['last-name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_repeat = $_POST['password-repeat'];
    $kvkk = isset($_POST['kvkk']);
    $marketing = isset($_POST['marketing']);
    $errors = [];

    // Check if the email already exists
    $email_check_query = "SELECT EPosta FROM kullanicilar WHERE EPosta = '$email'";
    $email_check_result = $conn->query($email_check_query);

    if ($email_check_result->num_rows > 0) {
      echo '<script type="text/javascript"> window.location.href = "http://localhost/m%c3%bch3projem/register.php?temp=1" </script>';
      return;
    }

    // Check if passwords match
    if ($password !== $password_repeat) {
      echo '<script type="text/javascript"> window.location.href = "http://localhost/m%c3%bch3projem/register.php?temp=2" </script>';
      return;
    }

    // Check if checkboxes are checked
    if (!$kvkk) {
      echo '<script type="text/javascript"> window.location.href = "http://localhost/m%c3%bch3projem/register.php?temp=3" </script>';
      return;
    }

    // Insert data if no errors
    if (empty($errors)) {
      $sql1= "INSERT INTO kullanicilar (Isim, Soyisim, phone, EPosta, Sifre) VALUES ('".$first_name."', '".$last_name."', '".$phone."', '".$email."', '".$password."')";
        $result1 = $conn->query($sql1);
        echo '<script type="text/javascript"> window.location.href = "http://localhost/m%c3%bch3projem/" </script>';
    } else {
        // Display errors
        foreach ($errors as $error) {
            echo '<div style="color: red; margin-bottom: 10px;">' . $error . '</div>';
        }
    }
}
?>

