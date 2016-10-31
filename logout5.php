<?php
  ini_set("session.cookie_httponly", 1);
  session_start();
  unset($_SESSION['username']);
  unset($_SESSION['token']);
  session_destroy();
?>
