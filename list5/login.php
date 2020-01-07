<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === "POST") {
  $username = $_POST["username"];
  $password = hash("sha256", $_POST["password"]);
  $db = new SQLite3("database.db");
  $stmt = $db->prepare("SELECT psw FROM USERS WHERE usr=:usr");
  $stmt->bindValue(":usr", $username, SQLITE3_TEXT);
  $returned_set = $stmt->execute();
  while($result = $returned_set->fetchArray(SQLITE3_ASSOC)) {
    if ($result["PSW"] == $password) {
      $_SESSION["username"] = $username;
      header("Location: /index.php");
    }
  }
  echo "Login error";
}
?>

<link href="./styles.css" rel="stylesheet" />

<form method="post" action="login.php">
  <div class="input-group">
    <label>Login</label>
    <input type="text" name="username">
  </div>
  <div class="input-group">
    <label>Hasło</label>
    <input type="password" name="password">
  </div>
  <div class="input-group">
    <button type="submit" class="btn">Zaloguj</button>
  </div>
  <p>
    Nie masz konta? <a href="registration.php">Zarejestruj się</a>
  </p>
</form>