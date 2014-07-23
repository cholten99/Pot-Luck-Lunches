<?php

  // Cron script will be set to run this at 9am every week day

  include("phpmailer.php");
// TBD : Remove logging
include("utilities.php");

  $host = getenv("DB1_HOST");
  $user = getenv("DB1_USER");
  $pass = getenv("DB1_PASS");

  $mysqli = new mysqli($host, $user, $pass);
  $mysqli->select_db("plldb");

  if ($mysqli->connect_errno) {
    print "Failed to connect to MySQL: " . $mysqli->connect_error;
  }

  $id = $_SESSION['id'];

  // TBD! : Hard code this for now - fix by putting locations into their own DB at some point (will need to update other bits)
  
  $location_array = array();
  $location_array.push("Aviation House");
  $location_array.push("One Horse Guards Parade");
  $location_array.push("Other Place");

  $today_date = new DateTime();
  $check_date = $today_date->format("dmy")
  
  $email_address_array = array();
  
  for ($i = 0; $i < 3; $i++) {
    // Fetch every date for a location
    $fetch_string = "SELECT * FROM dates WHERE (location='" . $location_array[$i] . "' AND date='" . $check_date . "')";
    $result = $mysqli->query($fetch_string);

    // Go through every person for today at that location
    while ($row = $result->fetch_assoc()) {
      $user_id = $row["user_id"];
      $second_fetch_string = "SELECT * from users WHERE (id='" . $user_id . "')";
      $second_result = $mysqli->query($second_fetch_string);
      $second_row = $second_result->fetch_assoc();
      $email_address_array[$second_row["name"]] = $second_row["email"];
    }
    
    send_emails($email_address_array, $location_array[$i]);
    $email_address_array.empty();

  }

  function send_emails($email_address_array, $location) {

    $send_array = array();  
    $count = 0;
    $test = false;

    while (true) {

      while ($count < 4) {
        $send_array.push($email_address_array[0]);
        $email_address_array.remove(0);
        if ($email_address_array.length == 0) { 
          $test = true;
          break; 
        }
      }

      process_emails($send_array, $location);

      if ($test == true) { 
        break;
      }
    
    }
  
  }
  
  function process_emails($send_array, $location) {

    // Now we set up the email to send
    $mail             = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPDebug  = 1;
    $mail->SMTPAuth   = true;
    $mail->SMTPSecure = "ssl";

Use a key / value loop here to fill out the email address and name from $send_array
      $mail->AddAddress($row['email'], $row['name']);

    $mail->Host       = "smtp.gmail.com";
    $mail->Port       = 465;

    $mail->Username   = "cholten99@gmail.com";
    // Application specific password
    $mail->Password   = "afhrojdcmphmzsfb";

    $mail->From       = "david.durant@digital.cabinet-office.gov.uk";
    $mail->FromName   = "Pot Luck Lunches";
    $mail->AddReplyTo("david.durant@digital.cabinet-office.gov.uk", "David Durant");
    $mail->Subject    = "Your Pot Luck Lunch today";

    $mail->IsHTML(true);
    $mail->MsgHTML("This is a reminder that you have agreed to meet up with the random group of people on the to-list of this email at or near $location for lunch today at 12pm. I suggest emailing them to arrange where.");
    $mail->AltBody    = "This is a reminder that you have agreed to meet up with the random group of people on the to-list of this email at or near $location for lunch today at 12pm. I suggest emailing them to arrange where.";

    $mail->WordWrap   = 50;

    // And whooosh!
    if (!$mail->Send()) {
      logToTestFile("Mailer Error: " . $mail->ErrorInfo);
    }

  }

?>