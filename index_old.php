<html>
  <head>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    
    TBD!! jQuery register for drop-box and tickboxes and their callbacks
    
  </head>

  <body>

<?php

// Check for cookie
$userID = $_COOKIE['userID'];

// If empty display page asking for name, email address and default location
// on submission put info in People DB, write cookie and redirect to usual page
if ($userID === "") {
  header('Location: personal_details.php');
}

// Get user info from the DB - including default value for location, list of all dates and list of ticked dates


// Show main page
print "Welcome back " . firstName . "<p/>";
print "<a href='personal_details.php?userID=" . $userID . "'>Edit details</a><p/>";

// User jQuery / AJAX to handle drop-down and list of tick-boxes
// drop-down for location (usual one set as default) - change of location refreshes with different dates

// shows list of days (grouped by week with Monday date at the top) - prepopulated with ones previously ticked, ticking box AJAX sets / unsets MatchesDB




http://www.w3schools.com/php/php_cookies.asp

setcookie("user", "Alex Porter");

?>

  </body>

</html>