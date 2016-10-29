<?php
  require 'database5.php';
  session_start();
  $day = $_POST['day'];
  $month = $_POST['month'];
  $year = $_POST['year'];

  if(isset($_SESSION['currentUser'])){
    $user = $mysqli->escape_string($_SESSION['currentUser']);
  }else {
    $user = "";
  }
	$date = $mysqli->escape_string($year."-".$month."-".$day);
  $stmt = "SELECT title, time FROM events WHERE username LIKE '$user' AND date LIKE '$date' ORDER BY time ASC";
  $res = $mysqli->query($stmt);
  $events = array();

  //create an array of events where each element is an event row from the query
  if($res->num_rows > 0){
    while($event_instance = $res->fetch_assoc()) {
	    $events[] += $event_instance;
    }
  }
  if($events != null){
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
