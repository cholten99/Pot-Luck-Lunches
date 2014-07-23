<?php

  session_start();

  if ($_COOKIE['plldb']) {
    $_SESSION['id'] = $_COOKIE['plldb'];
    header('Location: main.php');
    exit;
  } else {
    header('Location: login.php');
    exit;
  }

?>
