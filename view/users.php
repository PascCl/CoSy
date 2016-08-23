<?php require '../header.php'; ?>
<?php require '../classes/user.php'; ?>

		
		<?php
			
			echo "Total users in our database: " . user::getTotalUsers($database->getConnection()) . "<br><br>";
			
			$result = user::listUsers($database->getConnection());
			
			echo "<table border = '1' cellpadding = '4'><tr><th width = '200'>Name</th><th width = '200'>Steam</th><th width = '200'>League of Legends</th><th width = '200'>Battle.net</th></tr>";
			
			if ($result->num_rows > 0) {
				while ($row = $result->fetch_assoc()) {
					echo "<tr><td><a href='user.php?i=" . $row['uId'] . "'>" . $row['uName'] . "</a></td>" .
						"<td>" . $row['uSteam'] . "</td>" .
						"<td>" . $row['uRiot'] . "</td>" .
						"<td>" . $row['uBlizzard'] . "</td></tr>";
				}
			}
			
			echo "</table>";
		
		?>
		
<?php require '../footer.php'; ?>