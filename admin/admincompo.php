<?php 
	require_once '../header.php';
	require_once '../classes/compo.php'; 
	require_once '../classes/team.php';
	require_once '../classes/user.php'; //required for admincheck
	require_once '../classes/admincheck.php';
?>


<?php

	//check if user can admin this page
	if (!adminCheck($database->getConnection(), 3)) { //change second parameter to required power for this page
		//should never happen, will die in funtion
		include "../classes/log.php";
		session_destroy();
		die();
	}

	//check if a compo is selected
	if (isset($_GET['i'])) {
		$i = secureInput($database->getConnection(), $_GET['i']);
	} else {
		header('Location: ../admin/admin.php');
		die();
	}

	//get some info from database
	$compoId = secureInput($database->getConnection(), $_GET['i']);
	$compo = new compo($database->getConnection(), $compoId);
	$gId = $compo->getGameId();
	
	
	//////////////////////
	// Check Form Input //
	//////////////////////
	
	//general compo info
	
	if (isset($_POST['componame']) && isset($_POST['gId']) && isset($_POST['compoteamsize']) && isset($_POST['compomaxteams'])) {
		$compoName = secureInput($database->getConnection(), $_POST['componame']);
		$gId = secureInput($database->getConnection(), $_POST['gId']);
		$compoTeamSize = secureInput($database->getConnection(), $_POST['compoteamsize']);
		$compoMaxTeams = secureInput($database->getConnection(), $_POST['compomaxteams']);
		
		//maybe add some more checks here?
		//
		
		$update = $compo->updateCompo($database->getConnection(), $compoName, $gId, $compoTeamSize, $compoMaxTeams);
		if ($update) {
			echo "Compo updated.<br><br>";
		} else {
			echo "Something went wrong!<br><br>";
			//add logging
			//
		}
	}
	
	if (isset($_POST['comporegistrations'])) {
		$compoRegistrations = secureInput($database->getConnection(), $_POST['comporegistrations']);
		$update = $compo->setRegistrations($database->getConnection(), $compoRegistrations);
		
		if (!$update) {
			echo "Something went wrong!<br><br>";
			//add logging
			//
		}
	}
	
	
	
	
	///////////////////
	// Display Forms //
	///////////////////
	
	//general compo info
	
	echo "<form method='post'><table>
		<tr><td>Name:</td><td><input type='text' name='componame' value='" . $compo->getCompoName() . "'></td></tr>
		<tr><td>Game: </td><td><select name='gId'>
			<option value='1'" . (($gId == 1) ? 'selected' : '') . ">League of Legends</option>
			<option value='2'" . (($gId == 2) ? 'selected' : '') . ">Counter-Strike: Global Offensive</option>
		</select></td></tr>
		<tr><td>Team size:</td><td><input type='text' name='compoteamsize' value='" . $compo->getCompoTeamSize() . "'></td></tr>
		<tr><td>Max teams:</td><td><input type='text' name='compomaxteams' value='" . $compo->getCompoMaxTeams() . "'></td></tr>
		<tr><td></td><td><input type='submit' value='Save'></td></tr>
		</table></form><br><br>";

	
	//registrations
	
	if ($compo->getCompoRegistrations() == 0) {
		echo "<form method='post'><input type='hidden' name='comporegistrations' value='1'>Registrations closed - <input type='submit' value='Open registrations'>";
	} else {
		echo "<form method='post'><input type='hidden' name='comporegistrations' value='0'>Registrations open - <input type='submit' value='Close registrations'>";
	}
	echo "<br><br><br>";
	
	
	//add team
	
	echo "<form method='post'><table>
		<tr><td>Add team:<td><input type='text' name='addteamname'></td></tr>
		<tr><td></td><td><input type='submit' value='Add team'></td></tr>
		</table></form><br><br>";
		
	
	//list of registered teams
	
	echo "Registered Teams:<br><br>";

	$result = $compo->getTeams($database->getConnection());
	
	echo "<table border = '1' cellpadding = '4'><tr><th width = '200'>Name</th></tr>";
	
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			echo "<tr><td><a href='team.php?i=" . $row['tId'] . "'>" . $row['tName'] . "</a></td></tr>";
		}
	}
	
	echo "</table>";

?>
		
<?php require_once '../footer.php'; ?>