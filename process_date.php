<?php

  session_start();

  $id = $_SESSION['id'];
  $box_status = $_POST['box_status'];
  $location = $_POST['location'];
  $date = $_POST['date'];
  
  // NB - set apache envvars file
  // /etc/apache2/envvars in Ubuntu
  // /usr/sbin/envvars in MacOs
  
  $host = getenv("DB1_HOST");
  $user = getenv("DB1_USER");
  $pass = getenv("DB1_PASS");

  $mysqli = new mysqli($host, $user, $pass);
  $mysqli->select_db("pot-luck-lunches");

  if ($mysqli->connect_errno) {
    print "Failed to connect to MySQL: " . $mysqli->connect_error;
  }

  if ($box_status == "checked") {
    $insert_string = "INSERT INTO dates (user_id, date, location) VALUES ('$id', '$date', '$location')";
    $mysqli->query($insert_string) or die(mysqli_error($mysqli));
  } else {
    $delete_string = "DELETE FROM dates WHERE date='$date'";
    $mysqli->query($delete_string) or die(mysqli_error($mysqli));
  }

  $mysqli->close();

?>
