<?php
  require 'database5.php';
  header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json
  ini_set("session.cookie_httponly", 1);
  session_start();
  if($_SESSION['token'] !== $_POST['token']){
    die("Request forgery detected");
  }
  $date = (string)$_POST['date'];
  $time = (string)$_POST['time'];
  $title = (string)$_POST['title'];
  $note = (string)$_POST['note'];
  $category = (string)$_POST['category'];
  $repeat = (string)$_POST['repeat'];
  $id = (string)$_POST['id'];
  $editEvent = $mysqli->prepare("UPDATE events SET date=?, time=?, title=?, note=?, category=?, repeatt=? WHERE event_id=?");
  $editEvent->bind_param('sssssss', $date, $time, $title, $note, $category, $repeat, $id);
  $editEvent->execute();
  $editEvent->close();
  echo json_encode(array(
    "success" => true
  ));
  exit;
?>
