<?php
  echo 'The content of sess_var before session_start is '
       . $_SESSION['sess_var'] . '<br/>';

  session_start();

  echo 'The content of sess_var now is '
       . $_SESSION['sess_var'] . '<br/>';

  unset($_SESSION['sess_var']);
?>
<a href="page3.php">Next page</a>