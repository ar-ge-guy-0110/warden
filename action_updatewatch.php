<?php
    require_once("generalpagemaster.php");
    require_once("funcs_watch.php");
    isAdmin();
    $watch_id = Filter($_GET["id"]);
    $watch_info = FetchWatchInfoById($watch_id);
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
                <div class="container">
                    <div class="form">
                        <h2>Güncellemek İçin Alanları Doldurun.</h2>
                        <form action="action_updatewatchresult.php" method="POST">
                            <div class="inputBox">
                                <input type="datetime-local" name="watch_start" placeholder="Başlangıç Tarihi" value="<?php echo $watch_info["baslangic"]; ?>" required>
                                <input type="hidden" name="watch_id" value="<?php echo $watch_id; ?>">
                            </div>
                            <div class="inputBox">
                                <input type="datetime-local" name="watch_end" placeholder="Bitiş Tarihi" value="<?php echo $watch_info["bitis"]; ?>" required>
                            </div>
                            <div class="inputBox">
                                <select class="custominput" name="watch_warden">
                                    <?php
                                        WardenUpdatingComboBox($watch_info["kullanici_id"]);
                                    ?>
                                </select>
                            </div>
                            <div class="inputBox">
                                <input type="submit" value="Güncelle">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>
<?php $databaseConn = null; ?>