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
        <link href="<?php echo $infopagecss_dir ?>" rel="stylesheet">
        <link rel="icon" href="<?php echo $logo_dir ?>">
        <title><?php echo $title ?></title>
    </head>
    <body>
        <?php 
            require_once("generalpagemaster.php");
            isNotLoggedUser();
            $action_message = "";
            
            $action_username = Filter($_POST["username"]);
            $action_pass = Filter($_POST["pass"]);

            $query_control = $databaseConn -> prepare("SELECT * FROM kullanici WHERE kullanici_adi = ? AND sifre = ?");
            $query_control -> execute([$action_username, $action_pass]);
            $control_query = $query_control -> rowCount();
            $user_info = $query_control -> fetch(PDO::FETCH_ASSOC);

            if($control_query > 0){
                $user_role = $user_info["rol"];
                $_SESSION["USER"] = $action_username;
                $_SESSION["ROLE"] = $user_role;
                $_SESSION["UID"] = $user_info["id"];

                Redirection();
            }
            else{
                $action_message = "<a href='login.php'>Gelen Bilgiler ile Eşleşen Kullanıcı Bulunmamaktadır.</a>";
            }

            $databaseConn = null;
        ?>
        <h2><span><?php echo $action_message ?></span></h2>
    </body>
</html>
<?php $databaseConn = null; ?>