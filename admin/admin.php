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
	
	echo "<a href='newcompo.php'>Create new tournament</a><br><br>";
	
	echo "Manage Tournaments:<br><br>";
			
	$result = compo::listCompos($database->getConnection());
	
	echo "<table border = '1' cellpadding = '4'><tr><th width = '200'>Name</th><th width = '200'>Game</th><th width = '200'>Max Teams</th><th width = '200'>Team Size</th><th>Registrations</th></tr>";
	
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			$compo = new compo($database->getConnection(), $row['cId']);
			$registrations = $compo->getCompoRegistrations() == 0 ? "Closed" : "Open";
			echo "<tr><td><a href='admincompo.php?i=" . $row['cId'] . "'>" . $compo->getCompoName() . "</a></td>" .
				"<td>" . $compo->getGameName($database->getConnection()) . "</td>" .
				"<td>" . $compo->getCompoMaxTeams() . "</td>" .
				"<td>" . $compo->getCompoTeamSize() . "</td>" .
				"<td>" . $registrations . "</td></tr>";
		}
	}
			
	echo "</table>";
	
	

	
require_once '../footer.php'; ?>