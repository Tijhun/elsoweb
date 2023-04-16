<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Get form data
  $username = $_POST["username"];
  $password = $_POST["password"];

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

  // Check if username already exists
  $sql = "SELECT * FROM users WHERE username='$username'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    echo "Hiba: Már létezik ilyen felhasználónév!";
    exit();
  }

  // Insert user into database
  $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
  if ($conn->query($sql) === TRUE) {
    echo "Sikeres regisztráció!";
    header("Location: login.php");
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
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
  <h1>Regisztráció</h1>
  <form method="post" action="../PHP/register.php">
    <fieldset>
      <legend>Felhasználói adatok</legend>
    <label for="username">Felhasználónév:</label>
    <input type="text" id="username" name="username" required><br>

    <label for="password">Jelszó:</label>
    <input type="password" id="password" name="password" required><br>

    <label for="confirm_password">Jelszó újra:</label>
    <input type="password" id="confirm_password" name="confirm_password" required><br>
    </fieldset>
    <input type="submit" value="Regisztráció" class="card">
  </form>

</div>

</body>
</html>