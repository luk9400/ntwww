<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === "POST") {
  $username = $_POST["username"];
  $password = hash("sha256", $_POST["password"]);
  $email = $_POST["email"];
  $db = new SQLite3("database.db");
  $stmt = $db->prepare("INSERT INTO USERS VALUES (:usr, :psw, :eml)");
  $stmt->bindValue(":usr", $username, SQLITE3_TEXT);
  $stmt->bindValue(":psw", $password, SQLITE3_TEXT);
  $stmt->bindValue(":eml", $email, SQLITE3_TEXT);
  
  if ($stmt->execute()) {
    $_SESSION["username"] = $username;
    header("Location: /index.php");
  }
  echo "Registration error";
}
?>

<link href="./styles.css" rel="stylesheet" />

<form method="post" action="registration.php">
  <div class="input-group">
    <label>Login</label>
    <input type="text" name="username">
  </div>
  <div class="input-group">
    <label>Hasło</label>
    <input type="password" name="password">
  </div>
  <div class="input-group">
    <label>E-mail</label>
    <input type="email" name="email">
  </div>
  <div class="input-group">
    <button type="submit" class="btn">Zarejestruj</button>
  </div>
  <p>
    Masz już konto? <a href="login.php">Zaloguj się</a>
  </p>
</form>