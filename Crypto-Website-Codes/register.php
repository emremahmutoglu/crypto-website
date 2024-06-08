<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kayıt Formu</title>
<link rel="stylesheet" href="register.css">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>
<body>
<div class="form-container">
    <form class="registration-form" action="add-person.php" method="post">
        <div class="logo-container">
            <i class='bx bxs-balloon'></i>
        </div>
        <?php
                    if(isset($_GET['temp']))
                    {
                        if($_GET['temp']=="1"){
                        echo"
                        <div class='alert alert-danger'>
                        <strong>Hata!</strong> Bu eposta zaten kayıtlı.
                      </div>
                        ";
                    }
                    elseif($_GET['temp']=="2"){
                        echo"
                        <div class='alert alert-danger'>
                        <strong>Hata!</strong> Girdiğiniz şifreler aynı değil.
                      </div>
                        ";
                    }
                    elseif($_GET['temp']=="3"){
                        echo"
                        <div class='alert alert-danger'>
                        <strong>Hata!</strong> KVKK Aydınlatma metnini onaylayın.
                      </div>
                        ";
                    }
                    elseif($_GET['temp']=="4"){
                        echo"
                        <div class='alert alert-danger'>
                        <strong>Hata!</strong> Kutuyu işaretleyin.
                      </div>
                        ";
                    }
                    };

                    ?>
        <input type="text" name="first-name" placeholder="İsim">
        <input type="text" name="last-name" placeholder="Soyisim">
        <input type="tel" name="phone" placeholder="Telefon Numarası">
        <input type="email" name="email" placeholder="E-mail Adresi">
        <input type="password" name="password" placeholder="Şifre">
        <input type="password" name="password-repeat" placeholder="Şifre Tekrar">
        <div class="checkbox-container">
            <input type="checkbox" name="kvkk">
            <label for="kvkk">KVKK Aydınlatma metnini okudum, onaylıyorum.</label>
        </div>
        <div class="checkbox-container">
            <input type="checkbox" name="marketing">
            <label for="marketing">Tarafıma ticari elektronik ileti gönderilmesini kabul ediyorum.</label>
        </div>
        <button type="submit">Kayıt Ol</button>
    </form>
</div>
</body>
</html>