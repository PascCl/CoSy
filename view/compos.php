<?php
	require_once '../header.php';
	require_once '../classes/compo.php';
	?>

		
		<?php
			
			echo "Total tournaments in our database: " . compo::getTotalCompos($database->getConnection()) . "<br><br>";
			
			$result = compo::listCompos($database->getConnection());
			
			echo "<table border = '1' cellpadding = '4'><tr><th width = '200'>Name</th><th width = '200'>Game</th><th width = '200'>Max Teams</th><th width = '200'>Team Size</th><th>Registrations</th></tr>";
			
			if ($result->num_rows > 0) {
				while ($row = $result->fetch_assoc()) {
					$compo = new compo($database->getConnection(), $row['cId']);
					$registrations = $compo->getCompoRegistrations() == 0 ? "Closed" : "Open";
					echo "<tr><td><a href='compo.php?i=" . $row['cId'] . "'>" . $compo->getCompoName() . "</a></td>" .
						"<td>" . $compo->getGameName($database->getConnection()) . "</td>" .
						"<td>" . $compo->getCompoMaxTeams() . "</td>" .
						"<td>" . $compo->getCompoTeamSize() . "</td>" .
						"<td>" . $registrations . "</td></tr>";
				}
			}
			
			echo "</table>";
		
		?>
		
<?php require '../footer.php'; ?>