<?php
ob_start();
session_start();
$_SESSION['percent'] = 0;
$iterations = 50;

for ($i = 0; $i <= 50; $i++) {
  $percent = ($i / $iterations) * 100;
  echo "Hello World!";
  echo "<br />";
  // update session variable
  session_start();
  $_SESSION['percent'] = number_format($percent, 0, '', '');
  session_commit();
}
ob_flush();
?>