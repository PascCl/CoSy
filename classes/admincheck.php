<?php

//requires the file /classes/user.php to be included
//do not include it here, include it in the parent file

function adminCheck($conn, $reqPower) {
	
	$error = true;
	
	if (isset($_SESSION['uId'])) {
		$uId = secureInput($conn, $_SESSION['uId']);
		$uPowers = user::getUserPowers($conn, $uId); //returns an array of powers with value true, example: $uPowers[1] == true
		
		//check if the required power is set
		if ($uPowers[$reqPower]) {
			$error = false;
		}
	}
	
	if ($error) {
		include "../classes/log.php";
		echo "Please don't hack my site!<br>
			Actually, do hack my site and contact me when you find something I should fix.";
		session_destroy();
		die();
	} else {
		return true; //user has required power
	}
	
}
	
?>