<?php

  $email = $_POST['PLLEmail'];
  $password = $_POST['PLLPassword'];
  $password_hash = md5($password);

  $mysqli = new mysqli( $_SERVER["DB1_HOST"], $_SERVER["DB1_USER"],
                        $_SERVER["DB1_PASS"], $_SERVER["DB1_NAME"],
                        $_SERVER["DB1_PORT"]);

  if ($mysqli->connect_errno) {
    print "Failed to connect to MySQL: " . $mysqli->connect_error;
  }

  $fetch_string = "SELECT name FROM users WHERE (password='" . $password . "')";

  $result = $mysqli->query($fetch_string);
  $row = $res->fetch_assoc();

  if ($row['email'] == $email) {
    header('Location: main.php');
  } else {
    header('Location: login.php?error=true');
  }

?>
