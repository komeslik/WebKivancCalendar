<?php
  ini_set("session.cookie_httponly", 1);
  session_start();
  if (isset($_SESSION['currentUser'])) {
    echo json_encode(
      array(
        "validUser" => true,
        "user" => $_SESSION['currentUser']
      )
    );
    exit;
  }else {
    echo json_encode(
      array(
        "validUser" => false,
        "user" => null
      )
    );
    exit;
  }
?>
