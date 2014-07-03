<?php
  session_start();
  setCookie('pot-luck-lunches', '');
  session_destroy();
  print "Cookie unset and session destroyed";
?>
