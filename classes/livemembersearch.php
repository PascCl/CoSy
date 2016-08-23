<?php

	require_once '../classes/database.php';
	require_once '../classes/secureinput.php';
	require_once '../classes/user.php';

	//get the q parameter from URL
	$q = $_GET["q"];
	$q = secureInput($database->getConnection(), $_GET["q"]);

	// or to the correct values
	if (strlen($q) == 0) {
		$response= "no suggestions";
	} else {
		$result = user::getSuggestions($database->getConnection(), $q);
		if ($result) {
				if (mysqli_num_rows($result) > 0) {
				$response = "";
				while ($row = $result->fetch_assoc()) {
					$response = $response . "<option value = '" . $row['uName'] . "'/>";
				}
			} else {
				$response= "no suggestions";
			}
		} else {
			$response = "Looks like something went wrong!";
		}
	}

	//output the response
	echo $response;

?>