<?php
  session_start();
  if ($_SERVER['REQUEST_METHOD'] === "POST" and isset($_SESSION["username"])) {
    $db = new SQLite3("database.db");
    $stmt = $db->prepare(
      "INSERT INTO COMMENTS (comment, aid, author) 
      VALUES (:cnt, :aid, :usr)"
    );
    $stmt->bindValue(":cnt", $_POST["content"]);
    $stmt->bindValue(":aid", $_POST["article"]);
    $stmt->bindValue(":usr", $_SESSION["username"]);
    $stmt->execute();
    
    header("Location: /index.php");
  } 
?>