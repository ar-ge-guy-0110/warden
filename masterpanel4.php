<?php
    require_once("generalpagemaster.php");
    require_once("funcs_user.php");
    Redirection();
    $admin = FetchUserInfoById(1);
?>
<!doctype html>
<html lang="tr-TR" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="Content-Language" content="tr">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="<?php echo $masterpagecss_dir ?>" rel="stylesheet">
        <link rel="icon" href="<?php echo $logo_dir ?>">
        <title><?php echo $title ?></title>
    </head>
    <body>
        <!-- Menu -->
        <div class="navigation">
            <ul>
                <li class="list">
                    <a href="masterpanel.php">
                        <span class="icon"><img src="icons/birim.svg"></span>
                        <span class="title">Birim Tanımları</span>
                    </a>
                </li>
                <li class="list">
                    <a href="masterpanel2.php">
                        <span class="icon"><img src="icons/personel.svg"></span>
                        <span class="title">Personel Tanımları</span>
                    </a>
                </li>
                <li class="list">
                    <a href="masterpanel3.php">
                        <span class="icon"><img src="icons/nobet.svg"></span>
                        <span class="title">Nöbet Tanımları</span>
                    </a>
                </li>
                <li class="list active">
                    <a href="masterpanel4.php">
                        <span class="icon"><img src="icons/hesap.svg"></span>
                        <span class="title">Hesap Ayarları</span>
                    </a>
                </li>
                <li class="list">
                    <a href="action_exit.php">
                        <span class="icon"><img src="icons/cikis.svg"></span>
                        <span class="title">Çıkış Yap</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- End Menu -->

        <!-- Canvas -->
        <div class="container">
            <!-- Pillar1 -->
            <div class="box">
                <div class="content">
                    <h2></h2>
                    <p></p>
                    <a href="#"></a>
                </div>
            </div>
            <!-- End Pillar1 -->
            <!-- Pillar2 -->
            <div class="box">
                <div class="content">
                    <h2></h2>
                    <p></p>
                    <a href="#"></a>
                </div>
            </div>
            <!-- End Pillar2 -->
            <!-- Pillar3 -->
            <div class="box">
                <div class="content">
                    <h2></h2>
                    <p></p>
                    <a href="#"></a>
                </div>
            </div>
            <!-- End Pillar3 -->

            <!-- Glass Table -->
            <div class="glass_table_container">
                <h1 class="heading">Birim Tanımları</h1>
                <table class="glass_table">
                    <thead>
                        <tr>
                            <th>Hesap Adı</th>
                            <th>Hesap Şifresi</th>
                            <th>İşlem</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!--
                        <tr>
                            <td data-label="Birim Numarası">1</td>
                            <td data-label="Birim İsmi">Güvenlik</td>
                            <td data-label="İşlem"><a href="#" class="btn">Güncelle</a>&nbsp;<a href="#" class="btn">Sil</a></td>
                        </tr>
                        -->
                        <tr>
                            <form id="addform" action="action_switch.php" method="POST">
                                <td data-label="Hesap Adı"><input type="text" class="custominput" name="admin_name" value="<?php echo $admin["kullanici_adi"]; ?>" placeholder="Hesap Adı"></td>
                                <td data-label="Hesap Şifresi"><input type="text" class="custominput" name="admin_pass" value="<?php echo $admin["sifre"]; ?>" placeholder="Hesap Şifresi"></td>
                                <td data-label="İşlem"><a href="#" onClick="anchorSubmit()" class="btn">Değiştir</a></td>
                            </form>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- End Glass Table-->
        </div>
        <!-- End Canvas -->
        <script>
            const list = document.querySelectorAll('.list');
            function activeLink(){
                list.forEach((item) => 
                item.classList.remove('active')); 
                this.classList.add('active');
            }
            list.forEach((item) => item.addEventListener('click', activeLink));

            function anchorSubmit() {
                document.getElementById("addform").submit();
            }
        </script>
    </body>
</html>