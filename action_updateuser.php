<?php
    require_once("generalpagemaster.php");
    require_once("funcs_user.php");
    isAdmin();
    $user_id = Filter($_GET["id"]);
    $user_info = FetchUserInfoById($user_id);
    if($user_id == 1){
        Redirection();
    }
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
                        <form action="action_updateuserresult.php" method="POST">
                            <div class="inputBox">
                                <input type="text" name="user_name" placeholder="Kullanıcı İsmi" value="<?php echo $user_info["kullanici_adi"]; ?>" required>
                                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                            </div>
                            <div class="inputBox">
                                <input type="text" name="user_pass" placeholder="Şifre" value="<?php echo $user_info["sifre"]; ?>" required>
                            </div>
                            <div class="inputBox">
                                <input type="text" name="user_tcno" placeholder="TC Kimlik No" maxlength="11" value="<?php echo $user_info["tc_no"]; ?>" required>
                            </div>
                            <div class="inputBox">
                                <input type="email" name="user_mail" placeholder="E-Posta Adresi" value="<?php echo $user_info["e_posta_adresi"]; ?>" required>
                            </div>
                            <div class="inputBox">
                                <select class="custominput" name="user_unit">
                                    <?php
                                        UnitUpdatingComboBox($user_info["birim_id"]);
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