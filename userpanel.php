<?php
    require_once("generalpagemaster.php");
    require_once("funcs_watch.php");
    Redirection();
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
        <div class="container">

        <div class="glass_table_container">
                <h1 class="heading">Nöbet Tarihleriniz</h1>
                <table class="glass_table">
                    <thead>
                        <tr>
                            <th>Nöbet Numarası</th>
                            <th>Başlangıç Tarihi</th>
                            <th>Bitiş Tarihi</th>
                            <th>Nöbetçi</th>
                            <th>Birimi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php PersonalWatchTable($_SESSION["UID"]); ?>
                    </tbody>
                </table>
            </div>
        </div>
        <a href="action_exit.php" class="btn">Çıkış Yap</a>
    </body>
</html>
<?php $databaseConn = null; ?>