<?php 
	require_once '../header.php';
	require_once '../classes/team.php';
	require_once '../classes/user.php';
?>

	<?php
	
		if (isset($_GET['i'])) {
			$teamId = secureInput($database->getConnection(), $_GET['i']);
		} else {
			die();
			//add logging, should never happen during normal use
			//
		}
		$userId = -1;
		if (isset($_SESSION['uId'])) {
			$userId = secureInput($database->getConnection(), $_SESSION['uId']);
		}
	
		////////////////////////////////////////////////////////
		// Check if new member should be added and add member //
		////////////////////////////////////////////////////////
		
		$allowAddMember = false;
		
		if ($userId != -1) {
			$isLeader = team::getMemberRights($database->getConnection(), $teamId, $userId);
			if ($isLeader > 0) {
				$allowAddMember = true;
			}
		}
		
		if (isset($_POST['username']) && $isLeader) {
			$newMember = secureInput($database->getConnection(), $_POST['username']);
			$newMemberId = user::getUserId($database->getConnection(), $newMember);
			if ($newMemberId) {
				$result = team::addTeamMember($database->getConnection(), $teamId, $newMemberId, "0");
				if ($result) {
					echo "New member added.";
				} else {
					echo "This person is already on a team for this competition.<br><br>";
				}
			} else {
				echo "Wrong name.<br><br>";
			}
		}
		
		
		/////////////////////////
		// Display member list //
		/////////////////////////
		
		$teamInfo = team::getTeamInfo($database->getConnection(), $teamId);
		$teamMembers = team::getMembers($database->getConnection(), $teamId);
		
		$row = $teamInfo->fetch_assoc();
		$teamName = $row['tName'];
		
		
		echo "Team name: " . $teamName . "<br><br>";
		
		echo "Team members:<br>";
		
		while ($row = $teamMembers->fetch_assoc()) {
			$player = new user($database->getConnection(), $row['uId']);
			switch ($row['uRights']) {
				case 0:
					$power = "member";
					break;
				case 1:
					$power = "leader";
					break;
				case 2:
					$power = "owner";
					break;
			}
			echo "Name: " . $player->getUserName() . " - Status: " . $power . "<br>";
		}
		
		
		/////////////////
		// Add Members //
		/////////////////
		
	?><script>
		function findUsers(str) {
			if (str == "") {
				document.getElementById("livesearch").innerHTML = "no suggestions";
				xmlhttp.send();
			} else {
				if (window.XMLHttpRequest) {
					// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp = new XMLHttpRequest();
				} else {
					// code for IE6, IE5
					xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.onreadystatechange = function() {
					if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
						document.getElementById("livesearch").innerHTML = xmlhttp.responseText;
					}
				};
				xmlhttp.open("GET","/classes/livemembersearch.php?q="+str,true);
				xmlhttp.send();
			}
		}
	</script><?php
	
		if ($allowAddMember) {

			echo "<br><br><br>Add members:<br><br>";
			
			echo "<form action='' method='post'>
				<input type='text' name='username' oninput='findUsers(this.value)' list='livesearch'>
				<datalist id='livesearch'></datalist>
				<input type='submit' value='Add Member'>";
				
		}
	
	?>
		
<?php require_once '../footer.php'; ?>