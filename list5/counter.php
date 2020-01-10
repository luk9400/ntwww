<?php
session_start();
$path = "counter.log";

if (!file_exists($path)) {
  $f = fopen($path, "w");
  fwrite($f,"0");
  fclose($f);
}

$f = fopen($path,"r");
$counterVal = fread($f, filesize($path));
fclose($f);

if(!isset($_SESSION['hasVisited'])){
  $_SESSION['hasVisited']="yes";
  $counterVal++;
  $f = fopen($path, "w");
  fwrite($f, $counterVal);
  fclose($f);
}

echo "Jesteś $counterVal odwiedzającym";
?>