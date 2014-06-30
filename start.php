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

        <form role="form" action="process_start.php" method="post">
          <div class="form-group">
            <h3><label for="YourName">Your name</label></h3>
            <input type="text" class="form-control input-lg" name="YourName" id="YourName" placeholder="Your name here">
            <h3><label for="YourEmail">Your email address</label></h3>
            <input type="email" class="form-control input-lg" name="YourEmail" id="YourEmail" placeholder="Your email here">
          </div>

          <div class="form-group">
            <h3><label for="YourLocation">Your main location</label></h3>
            <select class="form-control input-lg" name="YourLocation" id="YourLocation">
              <option value="Aviation House">Aviation House</option>
              <option value="One Horse Guards Parade">One Horse Guards Parade</option>
              <option value="Other Place">Other Place</option>
            </select>
          </div>

          <p/>&nbsp;<p/>
          <button type="submit" class="btn btn-primary btn-lg">Submit</button>

        </form>

      </div>

    <?php
//      setCookie("pot-luck-lunches", "some-value");
    ?>

  </body>
</html>
