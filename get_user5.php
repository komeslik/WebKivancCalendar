<?php
  header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json
  ini_set("session.cookie_httponly", 1);
  session_start();
  if(isset($_SESSION['currentUser'])) {
    $html_safe_currentUser = htmlentities($_SESSION['currentUser']);
    echo json_encode(array(
      "user" => (string)$html_safe_currentUser,
      "token" => $_SESSION['token']
    ));
    exit;
  } else {
    echo json_encode(array(
      "user" => ""
    ));
    exit;
  }
?>
