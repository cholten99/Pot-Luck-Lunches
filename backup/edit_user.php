<?php 

  session_start(); 

  $host = getenv("DB1_HOST");
  $user = getenv("DB1_USER");
  $pass = getenv("DB1_PASS");

  $mysqli = new mysqli($host, $user, $pass, $name);
  $mysqli->select_db("plldb");


  if ($mysqli->connect_errno) {
    print "Failed to connect to MySQL: " . $mysqli->connect_error;
  }

  $id = $_SESSION['id'];
  
  $fetch_string = "SELECT * FROM users WHERE (id='" . $id . "')";
  $result = $mysqli->query($fetch_string);
  $row = $result->fetch_assoc();
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

      <div id="main-bit">

        <form role="form" action="process_edit_user.php" method="post">
          <div class="form-group">
            <h3><label for="PLLName">Your name (&lt;first name&gt; &lt;last name&gt;)</label></h3>
            <input type="text" class="form-control input-lg" name="PLLName" id="PLLName" value="<?php print $row['name']; ?>">
            <h3><label for="PLLmail">Your email address</label></h3>
            <input type="email" class="form-control input-lg" name="PLLEmail" id="PLLEmail" value="<?php print $row['email']; ?>">
            <h3><label for="PLLPassword">Enter your password</label></h3>
            <input type="password" class="form-control input-lg" name="PLLPassword" id="PLLPassword" value="<?php print $row['password']; ?>">

            <h3><label for="PLLLocation">Your main location</label></h3>
            <select class="form-control input-lg" name="PLLLocation" id="PLLLocation">
              <option value="Aviation House">Aviation House</option>
              <option value="One Horse Guards Parade">One Horse Guards Parade</option>
              <option value="Other Place">Other Place</option>
            </select>

            <script>setSelectedValue("PLLLocation", "<?php print $row['location']; ?>");</script>

            <p/>&nbsp;<p/>
            <button type="submit" class="btn btn-primary btn-lg">Submit</button>
          </div>

        </form>

      </div>

  </body>
</html>
