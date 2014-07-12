<?php

  include("phpmailer.php");
// TBD : Remove logging
include("utilities.php");

emptyTestFile();

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

  // Now for the fun stuff - let's send some meeting emails

  // Firstly need to get some data about who to send it to
  $host = getenv("DB1_HOST");
  $user = getenv("DB1_USER");
  $pass = getenv("DB1_PASS");

  $mysqli = new mysqli($host, $user, $pass);
  $mysqli->select_db("pot-luck-lunches");

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
  $mail->Subject    = "Pot Luck Lunches invite";

  $mail->IsHTML(true);
  $mail->MsgHTML("Pot Luck Lunches meeting related email");
  $mail->AltBody    = "Pot Luck Lunches meeting related email";

  $mail->WordWrap   = 50;

  // Including the funky attachment

  $datestamp_now = date("Ymd\THis\Z", time());
  $day = substr($date, 0, 2);
  $month = substr($date, 2, 2); 
  $year = substr($date, 4, 2);
  $date_string = $day . "/" . $month . "/" . $year;
  $datestamp_start = "20" . $year . $month . $day . "T110000Z";
  $datestamp_end = "20" . $year . $month . $day . "T120000Z";

  if ($box_status == "checked") {
    $attachment_string = "BEGIN:VCALENDAR\n" . 
                         "VERSION:2.0\n" .
                         "PRODID:-//hacksw/handcal//NONSGML v1.0//EN\n" .
                         "BEGIN:VEVENT\n" .
                         "UID:david.durant@digital.cabinet-office.gov.uk\n" .
                         "DTSTAMP:" . $datestamp_now . "\n" .
                         "ORGANIZER;CN=Pot Luck Lunches:MAILTO:david.durant@digital.cabinet-office.gov.uk\n" .
                         "DTSTART:" . $datestamp_start . "\n" .
                         "DTEND:" . $datestamp_end . "\n" .
                         "SUMMARY:Pot Luck Lunch invite for " . $date_string . "\n" .
                         "END:VEVENT\n" .
                         "END:VCALENDAR\n";
  } else {
    $attachment_string = "BEGIN:VCALENDAR\n" . 
                         "VERSION:2.0\n" .
                         "PRODID:-//hacksw/handcal//NONSGML v1.0//EN\n" .
                         "METHOD:CANCEL\n" . 
                         "BEGIN:VEVENT\n" .
                         "UID:david.durant@digital.cabinet-office.gov.uk\n" .
                         "DTSTAMP:" . $datestamp_now . "\n" .
                         "ORGANIZER;CN=Pot Luck Lunches:MAILTO:david.durant@digital.cabinet-office.gov.uk\n" .
                         "SEQUENCE:1\n" .
                         "DTSTART:" . $datestamp_start . "\n" .
                         "DTEND:" . $datestamp_end . "\n" .
                         "SUMMARY:Pot Luck Lunch invite for " . $date_string . "\n" .
                         "END:VEVENT\n" .
                         "END:VCALENDAR\n";
  }

  $mail->AddStringAttachment($attachment_string, "pot-luck-lunches.ics", "base64", "text/calendar; charset=US-ASCII; ");

  // And whooosh!
  if (!$mail->Send()) {
    logToTestFile("Mailer Error: " . $mail->ErrorInfo);
  }

?>
