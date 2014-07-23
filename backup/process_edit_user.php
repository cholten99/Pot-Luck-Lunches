<?php

  session_start();

  $pllname = $_POST['PLLName'];
  $pllemail = $_POST['PLLEmail'];
  $pllpassword = $_POST['PLLPassword'];
  $pllpassword_hash = md5($pllpassword);
  $plllocation = $_POST['PLLLocation'];

  $id = $_SESSION['id'];

  // NB - set apache envvars file
  // /etc/apache2/envvars in Ubuntu
  // /usr/sbin/envvars in MacOs
  
  $host = getenv("DB1_HOST");
  $user = getenv("DB1_USER");
  $pass = getenv("DB1_PASS");

  $mysqli = new mysqli($host, $user, $pass);
  $mysqli->select_db("plldb");

  if ($mysqli->connect_errno) {
    print "Failed to connect to MySQL: " . $mysqli->connect_error;
  }

  $update_string = "UPDATE users SET name='$pllname',email='$pllemail',password='$pllpassword_hash',location='$plllocation' WHERE id=$id";
  $mysqli->query($update_string) or die(mysqli_error($mysqli));
  $mysqli->close();

  header('Location: main.php');

?>
