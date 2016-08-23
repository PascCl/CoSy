<?php 

	session_start();
	
	if (!isset($_SESSION['logged_in'])) {
		$_SESSION['logged_in'] = false;
		$_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'];
		$_SESSION['user_agent'] = (isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : '';
		//don't think we need this
		//header('Location: /index.php');
		//die();
	} else {
		if ($_SESSION['ip_address'] !== $_SERVER['REMOTE_ADDR'] || ($_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT'])) {
			session_destroy();
			header('Location: /index.php');
			die();
		}
	}

?>

<!doctype html>

<html>

	<head>
		<meta charset="utf-8">
		<title>CoSy</title>
		<meta name="description" content="A system that allows you to organise competitions.">
		<meta name="author" content="SitePoint">
		
		<link rel="stylesheet" href="css/style.css">
	</head>
	
	<body>
	
		<?php 
			require_once 'classes/database.php';
			require_once 'classes/secureInput.php';
		?>

	
		<ul>
			<li><a href="/index.php">Home</a></li>
			<li><a href="/view/users.php">Users</a></li>
			<li><a href="/view/compos.php">Tournaments</a></li>
			<?php
			if ($_SESSION['logged_in'] == false) {
				echo '<li><a href="/view/login.php">Login</a></li>
					<li><a href="/view/register.php">Register</a></li>';
			}
			if ($_SESSION['logged_in'] == true) {
				$uName = secureInput($database->getConnection(), $_SESSION['uName']);
				$uPowers[3] = secureInput ($database->getConnection(), $_SESSION['uPowers'][3]);
				if ($uPowers[3]) {
					echo '<li><a href="/view/admin.php">Admin</a></li>';
				}
				echo '<li><a href="/view/profile.php">' . $uName . '</a></li>';
				echo '<li><a href="/view/logout.php">Logout</a></li>';
			}
			?>
		</ul>