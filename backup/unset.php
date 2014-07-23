<?php
  session_start();
  setCookie('plldb', '');
  session_destroy();
  print "Cookie unset and session destroyed";
?>
