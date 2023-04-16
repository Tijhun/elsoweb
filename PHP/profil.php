<?php
    session_start();
        if (!isset($_SESSION['username'])) {
                header("Location: login.php");
                exit();
        	}
// Connect to the database
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "cicakavezo";

	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check for database connection errors
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	// Check if the username form has been submitted
    	if (isset($_POST['new_username'])) {
    		// Get the new username from the form
    		$new_username = $_POST['new_username'];

    		// Check if new username already exists in database
              $sql = "SELECT * FROM users WHERE username = '$new_username'";
              $result = $conn->query($sql);
              if ($result->num_rows > 0) {
                $message = "Ez a felhasználónév már foglalt!";
              } else {

    		// Update the user's username in the database
    		$sql = "UPDATE users SET username='$new_username' WHERE username='" . $_SESSION['username'] . "'";

    		if ($conn->query($sql) === TRUE) {
    			// If the update was successful, update the session variable with the new username
    			$_SESSION['username'] = $new_username;
    			$message = "Sikeresen módosítottad a felhasználónevedet!";
    		} else {
    			// If there was an error updating the database, display an error message
    			$error = "Hiba: " . $sql . "<br>" . $conn->error;
    		}
    	}
    	}

    	// Check if the password form has been submitted
    	if (isset($_POST['new_password'])) {
    		// Get the new password from the form
    		$new_password = $_POST['new_password'];

    		// Update the user's password in the database
    		$sql = "UPDATE users SET password='$new_password' WHERE username='" . $_SESSION['username'] . "'";

    		if ($conn->query($sql) === TRUE) {
    			$message = "Sikeresen módosítottad a jelszavadat!";
    		} else {
    			// If there was an error updating the database, display an error message
    			$error = "Hiba: " . $sql . "<br>" . $conn->error;
    		}
    	}

    	// Close the database connection
    	$conn->close();
?>
<!DOCTYPE html>
  <html lang="hu">
  <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="../CSS/styles.css">
      <title>Fiókom</title>
      <link rel="icon" href="../Képek/catlogo.png" type="image/x-icon">
  </head>
  <body>
    <header class="header">
      <nav>
        <div class="nav_links">
          <ul>
            <li><a href="../index.html">Főoldal</a></li>
            <li><a href="../HTML/Hazirend.html">Házirend</a></li>
            <li><a href="../HTML/Cicak.html">Cicák</a></li>
            <li><a href="../HTML/Foglalas.html">Foglalás</a></li>
            <li><a href="../HTML/Kapcsolatok.html">Kapcsolatok</a></li>
            <li><a href="profil.php" class="active">Fiókom</a></li>
          </ul>
        </div>
      </nav>
    </header>
    <div class="wrapper">
    <h1><?php echo "Üdv " . $_SESSION['username'] . "! ";?></h1>
           <?php if (isset($message)) { echo "<p>" . $message . "</p>"; } ?>
           	<?php if (isset($error)) { echo "<p>" . $error . "</p>"; } ?>
           	<h2>Felhasználói adatok módosítása:</h2>
           	<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
           		<label for="new_username">Új felhasználónév:</label>
           		<input type="text" name="new_username" id="new_username">
           		<br>
           		<input type="submit" value="Módosítás" class id="card" >
           	</form>
           	<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
           		<label for="new_password">Új jelszó:</label>
           		<input type="password" name="new_password" id="new_password">
           		<br>
           		<input type="submit" value="Módosítás" class id="card">
           	</form>
    	<p><a href="logout.php">Kijelentkezés</a></p>
    </div>

  </body>
  </html>