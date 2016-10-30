<?php
  require 'database5.php';
  header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json

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
