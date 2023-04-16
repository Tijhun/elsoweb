<?php
session_start();
if (isset($_SESSION['username'])) {
        		header("Location: profil.php");
                	exit();
        	}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get form data
  $username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
  $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);

  // Connect to database
  $servername = "localhost";
  $db_username = "root";
  $db_password = "";
  $dbname = "cicakavezo";
  $conn = new mysqli($servername, $db_username, $db_password, $dbname);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Query the database to verify the user's credentials
  	$sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
  	$result = mysqli_query($conn, $sql);

  	// Check if the query returned any rows
  	if (mysqli_num_rows($result) == 1) {
  		// If the credentials are correct, redirect the user to the home page
  		session_start();
  		$_SESSION['username'] = $username;
  		header("Location: profil.php");
  		exit();
  	} else {
  		// If the credentials are incorrect, display an error message
  		echo "Hibás felhasználónév vagy jelszó!";
  		exit();
  	}

   // Close the database connection
   	mysqli_close($conn);
  }
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
            <li><a href="login.php" class="active">Fiókom</a></li>
          </ul>
        </div>
      </nav>
    </header>
    <div class="wrapper">
      <h1>Jelentkezz be</h1>
        <form method="post" action="../PHP/login.php">
            <fieldset>
                <legend>Bejelentkezés</legend>
            <label for="username">Felhasználónév:</label>
            <input type="text" id="username" name="username" required><br>

            <label for="password">Jelszó:</label>
            <input type="password" id="password" name="password" required><br>
            </fieldset>
            <input type="submit" value="Bejelentkezés" class="card">
        </form>
      <p>Nincs még saját fiókod? Regisztrálj <a href="register.php">itt!</a></p>
    </div>

  </body>
  </html>