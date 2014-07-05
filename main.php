<?php 

  session_start(); 

  date_default_timezone_set("UTC");
  $today_date = new DateTime();

  $host = getenv("DB1_HOST");
  $user = getenv("DB1_USER");
  $pass = getenv("DB1_PASS");

  $mysqli = new mysqli($host, $user, $pass);
  $mysqli->select_db("pot-luck-lunches");

  if ($mysqli->connect_errno) {
    print "Failed to connect to MySQL: " . $mysqli->connect_error;
  }

  $id = $_SESSION['id'];
  $fetch_string = "SELECT name,location FROM users WHERE (id='" . $id . "')";
  $result = $mysqli->query($fetch_string);
  $row = $result->fetch_assoc();
  $name = $row['name'];
  $first_name = substr($name, 0, strpos($name, " "));
  $mysqli->close();

?>

<html>
  <head>
    <!-- jQuery -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    <!-- Bootstrap -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

    <script>

      id = <?php print $id ?>;

      $( document ).ready(function() {

        $(':checkbox').change(function() {
          var $this = $(this);
          var val = $this.attr('id');
          if ($this.is(':checked')) {
            // Asside - setting a variable called "location" seems to have the same effect as PHP header("location: ...");
            plllocation = $("#PLLLocation").val();
            $.post('process_date.php', { box_status: "checked", id : id, location : plllocation, date : val}); 
          } else {
            $.post('process_date.php', { box_status: "unchecked", id : id, location : plllocation, date : val});         
          }
        });

        $('#PLLLocation').change(function() {
          setTickboxes($('#PLLLocation').val());
        });

        setTickboxes("<?php print $row['location']; ?>");

      });

      function setTickboxes(location) {
        // Set all to empty
        $(":checkbox").prop('checked', false);

        $.get('process_tickboxes.php', {location : location}, function(data,status) {
          if (data == "[]") return;
          date_array = $.parseJSON(data);
          for (var i = 0; i < date_array.length; i++) {
            $("#" + date_array[i].date).prop('checked', true);
          }
        });
      }

      function setSelectedValue(selectName, valueToSet) {
        selectObj = document.getElementById(selectName);
        for (var i = 0; i < selectObj.options.length; i++) {
          if (selectObj.options[i].text== valueToSet) {
            selectObj.options[i].selected = true;
            return;
          }
        }
      }

    </script>

  </head>

  <body>

    <div class="container">
      <div class="page-header">
        <h1>Pot Luck Lunches<h1>
        <h2>Your opportunity to meet random interesting people at work</h2>
      </div>

      <?php 
        print "<h4>Welcome $first_name. <a href='edit_user.php'>Click here</a> if you need to update your details.<p/><p/>";
        print "It's " . $today_date->format("l jS \of F Y") . ". Your current lunch meet-ups are below.";
      ?>

      <div class="row">
        <div class='col-md-2'>
          <h4><label for="PLLLocation">For location : </label></h4>
        </div>
        <div class='col-md-3'>
          <select class="form-control input-md" name="PLLLocation" id="PLLLocation" width="20%">
            <option value="Aviation House">Aviation House</option>
            <option value="One Horse Guards Parade">One Horse Guards Parade</option>
            <option value="Other Place">Other Place</option>
          </select>
        </div>
      </div>

      <script>setSelectedValue("PLLLocation", "<?php print $row['location']; ?>");</script>

      <hr/>

      <div id="all-weeks">

      <?php
        // Begin grid
        print "<div class='row'>";
        $today_day_number = $today_date->format("w");

        // Handle this week
        $skip_this_week = false;          
        if (($today_day_number == 0) || ($today_day_number == 5) || ($today_day_number == 6)) {
          $skip_this_week = true;
        }

        if ($skip_this_week == false) {
          print "<div class='col-md-2'>";
          print "<div id='this-week'>";
          print "<b>This week</b><p/><p/>";

          $working_date = $today_date->add(new DateInterval('P1D'));;
          for ($i = $today_day_number + 1; $i < 6; $i++) {
            $value_date = $working_date->format("d/m/y");
            $stripped_date = str_replace('/', '', $value_date);
            print "<p/><input type='checkbox' id='$stripped_date' value='$stripped_date'/>&nbsp;";
            print $working_date->format("l");
            $working_date->add(new DateInterval('P1D'));
          }

          print "</div>";
        }

        // Close row in grid
        print "</div>";

        // Other weeks
        $number_other_weeks = 0;
        if ($skip_this_week == true) {
          $number_other_weeks = 5;
        } else {
          $number_other_weeks = 4;
        }

        $working_date = $today_date->modify('next Monday');
        for ($j = 0; $j < $number_other_weeks; $j++) {
          print "<div class='col-md-2'>";
          print "<b>Week starting : " . $working_date->format("d/m/y") . "</b><p/>";
          for ($k = 0; $k < 5; $k++) {
            $value_date = $working_date->format("d/m/y");
            $stripped_date = str_replace('/', '', $value_date);
            print "<p/><input type='checkbox' id='$stripped_date' value='$stripped_date'/>&nbsp;";
            print $working_date->format("l");
            $working_date->add(new DateInterval('P1D'));
          }
          // Close row in grid
          print "</div>";
          $working_date->modify('next Monday');
        }

        // Close grid
        print "</div";

      ?>

      </div>

    </div>

  </body>
</head>
