<!DOCTYPE html>

<head>
	<meta charset="utf-8" />
	<title>WebKivanc Login</title>
	<style type="text/css">
		body {
			width: 760px;
			/* how wide to make your web page */
			background-color: teal;
			/* what color to make the background */
			margin: 0 auto;
			padding: 0;
			font: 12px/16px Verdana, sans-serif;
			/* default font */
		}

		div#main {
			background-color: #FFF;
			margin: 0;
			padding: 10px;
		}
		#mydialog { display:none }
	</style>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/start/jquery-ui.css"
 type="text/css" rel="Stylesheet" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js"></script>
<script type="text/javascript">
	function showdialog()
	{
		$("#mydialog").dialog();
	}
</script>
</head>

<body>
	<div id="main">
		<?php
			session_start();
			if(isset($_SESSION['currentUser'])){
				echo "Hi, ".$_SESSION['currentUser'];
			}
		?>
		<div id="login">
			<p>
				<a>Username:</a>
				<input type="text" id="username">
				<a>Password:</a>
				<input type="password" id="password"><br>
				<button id="login_btn">Log In</button>
				<button id="signup_btn">Sign Up</button>
			</p>
		</div>
		<div id="logout">
			<button id="logout_btn">Log Out</button>
		</div>
		<script type="text/javascript" src="login_ajax5.js"></script>
		<div id="cal">
			<button id="prevBtn">Last Month</button>
			<button id="nextBtn">Next Month</button>
			<table border="1" width="100%" id="calendar">
				<tr>
					<th style="height:15px;">Sunday</th>
					<th>Monday</th>
					<th>Tuesday</th>
					<th>Wednesday</th>
					<th>Thursday</th>
					<th>Friday</th>
					<th>Saturday</th>
				</tr>
			</table>
		</div>
		<div id="dayEvents">
			<div id="eventHeader"></div>
			<div id="events"></div>
			<button id="new_event_btn">New Event</button>
			<script type="text/javascript">
			(function(){Date.prototype.deltaDays=function(c){return new Date(this.getFullYear(),this.getMonth(),this.getDate()+c)};Date.prototype.getSunday=function(){return this.deltaDays(-1*this.getDay())}})();
function Week(c){this.sunday=c.getSunday();this.nextWeek=function(){return new Week(this.sunday.deltaDays(7))};this.prevWeek=function(){return new Week(this.sunday.deltaDays(-7))};this.contains=function(b){return this.sunday.valueOf()===b.getSunday().valueOf()};this.getDates=function(){for(var b=[],a=0;7>a;a++)b.push(this.sunday.deltaDays(a));return b}}
function Month(c,b){this.year=c;this.month=b;this.nextMonth=function(){return new Month(c+Math.floor((b+1)/12),(b+1)%12)};this.prevMonth=function(){return new Month(c+Math.floor((b-1)/12),(b+11)%12)};this.getDateObject=function(a){return new Date(this.year,this.month,a)};this.getWeeks=function(){var a=this.getDateObject(1),b=this.nextMonth().getDateObject(0),c=[],a=new Week(a);for(c.push(a);!a.contains(b);)a=a.nextWeek(),c.push(a);return c}};
				function display() {
					var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
					var table = document.getElementById("calendar");
					table.caption.innerHTML = months[currentMonth.month] + " " +currentMonth.year;
					var rows = table.rows;
					while (1 < rows.length){
						table.deleteRow(1);
					}
					for (week = 0; week < currentMonth.getWeeks().length; week++) {
						var row = table.insertRow(-1);
						for (day = 0; day < 7; day++) {
							var cell = row.insertCell(day);
							var date = currentMonth.getWeeks()[week].getDates()[day];
							getEvents(cell, date);
							if (date.getMonth() != currentMonth.month) {
								cell.bgColor = "LightGrey";
							}else if (date.getDate() == currentDate.getDate()) {
								cell.bgColor = "LightBlue";
							}
						}
					}
				}

				function getEvents(cell, date){
					var dateString = "day=" + encodeURIComponent(date.getDate()) + "&month=" + encodeURIComponent(date.getMonth()) + "&year=" + encodeURIComponent(date.getFullYear());
					var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
			    xmlHttp.open("POST", "events5.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
			    xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
			    xmlHttp.addEventListener("load", function(event) {
			      var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
						if(date.getMonth() == currentDate.getMonth()){
							cell.innerHTML = '<a href="javascript:newDate('+date.getDate()+')">'+date.getDate()+'</a>';
						}else{
							cell.innerHTML = date.getDate();
						}
						//var buttonString = '<input type="button" value="0 events" onclick=showdialog() /><div id="mydialog" title="Events for'+date.toDateString()+' ">Here are todays events:</div>'
						if (jsonData.hasEvents) { // in PHP, this was the "success" key in the associative array; in JavaScript, it's the .success property of jsonData
							var events = jsonData.events;
							cell.innerHTML += " " + events.length + " events";
							//update button if there are events
							//var dialogDiv = '<div id="mydialog" title="Events for'+date.toDateString()+' ">Here are todays events:</div>'
							//var buttonString = '<input type="button" value="'+ events.length +' events" onclick=showdialog() />'+dialogDiv;
		        }
						//cell.innerHTML += buttonString;
			    }, false); // Bind the callback to the load event
			    xmlHttp.send(dateString); // Send the data
				}

				function showEvents(){
					var dateString = "day=" + encodeURIComponent(currentDate.getDate()) + "&month=" + encodeURIComponent(currentDate.getMonth()) + "&year=" + encodeURIComponent(currentDate.getFullYear());
					var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
			    xmlHttp.open("POST", "events5.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
			    xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
			    xmlHttp.addEventListener("load", function(event) {
			      var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
						var events = jsonData.events;
						document.getElementById("eventHeader").innerHTML="<h2>Events for "+currentDate.toDateString()+"</h2>";
						var eventLog = document.getElementById("events");
						var eventHTML = "";
						for(var i in events){
							var title = events[i].title;
							var time = events[i].time;
							eventHTML += title + " " + time + "<br>";
						}
						eventLog.innerHTML = eventHTML;
			    }, false); // Bind the callback to the load event
			    xmlHttp.send(dateString); // Send the data
				}

				function newDate(date){
					var table = document.getElementById("calendar");
					var week = table.rows[Math.floor((currentDate.getDate()-currentDate.getDay()-1)/7)+2].cells[currentDate.getDay()].bgColor = "White";
					currentDate.setDate(date);
					week = table.rows[Math.floor((currentDate.getDate()-currentDate.getDay()-1)/7)+2].cells[currentDate.getDay()].bgColor = "LightBlue";
					showEvents();
				}

				document.getElementById("calendar").style.height = "200px";
				document.getElementById("calendar").createCaption();
				var currentDate = new Date();
				var currentMonth = new Month(currentDate.getFullYear(), currentDate.getMonth());
				$("#prevBtn").click(function() {
					currentMonth = currentMonth.prevMonth();
					currentDate.setMonth(currentMonth.month);
					currentDate.setDate(1);
					display();
					showEvents();
				});
				$("#nextBtn").click(function() {
					currentMonth = currentMonth.nextMonth();
					currentDate.setMonth(currentMonth.month);
					currentDate.setDate(1);
					display();
					showEvents();
				});
				document.addEventListener("DOMContentLoaded", display, false);
				document.addEventListener("DOMContentLoaded", showEvents, false);
			</script>
		</div>
	</div>
</body>

</html>
