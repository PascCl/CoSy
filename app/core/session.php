<?php 

    session_start();

    if (!isset($_SESSION['logged_in'])) {
            $_SESSION['logged_in'] = false;
            $_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'];
            $_SESSION['user_agent'] = (isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : '';
    } else {
            if ($_SESSION['ip_address'] !== $_SERVER['REMOTE_ADDR'] || ($_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT'])) {
                    session_destroy();
                    header('Location: view/index.php');
                    die();
            }
    }

?>