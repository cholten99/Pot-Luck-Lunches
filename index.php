<?php

  session_start();

  if ($_COOKIE['pot-luck-lunches']) {
    $_SESSION['id'] = $_COOKIE['pot-luck-lunches'];
    header('Location: main.php');
    exit;
  } else {
    header('Location: login.php');
    exit;
  }

?>
