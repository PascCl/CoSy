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
	$cMaxTeams = "";
	$cTeamSize = "";
	$error = 0;
	
	if (isset($_POST['cName'])) {
		$cName = secureInput($database->getConnection(), $_POST['cName']);
		$error++;
	}
	
	if (isset($_POST['gId'])) {
		$gId = secureInput($database->getConnection(), $_POST['gId']);
		$error++;
	}
	
	if (isset($_POST['cMaxTeams'])) {
		$cMaxTeams = secureInput($database->getConnection(), $_POST['cMaxTeams']);
		if (!is_numeric($cMaxTeams) && $cMaxTeams != "") {
			$error = true;
			echo "Max teams must be a number.<br>";
		} else {
			$error++;
		}
	}
	
	if (isset($_POST['cTeamSize'])) {
		$cTeamSize = secureInput($database->getConnection(), $_POST['cTeamSize']);
		if (!is_numeric($cTeamSize) && $cTeamSize != "") {
			$error = true;
			echo "Team size must be a number.<br>";
		} else {
			$error++;
		}
	}
	
	if ($error != 4) {
		echo "<br>";
	} else {
		$newCompoSuccess = compo::createCompo($database->getConnection(), $cName, $gId, $cMaxTeams, $cTeamSize);
		var_dump($newCompoSuccess);
		if ($newCompoSuccess) {
			header("Location: ../view/admin.php");
		}
	}
	
	echo 'Create new tournament:<br><br>
		<form method="post">
		<table>
		<tr><td>Name: </td><td><input type="text" name="cName" value="' . $cName  . '"></td></tr>
		<tr><td>Game: </td><td><select name="gId">
			<option value="1"' . (($gId == 1) ? "selected" : "") . '>League of Legends</option>
			<option value="2"' . (($gId == 2) ? "selected" : "") . '>Counter-Strike: Global Offensive</option>
		</select></td></tr>
		<tr><td>Max teams:</td><td><input type="text" name="cMaxTeams" value="' . $cMaxTeams . '"></td></tr>
		<tr><td>Team size:</td><td><input type="text" name="cTeamSize" value="' . $cTeamSize . '"></td></tr>
		<tr><td></td><td><input type="submit" value="Create"></td></tr>
		</table></form>';


require_once '../footer.php'; ?>