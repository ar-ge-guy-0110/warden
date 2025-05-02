<?php
    require_once("generalpagemaster.php");
    if(isset($_SESSION["USER"])){
        unset($_SESSION["USER"]);
        session_destroy();
        $veritaConn = null;
        Redirection();
        exit();
    }
    else{
        $veritaConn = null;
        Redirection();
    }
    $veritaConn = null;
?>