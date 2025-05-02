<?php
    //Initialize
    session_start(); ob_start();
    try{
        $databaseConn = new PDO("mysql:host=localhost;dbname=warden;charset=UTF8", "root", "");
    }
    catch(PDOException $err){
        echo $err -> getMessage();
        die();
    }
    //

    //Base Funcs
    function Filter($varr){
        $one = trim($varr);
        $two = strip_tags($one);
        $three = htmlspecialchars($two, ENT_QUOTES);
        return $three;
    }

    function Redirection(){
        $role_0 = "masterpanel.php";
        $role_1 = "userpanel.php";
        $default_page = "login.php";

        if((!isset($_SESSION["USER"])) and (basename($_SERVER['PHP_SELF']) != $default_page)){
            header("Location:" . $default_page);
        }
        else if(isset($_SESSION["USER"])){
            if(($_SESSION["ROLE"] == "2") and (basename($_SERVER['PHP_SELF']) != $role_1)){
                header("Location:" . $role_1);
            }
            else if(($_SESSION["ROLE"] == "0") and (basename($_SERVER['PHP_SELF']) != $role_0)){
                if((basename($_SERVER['PHP_SELF']) == "masterpanel2.php") or (basename($_SERVER['PHP_SELF']) == "masterpanel3.php") or (basename($_SERVER['PHP_SELF']) == "masterpanel4.php")){

                }
                else{
                    header("Location:" . $role_0);
                }
            }
        }

    }

    function isNotLoggedUser(){
        if(!isset($_POST["username"])){
            $databaseConn = null;
            Redirection();
            exit();
        }
    }

    function isAdmin(){
        $role_0 = "masterpanel.php";
        $role_1 = "userpanel.php";
        $default_page = "login.php";

        if((!isset($_SESSION["USER"])) and (basename($_SERVER['PHP_SELF']) != $default_page)){
            header("Location:" . $default_page);
        }

        if($_SESSION["ROLE"] != 0){
            header("Location:" . $default_page);
        }
    }
    //

    //General Settings
    $title = "Warden";
    $generalcss_dir = "warden_css.css";
    $masterpagecss_dir = "warden_css2.css";
    $infopagecss_dir = "warden_css3.css";
    $logo_dir = "There is no logo";
    //
?>