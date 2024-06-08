<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Haber Sayfası - Airdrop Haberleri</title>
    <link rel="stylesheet" href="haber.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700&display=swap" rel="stylesheet">
    <style>
        .twitter-icon {
            color: #1A82E3;
            font-size: 24px;
        }

        .globe-icon {
            color: #1A82E3;
            font-size: 24px;
        }

        .discord-icon {
            color: #1A82E3;
            font-size: 24px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <i class='bx bx-bitcoin'></i>
            <div class="logo_name">Kripto Etkinlikleri</div>
        </div>
        <nav>
            <ul>
                <li><a href="index.php"><i class='bx bxs-home ev-icon'></i> Ana Sayfa</a></li>
                <li><a href="haberairdrop.php"><i class="fa-solid fa-fire-flame-curved alev-icon"></i>  Güncel Airdroplar</a></li>
                <li><a href="#" id="openModal"><i class='bx bxs-phone tel-icon'></i> Reklam ve İş Birliği</a></li>
            </ul>
        </nav>
    </div>
    <div class="content">
        <h2>Güncel Airdrop Etkinlikleri</h2>
        <div class="content-container">
            <div class="airdropbir">
                <div class="imagebir">
                    <img src="airdropimg/bubble.png">
                </div>
                <div class="socials">
                    <a href="https://x.com/getbubblecoin" target="_blank"><i class="fa-brands fa-x-twitter twitter-icon"></i></a>
                    <a href="https://bubble.imaginaryones.com/" target="_blank"><i class='bx bx-globe globe-icon' ></i></a>
                    <a href="https://discord.com/invite/io-imaginary-ones" target="_blank"><i class='bx bxl-discord-alt discord-icon'></i></a>
                    <a href="https://opensea.io/collection/io-imaginary-ones" target="_blank"><img src="airdropimg/OpenSea_icon.png" class='opensea'></a>
                </div>
            </div>
            <div class="airdropiki">
                <div class="imageiki">
                    <img src="airdropimg/nyan.png">
                </div>
                <div class="socials">
                    <a href="https://x.com/nyanheroes" target="_blank"><i class="fa-brands fa-x-twitter twitter-icon"></i></a>
                    <a href="https://missions.nyanheroes.com/" target="_blank"><i class='bx bx-globe globe-icon' ></i></a>
                    <a href="https://discord.com/invite/nyanheroesgame" target="_blank"><i class='bx bxl-discord-alt discord-icon'></i></a>
                    <a href="https://opensea.io/collection/nyan-heroes" target="_blank"><img src="airdropimg/OpenSea_icon.png" class='opensea'></a>
                </div>
            </div>
            <div class="airdropuc">
                <div class="imageuc">
                    <img src="airdropimg/param.png">
                </div>
                <div class="socials">
                    <a href="https://x.com/ParamLaboratory" target="_blank"><i class="fa-brands fa-x-twitter twitter-icon"></i></a>
                    <a href="https://paramgaming.com/" target="_blank"><i class='bx bx-globe globe-icon' ></i></a>
                    <a href="https://discord.com/invite/nyanheroesgame" target="_blank"><i class='bx bxl-discord-alt discord-icon'></i></a>
                    <a href="https://opensea.io/PARAMLABS/created" target="_blank"><img src="airdropimg/OpenSea_icon.png" class='opensea'></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Reklam ve İş Birliği</h2>
            <p>Email: emre153mah@gmail.com</p>
            <p>Telefon: 05** *** ** **</p>
        </div>
    </div>

    <script>
        // Modal script
        var modal = document.getElementById("myModal");
        var btn = document.getElementById("openModal");
        var span = document.getElementsByClassName("close")[0];

        btn.onclick = function() {
            modal.style.display = "block";
        }

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
