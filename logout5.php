<?php
  session_start();
  unset($_SESSION['username']);
  unset($_SESSION['token']);
  session_destroy();
?>
