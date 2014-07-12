<?php

  session_start();

  $pllname = $_POST['PLLName'];
  $pllemail = $_POST['PLLEmail'];
  $pllpassword = $_POST['PLLPassword'];
  $pllpassword_hash = md5($pllpassword);
  $plllocation = $_POST['PLLLocation'];

  // NB - set apache envvars file
  // /etc/apache2/envvars in Ubuntu
  // /System/Library/LaunchDaemons/org.apache.httpd.plist in MacOs
  
  $host = getenv("DB1_HOST");
  $user = getenv("DB1_USER");
  $pass = getenv("DB1_PASS");

  $mysqli = new mysqli($host, $user, $pass);
  $mysqli->select_db("pot-luck-lunches");

  if ($mysqli->connect_errno) {
    print "Failed to connect to MySQL: " . $mysqli->connect_error;
  }

  $insert_string = "INSERT INTO users (name, email, password, location) VALUES ('$pllname', '$pllemail', '$pllpassword_hash', '$plllocation')";

  $mysqli->query($insert_string) or die(mysqli_error($mysqli));

  $_SESSION['id'] = $mysqli->insert_id;
  $mysqli->close();

  header('Location: login.php');

?>
