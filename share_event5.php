<?php
  require 'database5.php';
  header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json

  $stmt = $mysqli->prepare("SELECT shared FROM events WHERE event_id=?");
  $stmt->bind_param('s', $id);
  $id = (string)$_POST['id'];
  $stmt->execute();
  $result = $stmt->get_result();
  if($row = $result->fetch_assoc()){
    $users = $row['shared'].",".$_POST['user'];
    $shareEvent = $mysqli->prepare("UPDATE events SET shared=? WHERE event_id=?");
    $shareEvent->bind_param('ss', $users, $id);
    $shareEvent->execute();
    $shareEvent->close();
    echo json_encode(array(
      "success" => true
    ));
    exit;
  } else {
    echo json_encode(array(
      "success" => false
    ));
    exit;
  }
?>
