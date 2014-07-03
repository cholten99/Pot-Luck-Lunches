<?php

  session_start();

  $pllname = $_POST['PLLName'];
  $pllemail = $_POST['PLLEmail'];
  $pllpassword = $_POST['PLLPassword'];
  $pllpassword_hash = md5($password);
  $plllocation = $_POST['PLLLocation'];

  // NB - set env vars in apache envvars file (/etc/apache2/envvars in Ubuntu)

  $host = getenv("DB1_HOST");
  $user = getenv("DB1_USER");
  $pass = getenv("DB1_PASS");
  $name = getenv("DB1_NAME");

  $mysqli = new mysqli($host, $user, $pass, $name);

  if ($mysqli->connect_errno) {
    print "Failed to connect to MySQL: " . $mysqli->connect_error;
  }

  $insert_string = "INSERT INTO users (name, email, password, location) VALUES ('$pllname', '$pllemail', '$pllpassword_hash', '$plllocation')";
  $mysqli->query($insert_string) or die(mysqli_error($mysqli));
  $mysqli->close();

  $_SESSION['id'] = $mysqli->insert_id;

var_dump($mysqli);

print "Value : " . $mysqli->insert_id . " - weird<p/>";
exit;

  header('Location: main.php');

?>
