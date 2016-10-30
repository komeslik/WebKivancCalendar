<?php
  require 'database5.php';
  header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json

  $editEvent = $mysqli->prepare("UPDATE events SET date=? time=? title=? note=? category=? WHERE event_id=?");
  $editEvent->bind_param('ssssss', $date, $time, $title, $note, $category, $id);
  $date = (string)$_POST['date'];
  $time = (string)$_POST['time'];
  $title = (string)$_POST['title'];
  $note = (string)$_POST['note'];
  $category = (string)$_POST['category'];
  $id = (string)$_POST['id'];
  $editEvent->execute();
  $editEvent->close();
  echo json_encode(array(
    "success" => true
  ));
  exit;
?>
