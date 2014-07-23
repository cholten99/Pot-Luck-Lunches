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

      <h2>Introduction</h2>

      I've put together <a href="main.php">this quick demo</a> to get feedback from people before doing some more work (always throw out an 'aplha').<p/><p/>
      <a href="mailto:dave@bowsy.co.uk">Please send feedback to me here</a>.<p/>
      Known issues:
      <ul>
        <li>Feedback on UI needed
        <li>Missing page title(s)
        <li>Cookie and / or session times out after a while of staying on the main page. Leaving it open for a long time before coming back to it causes the app to fail.
        <li>Need to write the part of the app that send off automated emails every working day morning to let people who have a PLL that day who they are meeting up with.
        <li>Need to define the locations for the original release.
        <li>Check that a user isn't already ticked in another location when they tick one
        <li>Remove the need for two SQL selects in cron script by using a JOIN?
        <li>Need to work out how to explain to people how it works.
        <li>Does it need a button to clear all tickboxes?
        <li>Does it need to be able to delete accounts?
        <li>Password resets?
        <li>Check the name field contains exactly one space
        <li>Email conformation?
        <li>Go through code for TBDs
        <li>Mechanism for people to record meeting up (might be just a twitter address - if so add feed to page?).
        <li>Proper email address for the emails to come from, responses to go back to (routed to me?) - search for my email everywhere and replace
        <li>Performance platform equivalent... Show "Join <x> people to..." if X > 10?
        <li>Emails sent from something proper (create a specific gmail account for it?)
      </ul>

    </div>

  </body>
</html>
