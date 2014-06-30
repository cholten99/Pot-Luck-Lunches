<?php

  if ($_COOKIE['pot-luck-lunches']) {
    header('Location: main.php');
    exit;
  } else {
    header('Location: start.php');
  }

?>
