<?php 
	require_once '../header.php';
	require_once '../classes/user.php';
	require_once '../classes/compo.php';
	require_once '../classes/admincheck.php';

	
	//check if user can admin this page
	if (!adminCheck($database->getConnection(), 3)) { //change second parameter to required power for this page
		//should never happen, will die in funtion
		include "../classes/log.php";
		session_destroy();
		die();
	}
	
	
	$cName = "";
	$gId = 1;
	$error = false;
	
	if (isset($_POST['cName'])) {
		$cName = secureInput($database->getConnection(), $_POST['cName']);
	} else {
		$error = true;
	}
	
	if (isset($_POST['gId'])) {
		$gId = secureInput($database->getConnection(), $_POST['gId']);
	} else {
		$error = true;
	}
	
	echo 'Create new tournament:<br><br>
		<form method="post">
		<table>
		<tr><td>Name: </td><td><input type="text" name="cName" value="' . $cName  . '"></td></tr>
		<tr><td>Game: </td><td><select name="gId">
			<option value="1"' ($gId == 1) ? "selected" : "";'>League of Legends</option>
			<option value="2">Counter-Strike: Global Offensive</option>
		</select></td></tr>
		<tr><td>Max teams:</td><td><input type="text" name="cMaxTeams"></td></tr>
		<tr><td>Team size:</td><td><input type="text" name="cTeamSize"></td></tr>
		<tr><td></td><td><input type="submit" value="Create"></td></tr>
		</table></form>';


require_once '../footer.php'; ?>