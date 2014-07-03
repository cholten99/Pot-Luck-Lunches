<?php

  session_start();

  $email = $_POST['PLLEmail'];
  $password = $_POST['PLLPassword'];
  $password_hash = md5($password);

  // NB this must be wrong as needs to be different for different apps!
  // NB - set env vapache envvars file
  // /etc/apache2/envvars in Ubuntu
  // /usr/sbin/envvars in MacOs
  

  $host = getenv("DB1_HOST");
  $user = getenv("DB1_USER");
  $pass = getenv("DB1_PASS");
  $name = getenv("DB1_NAME");

  $mysqli = new mysqli($host, $user, $pass, $name);

  if ($mysqli->connect_errno) {
    print "Failed to connect to MySQL: " . $mysqli->connect_error;
  }

  $fetch_string = "SELECT id, email FROM users WHERE (password='" . $password_hash . "')";
  $result = $mysqli->query($fetch_string);
  $row = $result->fetch_assoc();
  $mysqli->close();

  if ($row['email'] == $email) {
    // Success
    setCookie("pot-luck-lunches", $row['id']);
    $_SESSION['id'] = $row['id'];
    header('Location: main.php');
  } else {
    $_SESSION['pll-error'] = "true";
    header('Location: login.php');
  }

?>
