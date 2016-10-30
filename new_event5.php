<?php
  require 'database5.php';
  header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json
ini_set("session.cookie_httponly", 1);
  session_start();
  if($_SESSION['token'] !== $_POST['token']){
  	die("Request forgery detected");
  }
  $newEvent = $mysqli->prepare("INSERT INTO events (username, date, time, title, note, category, shared) VALUES (?, ?, ?, ?, ?, ?, ?)");
  $newEvent->bind_param('sssssss', $user, $date, $time, $title, $note, $category, $user);
  $user = (string)$_SESSION['currentUser'];
  $date = (string)$_POST['date'];
  $time = (string)$_POST['time'];
  $title = (string)$_POST['title'];
  $note = (string)$_POST['note'];
  $category = (string)$_POST['category'];
  $newEvent->execute();
  $newEvent->close();
  echo json_encode(array(
    "success" => true
  ));
  exit;
?>
