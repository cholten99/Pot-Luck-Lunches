<html>
  <head>
    <!-- jQuery -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    <!-- Bootstrap -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

    <script>

      $( document ).ready(function() {
        $(':checkbox').change(function() {
          var $this = $(this);
          var $val = $this.val();
          if ($this.is(':checked')) {
            console.log("Checkbox " + $val + " was checked");
          } else {
            console.log("Checkbox " + $val + " was unchecked");
          }
        });
      });

      function changeLocation(newLocation) {
        console.log(newLocation);
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
        date_default_timezone_set("UTC");
        $today_date = new DateTime();

        Print "Welcome back Bob. It's " . $today_date->format("l jS \of F Y") . ". Your current lunch meet-ups are below.<p/><p/><p/>";
      ?>

      <div class="dropdown btn-group">
        <button class="btn dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
          Location
          <span class="caret"></span>
        </button>    
        <ul class="dropdown-menu" is="location-dropdown">
          <li><a href="#" onclick="changeLocation('Aviation House');">Aviation House</a></li>
          <li><a href="#" onclick="changeLocation('One Horse Guards Parade');">One Horse Guards Parade</a></li>
          <li><a href="#" onclick="changeLocation('Other Place');">Other Place</a></li>
        </ul>
      </div>

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
            print "<p/><input type='checkbox' value='$value_date'/>&nbsp;";
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
            print "</p><input type='checkbox' value='$value_date'/>&nbsp;";
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
