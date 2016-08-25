<?php require '../header.php'; ?>

	<?php
	
		if (isset($_GET['i'])) {
			if ($_GET['i'] == 1) {
				echo "You are now logged in.<br><br>";
			}
		}
	
	?>

	Hello,<br><br>
	Not much to see on this page.
		
<?php require '../footer.php'; ?>