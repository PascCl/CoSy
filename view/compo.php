<?php 
	require_once '../header.php';
	require_once '../classes/compo.php'; 
	require_once '../classes/team.php';
?>


<?php

	if ($_SESSION['logged_in'] == true) {
		
		if (isset($_GET['i'])) {
			$i = secureInput($database->getConnection(), $_GET['i']);
		} else {
			header('Location: /view/compos.php');
		}
		
		$hasTeam = compo::checkIfUserHasTeam($database->getConnection(), $_SESSION['uId'], $i);
		
		if (isset($_GET['j'])) {
			$j = secureInput($database->getConnection(), $_GET['j']);

			if (!$hasTeam) {
				
				if ($j == 1) {
					echo '<script>var teamname = prompt("Enter your team name:");
							if (teamname != null) {
								document.location = "compo.php?i=' . $i . '&j=" + teamname;
							}
						</script>';
				} else {
					$signup = team::saveNewTeam($database->getConnection(), $j, $i, $_SESSION['uId']);
					if ($signup) {
						echo "Your team has been registered.<br><br>";
					} else {
						echo "Team already exists.<br><br>";
					}
				}
			} else {
				echo "You're already in a team for this tournament.<br><br>";
			}
		}
	}
	
	$compoId = secureInput($database->getConnection(), $_GET['i']);
	$compo = new compo($database->getConnection(), $compoId);
	$registrations = $compo->getCompoRegistrations() == 0 ? "Closed" : "Open";
	
	echo "Name: " . $compo->getCompoName() . "<br>";
	echo "Game: " . $compo->getGameName($database->getConnection()) . "<br>";
	echo "Max Teams: " . $compo->getCompoMaxTeams() . "<br>";
	echo "Team Size: " . $compo->getCompoTeamSize() . "<br>";
	echo "Registrations: " . $registrations . " - ";
	if ($registrations == "Open") {
		if ($_SESSION['logged_in'] == true) {
			if ($hasTeam) {
				$userTeamInfo = compo::getUserTeamInfo($database->getConnection(), $_SESSION['uId'], $i);
				$userTeamId = $userTeamInfo[0];
				echo "<a href='team.php?i=$userTeamId'>" . $userTeamInfo[1] . "</a>";
			} else {
				echo "<a href='compo.php?i=$compoId&j=1'>Sign up for this tournament.</a>";
			}
		} else {
			echo "Log in to sign up.";
		}
	}
	echo "<br><br><br>";
	
	
	
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