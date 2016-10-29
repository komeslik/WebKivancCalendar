<?php
  require 'database5.php';
  session_start();
  $day = $_POST['day'];
  $month = $_POST['month'];
  $year = $_POST['year'];

  if(isset($_SESSION['currentUser'])){
    $user = (string)$_SESSION['currentUser'];
  }else {
    $user = "";
  }
  $stmt = $mysqli->prepare("SELECT title, time FROM events WHERE username= ? AND date= ? ORDER BY time ASC");
  $stmt->bind_param('ss', $user, $date);
  $date = (string)$year."-".$month."-".$day;
  $stmt->execute();
  $result = $stmt->get_result();
  $events = array();

  //create an array of events where each element is an event row from the query
  while ($row = $result->fetch_assoc()) {
    $events[] = $row;
  }
  if(count($events) > 0){
    echo json_encode(
      array(
        "hasEvents" => true,
        "events" => $events
      )
    );
  }
  else {
    echo json_encode(
      array(
        "hasEvents" => false,
        "events" => $events
      )
    );
  }
?>