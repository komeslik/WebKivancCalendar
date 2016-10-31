<?php
  require 'database5.php';
  ini_set("session.cookie_httponly", 1);
  session_start();
  $day = $_POST['day'];
  $month = $_POST['month'];
  $year = $_POST['year'];

  if(isset($_SESSION['currentUser'])){
    $user = (string)$_SESSION['currentUser'];
  }else {
    $user = "";
  }
  $likeUser = '%'.$user.'%';
  $stmt = $mysqli->prepare("SELECT shared, note, title, time, category, event_id FROM events WHERE shared LIKE ? AND date= ? ORDER BY time ASC");
  $stmt->bind_param('ss', $likeUser, $date);
  //$userString = "%".$user."%";
  $date = (string)$year."-".$month."-".$day;
  $stmt->execute();
  $result = $stmt->get_result();
  $events = array();

  //create an array of events where each element is an event row from the query
  while ($row = $result->fetch_assoc()) {
    $users = explode(",", $row['shared']);
    foreach($users as $u){
      if($u == $user){
         $events[] = $row;
      }
    }
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
