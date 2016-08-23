<?php 
	require_once '../header.php';
	require_once '../classes/user.php';
?>

<?php

	$registered = false;
	$name = "";
	$mail = "";
	$phone = "";
	$steam = "";
	$riot = "";
	$blizzard = "";
	
	$nameError = "";
	$mailError = "";
	$phoneError = "";
	$steamError = "";
	$riotError = "";
	$blizzardError = "";
	$passError = "";

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if (!empty($_POST['name'])) {
			$name = secureInput($database->getConnection(), $_POST['name']);
			$nameError = user::validateName($database->getConnection(), $name);
		} else {
			$nameError = "Choose a name.";
		}
		
		if (!empty($_POST['mail'])) {
			$mail = secureInput($database->getConnection(), $_POST['mail']);
			$mailError = user::validateMail($database->getConnection(), $mail);
		}
		 else {
			$mailError = "E-mail address is required.";
		}
		
		if (!empty($_POST['phone'])) {
			$phone = secureInput($database->getConnection(), $_POST['phone']);
			//Phone numbers are currently not validated.
			//Edit classes/user.php for this to work!
			$phoneError = "";
			//$phoneError = user::validatePhone($database->getConnection(), $phone);
		} else {
			//Enable if a phone number is required.
			//$phoneError = "Phone number is required.";
		}
		
		if (!empty($_POST['steam'])) {
			$steam = secureInput($database->getConnection(), $_POST['steam']);
			//Steam is currently not validated.
			//Edit classes/user.php for this to work!
			$steamError = "";
			//$steamError = user::validateSteam($database->getConnection(), $steam);
		} else {
			//Enable if a steam account is required.
			//$steamError = "Steam is required.";
		}
		
		if (!empty($_POST['riot'])) {
			$riot = secureInput($database->getConnection(), $_POST['riot']);
			//Riot is currently not validated.
			//Edit classes/user.php for this to work!
			$riotError = "";
			//$riotError = user::validateRiot($database->getConnection(), $riot);
		} else {
			//Enable if a riot account is required.
			//$riotError = "Summoner Name is required.";
		}
		
		if (!empty($_POST['blizzard'])) {
			$blizzard = secureInput($database->getConnection(), $_POST['blizzard']);
			//Blizzard is currently not validated.
			//Edit classes/user.php for this to work!
			$blizzardError = "";
			//$blizzardError = user::validateBlizzard($database->getConnection(), $blizzard);
		} else {
			//Enable if a Battle.net account is required.
			//$blizzardError = "Battle.net tag is required.";
		}
		
		if (!empty($_POST['pass1']) && !empty($_POST['pass2'])) {
			$pass1 = secureInput($database->getConnection(), $_POST['pass1']);
			$pass2 = secureInput($database->getConnection(), $_POST['pass2']);
			if (strcmp($pass1, $pass2) !== 0) {
				$passError = "Passwords did not match.";
			} else {
				if (strcmp($_POST['pass1'], $pass1) !== 0 || strcmp($_POST['pass2'], $pass2) !== 0) {
					$passError = "Invalid character in password.";
				} else {
					$pass = user::encryptPass($pass1);
				}
			}
		} else {
			$passError = "Password cannot be empty.";
		}
		
		if ($nameError == "" && $mailError == "" && $phoneError == "" && $steamError == "" && $riotError == "" && $blizzardError == "" && $passError == "") {
			$registered = user::saveUser($database->getConnection(), $name, $mail, $phone, $steam, $riot, $blizzard, $pass);
			if ($registered) {
				echo "User registered!";
				$name = "";
				$mail = "";
				$phone = "";
				$steam = "";
				$riot = "";
				$blizzard = "";
			}
		}
		
	}

	if (!$registered) {
		echo "<form action='register.php' method='post'>
		<table>
		<tr><th width='160px'></th><th width='180px'></th><th></th></tr>
		<tr><td>*Name:</td><td><input type='text' name='name' value='$name'></td><td>$nameError</td></tr>
		<tr><td>*E-mail:</td><td><input type='text' name='mail' value='$mail'></td><td>$mailError</td></tr>
		<tr><td>Phone Number:</td><td><input type='text' name='phone' value='$phone'></td><td>$phoneError</td></tr>
		<tr><td>Steam Name:</td><td><input type='text' name='steam' value='$steam'></td><td>$steamError</td></tr>
		<tr><td>LoL Summoner Name:</td><td><input type='text' name='riot' value='$riot'></td><td>$riotError</td></tr>
		<tr><td>Battle.net Tag:</td><td><input type='text' name='blizzard' value='$blizzard'></td><td>$blizzardError</td></tr>
		<tr><td>*Password:</td><td><input type='password' name='pass1'></td><td>$passError</td></tr>
		<tr><td>*Repeat Password:</td><td><input type='password' name='pass2'></td><td></td></tr>
		<tr><td></td><td><input type='submit' value='Register'></td><td></td></tr>
		</table>
		</form>";
	}

?>

<?php require '../footer.php'; ?>