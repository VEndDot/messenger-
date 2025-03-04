<?php
    session_start();

    if(isset($_SESSION['site_userid'])){
        $_SESSION['site_userid'] = NULL;
        unset($_SESSION['site_userid']);
    }

    header('Location: login.php');
    die;
?>