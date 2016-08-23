<?php

require_once "../header.php";

if ($_SESSION['logged_in'] == true) {
	session_destroy();
	header('Location: /index.php?i=0');
	die();
}

?>