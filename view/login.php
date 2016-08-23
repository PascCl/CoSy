<?php

require_once '../header.php';
require_once '../classes/user.php';


$name = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (!empty($_POST['name']) && !empty($_POST['pass'])) {
		$name = secureInput($database->getConnection(), $_POST['name']);
		$pass = secureInput($database->getConnection(), $_POST['pass']);
		$uId = user::checkLogin($database->getConnection(), $name, $pass);
		$uPowers = user::getUserPowers($database->getConnection(), $uId);
		if ($uId != 0) {
			$_SESSION['logged_in'] = true;
			$_SESSION['uId'] = $uId;
			$_SESSION['uName'] = $name;
			$_SESSION['uPowers'] = $uPowers; //only use this to show menu options - always check database for any actions that require powers!
			echo "You are now logged in!";
			header('Location: /index.php?i=1');
			exit;
		}
	}
	echo "Wrong name or password.";
}

if ($_SESSION['logged_in'] == false) {
	echo "<form action='login.php' method='post'>
		<table>
		<tr><th width='160px'></th><th width='180px'></th><th></th></tr>
		<tr><td>Name:</td><td><input type='text' name='name' value='$name'></td></tr>
		<tr><td>Password:</td><td><input type='password' name='pass'></td></tr>
		<tr><td></td><td><input type='submit' value='Login'></td></tr>
		</table>
		</form>";
}


require_once '../footer.php'; ?>