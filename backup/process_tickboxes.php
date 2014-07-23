<?php

  session_start();

  $id = $_SESSION['id'];
  $location = $_GET['location'];
  
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

  $query_string = "SELECT date FROM dates WHERE (user_id='$id' AND location='$location')";
  $result = $mysqli->query($query_string) or die(mysqli_error($mysqli));

  $result_array = array();
  while ($row = $result->fetch_assoc()) {
    $result_array[] = $row;
  }

  $json = json_encode($result_array);
  print $json;

  $mysqli->close();

?>
