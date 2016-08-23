<?php 
	require '../header.php';
	require '../classes/user.php'; 
?>


		<?php
			
			$userId = secureInput($database->getConnection(), $_GET['i']);
			$user = new user($database->getConnection(), $userId);
			
			echo "Name: " . $user->getUserName() . "<br>";
			echo "Steam: " . $user->getUserSteam() . "<br>";
			echo "League of Legends: " . $user->getUserRiot() . "<br>";
			echo "Battle.net: " . $user->getUserBlizzard() . "<br>";
		
		?>
		
<?php require '../footer.php'; ?>