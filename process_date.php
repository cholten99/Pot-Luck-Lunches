<?php

  include("phpmailer.php");

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
  $mysqli->select_db("plldb");

  if ($mysqli->connect_errno) {
    print "Failed to connect to MySQL: " . $mysqli->connect_error;
  }

  if ($box_status == "checked") {
    $insert_string = "INSERT INTO dates (user_id, date, location) VALUES ($id, '$date', '$location')";
    $mysqli->query($insert_string);
  } else {
    $delete_string = "DELETE FROM dates WHERE date='$date'";
    $mysqli->query($delete_string);
  }

  $mysqli->close();

  // Now for the fun stuff - let's send some meeting emails

  // Firstly need to get some data about who to send it to
  $host = getenv("DB1_HOST");
  $user = getenv("DB1_USER");
  $pass = getenv("DB1_PASS");

  $mysqli = new mysqli($host, $user, $pass);
  $mysqli->select_db("plldb");

  if ($mysqli->connect_errno) {
    print "Failed to connect to MySQL: " . $mysqli->connect_error;
  }

  $select_string = "SELECT * from users WHERE id=$id";
  $result = $mysqli->query($select_string) or die(mysqli_error($mysqli));
  $row = $result->fetch_assoc();
  $mysqli->close();

  // Now we set up the email to send
  $mail             = new PHPMailer();
  $mail->IsSMTP();
  $mail->SMTPDebug  = 1;
  $mail->SMTPAuth   = true;
  $mail->SMTPSecure = "ssl";

  $mail->AddAddress($row['email'], $row['name']);

  $mail->Host       = "smtp.gmail.com";
  $mail->Port       = 465;

  $mail->Username   = "cholten99@gmail.com";
  // Application specific password
  $mail->Password   = "afhrojdcmphmzsfb";

  $mail->From       = "david.durant@digital.cabinet-office.gov.uk";
  $mail->FromName   = "Pot Luck Lunches";
  $mail->AddReplyTo("david.durant@digital.cabinet-office.gov.uk", "David Durant");
  $mail->Subject    = "Pot Luck Lunches invite - 12pm on " . substr($date, 0, 2) . "/" . substr($date, 2, 2) . "/" . substr($date, 4, 2);

  $mail->IsHTML(true);
  $mail->MsgHTML("This is an automated Pot Luck Lunches meeting invite. We suggest adding an entry to your calendar so you remember. You'll be contacted automatically on the day with the email addresses of those people you'll be having lunch with.");
  $mail->AltBody    = "This is an automated Pot Luck Lunches meeting invite. We suggest adding an entry to your calendar so you remember. You'll be contacted automatically on the day with the email addresses of those people you'll be having lunch with.";

  $mail->WordWrap   = 50;

  // And whooosh!
  if (!$mail->Send()) {
    logToTestFile("Mailer Error: " . $mail->ErrorInfo);
  }

?>
