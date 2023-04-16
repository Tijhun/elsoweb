<?php
	// Start the session
	session_start();

	// Unset the session variable
	unset($_SESSION['username']);

	// End the session
	session_destroy();

	// Redirect the user to the login page
	header("Location: login.php");
	exit();
?>