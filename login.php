<?php
    require_once("generalpagemaster.php");
    Redirection();
?>
<!doctype html>
<html lang="tr-TR" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="Content-Language" content="tr">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="<?php echo $generalcss_dir ?>" rel="stylesheet">
        <link rel="icon" href="<?php echo $logo_dir ?>">
        <title><?php echo $title ?></title>
    </head>
    <body>
        <section>
            <div class="color"></div>
            <div class="color"></div>
            <div class="color"></div>
            <div class="box">
                <div class="square" style="--i:0;"></div>
                <div class="square" style="--i:1;"></div>
                <div class="square" style="--i:2;"></div>
                <div class="square" style="--i:3;"></div>
                <div class="square" style="--i:4;"></div>
                <div class="container">
                    <div class="form">
                        <h2>Warden</h2>
                        <form action="action_login.php" method="POST">
                            <div class="inputBox">
                                <input type="text" name="username" placeholder="Kullanıcı Adı" required>
                            </div>
                            <div class="inputBox">
                                <input type="password" name="pass" placeholder="Şifre" required>
                            </div>
                            <div class="inputBox">
                                <input type="submit" value="Giriş Yap">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>
<?php $databaseConn = null; ?>