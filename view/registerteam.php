<?php 
	require '../header.php';
	require '../classes/compo.php'; 
	require '../classes/team.php';
?>


<?php
	
	$compoId = secureInput($database->getConnection(), $_GET['i']);
	$compo = new compo($database->getConnection(), $compoId);
	$registrations = $compo->getCompoRegistrations() == 0 ? "Closed" : "Open";
	
	echo "Name: " . $compo->getCompoName() . "<br>";
	echo "Game: " . $compo->getGameName($database->getConnection()) . "<br>";
	echo "Max Teams: " . $compo->getCompoMaxTeams() . "<br>";
	echo "Team Size: " . $compo->getCompoTeamSize() . "<br>";
	echo "Registrations: " . $registrations;
	echo "<br><br><br>";
	
	echo "<form action='registerteam.php' method='post'>
		";

?>
		
<?php require '../footer.php'; ?>