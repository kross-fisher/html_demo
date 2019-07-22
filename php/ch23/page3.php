<?php
  session_start();

  echo 'The content of sess_var now is '
       . $_SESSION['sess_var'] . '<br/>';

  session_destroy();
?>