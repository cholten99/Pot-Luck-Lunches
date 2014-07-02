<?php
  setCookie("pot-luck-lunches", "some-value");
?>

<html>
  <head>
    <!-- jQuery -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

    <!-- Bootstrap -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
  </head>
  
  <body>
    <div class="container">
      <div class="page-header">
        <h1>Pot Luck Lunches<h1>
        <h2>Your opportunity to meet random interesting people at work</h2>
      </div>

      <div id="main-bit">

        <form role="form" action="process_user.php" method="post">
          <div class="form-group">
            <h3><label for="PLLName">Your name (&lt;first name&gt; &lt;last name&gt;)</label></h3>
            <input type="text" class="form-control input-lg" name="PLLName" id="PLLName" placeholder="Your name here">
            <h3><label for="PLLmail">Your email address</label></h3>
            <input type="email" class="form-control input-lg" name="PLLEmail" id="PLLEmail" placeholder="Your email here">
            <h3><label for="PLLPassword">Enter your password</label></h3>
            <input type="password" class="form-control input-lg" name="PLLPassword" id="PLLPassword" placeholder="Your password here">

            <h3><label for="PLLLocation">Your main location</label></h3>
            <select class="form-control input-lg" name="PLLLocation" id="PLLLocation">
              <option value="Aviation House">Aviation House</option>
              <option value="One Horse Guards Parade">One Horse Guards Parade</option>
              <option value="Other Place">Other Place</option>
            </select>

            <p/>&nbsp;<p/>
            <button type="submit" class="btn btn-primary btn-lg">Submit</button>
          </div>

        </form>

      </div>

  </body>
</html>
