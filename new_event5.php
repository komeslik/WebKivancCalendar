<?php
require 'database5.php';
header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json
session_start();

$newEvent = $mysqli->prepare("INSERT INTO events (username, date, time, title, note, category) VALUES (?, ?, ?, ?, ?, ?)");
$newEvent->bind_param('ssssss', $user, $date, $time, $title, $note, $category);
$user = (string)$_SESSION['currentUser'];
$date = (string)$_POST['date'];
$time = (string)$_POST['time'];
$title = (string)$_POST['title'];
$note = (string)$_POST['note'];
$category = (string)$_POST['category'];
$newEvent->execute();
$newEvent->close();
echo json_encode(array(
  "success" => true,
));
exit;
?>
