<?php
    require_once("generalpagemaster.php");
    require_once("funcs_user.php");
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
            isAdmin();
            $action_message = AddUser($_POST["user_name"], $_POST["user_pass"], $_POST["user_tcno"], $_POST["user_email"], $_POST["user_unit"]);
        ?>
        <h2><span><?php echo "<a href='masterpanel2.php'>" . $action_message . "</a>" ?></span></h2>
    </body>
</html>
<?php $databaseConn = null; ?>