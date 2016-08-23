<?php

function secureInput($conn, $data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	$data = $conn->real_escape_string($data);
	return $data;
}

?>