<?php session_start(); ?>

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

        <?php
          if (array_key_exists("pll-error" , $_SESSION)) {
            print "<div class='alert alert-danger fade in'>Email or password incorrect</div>";
          }
        ?>

        <form role="form" action="process_login.php" method="post">
          <div class="form-group">
            <h3><label for="PLLEmail">Enter your email</label></h3>
            <input type="email" class="form-control input-lg" name="PLLEmail" id="YourPLLEmail" placeholder="Your email here">
            <h3><label for="PLLPassword">Enter your password</label></h3>
            <input type="password" class="form-control input-lg" name="PLLPassword" id="PLLPassword" placeholder="Your password here">            

            <p/>&nbsp;<p/>
            <button type="submit" class="btn btn-primary btn-lg">Submit</button>
          </div>
 
          <p/>&nbsp;<p/>          
          <h3>First time? Please <a href="register.php">click here to register</a>.</h3>
          <h3>Having problems logging in <a href="mailto:david.durant@digital.cabinet-office.gov.uk">click here for help</a>.</h3>


        </form>

      </div>

  </body>
</html>
