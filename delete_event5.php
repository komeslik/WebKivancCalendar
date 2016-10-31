<?php
  require 'database5.php';
  header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json
  ini_set("session.cookie_httponly", 1);
  session_start();
  if($_SESSION['token'] !== $_POST['token']){
    die("Request forgery detected");
  }
  $newEvent = $mysqli->prepare("DELETE FROM events WHERE event_id=?");
  $newEvent->bind_param('s', $id);
  $id = $_POST['id'];
  $newEvent->execute();
  $newEvent->close();
  echo json_encode(array(
    "success" => true
  ));
  exit;
?>
