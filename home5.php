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
		table {
			border: 1px solid black;
			width: 100%;
		}
		th, td {
			border: 1px solid black;
		}
		div#work { color: blue; }
		div#academic { color: green; }
		div#social { color: orange; }
		div#family { color: red; }
		#mydialog { display:none }
		.mydialogId { display:none }
		.sharedialog { display:none }

	</style>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/start/jquery-ui.css"
 type="text/css" rel="Stylesheet" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js"></script>

</head>

<body>
	<div id="main">
		<?php
			ini_set("session.cookie_httponly", 1);
	  	session_start();
		?>
		<div id="welcome"></div>
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
			<table id="calendar">
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
			<input type="button" value="New Event" onclick=showdialog() />
   		<div id="mydialog" title="Add New Event"></div>
		</div>
			<script type="text/javascript">
			(function(){Date.prototype.deltaDays=function(c){return new Date(this.getFullYear(),this.getMonth(),this.getDate()+c)};Date.prototype.getSunday=function(){return this.deltaDays(-1*this.getDay())}})();
function Week(c){this.sunday=c.getSunday();this.nextWeek=function(){return new Week(this.sunday.deltaDays(7))};this.prevWeek=function(){return new Week(this.sunday.deltaDays(-7))};this.contains=function(b){return this.sunday.valueOf()===b.getSunday().valueOf()};this.getDates=function(){for(var b=[],a=0;7>a;a++)b.push(this.sunday.deltaDays(a));return b}}
function Month(c,b){this.year=c;this.month=b;this.nextMonth=function(){return new Month(c+Math.floor((b+1)/12),(b+1)%12)};this.prevMonth=function(){return new Month(c+Math.floor((b-1)/12),(b+11)%12)};this.getDateObject=function(a){return new Date(this.year,this.month,a)};this.getWeeks=function(){var a=this.getDateObject(1),b=this.nextMonth().getDateObject(0),c=[],a=new Week(a);for(c.push(a);!a.contains(b);)a=a.nextWeek(),c.push(a);return c}};
				function display() {
					var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
			    xmlHttp.open("POST", "get_user5.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
			    xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
			    xmlHttp.addEventListener("load", function(event) {
						var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
						var user = jsonData.user;
						document.getElementById("welcome").innerHTML = "Hi, " + user;
					}, false); // Bind the callback to the load event
			    xmlHttp.send(null); // Send the data
					document.getElementById("mydialog").innerHTML='<a>Time:</a><input type="time" id="time" value=""><br><a>Title:</a><input type="text" id="title" value=""><br><a>Note:</a><input type="text" id="note" value=""><br><a>Tags:</a><br><label><input name="tag" id="work" type="radio" value="work" /> Work </label><br /><label><input name="tag" id="academic" type="radio" value="academic" /> Academic</label><br /><label><input name="tag" id="social" type="radio" value="social" /> Social </label><br /><label><input name="tag" id="family" type="radio" value="family" /> Family</label><br /><label><input name="tag" id="undefined" type="radio" value="undefined" /> Undefined </label><br /><label><input type="checkbox" id="repeat" name="repeat"> Repeat Every Week </label><input type="hidden" id="token" name="token" value="'+'<?php if(isset($_SESSION["token"])){echo $_SESSION["token"];}?>'+'" />'
					var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
					var table = document.getElementById("calendar");
					table.caption.innerHTML = "<h2>"+months[currentMonth.month] + " " +currentMonth.year+"</h2>";
					var rows = table.rows;
					while (1 < rows.length){
						table.deleteRow(1);
					}
					for (week = 0; week < currentMonth.getWeeks().length; week++) {
						var row = table.insertRow(-1);
						for (day = 0; day < 7; day++) {
							var cell = row.insertCell(day);
							var date = currentMonth.getWeeks()[week].getDates()[day];
							if (date.getMonth() != currentMonth.month) {
								cell.bgColor = "LightGrey";
							}else if (date.getDate() == currentDate.getDate()) {
								cell.bgColor = "LightBlue";
							}
							getEvents(cell, date);
						}
					}
				}

				function getEvents(cell, date){
					var dateString = "date=" + encodeURIComponent(date.getDate()) + "&month=" + encodeURIComponent(date.getMonth()+1) + "&year=" + encodeURIComponent(date.getFullYear())+"&day="+encodeURIComponent(date.getDay()+1);
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
						if (jsonData.hasEvents) { // in PHP, this was the "success" key in the associative array; in JavaScript, it's the .success property of jsonData
							var events = jsonData.events;
							cell.innerHTML += " " + events.length + " events";
						}
			    }, false); // Bind the callback to the load event
			    xmlHttp.send(dateString); // Send the data
				}

				function showEvents(){
					var dateString = "date=" + encodeURIComponent(currentDate.getDate()) + "&month=" + encodeURIComponent(currentDate.getMonth()+1) + "&year=" + encodeURIComponent(currentDate.getFullYear())+"&day="+encodeURIComponent(currentDate.getDay()+1);
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
							var category = events[i].category;
							var note = events[i].note;
							var id = events[i].event_id;
							var repeat = '';
							if(events[i].repeatt > 0){
								repeat = 'checked';
							}
							var editDiv = '<div id="mydialog'+id+'" class="mydialogId" title="Edit Event"><a>Time:</a><input type="time" value="'+time+'" id="time'+id+'"><br><a>Title:</a><input type="text" value="'+title+'" id="title'+id+'"><br><a>Note:</a><input type="text" value="'+note+'" id="note'+id+'"><br><input type="hidden" id="token'+id+'" name="token" value="'+'<?php if(isset($_SESSION["token"])){echo $_SESSION["token"];}?>'+'" /><a>Tags:</a><br><label><input name="tag'+id+'" id="work" type="radio" value="work" />Work</label><br /><label><input name="tag'+id+'" id="academic" type="radio" value="academic" />Academic</label><br /><label><input name="tag'+id+'" id="social" type="radio" value="social" />Social</label><br /><label><input name="tag'+id+'" id="family" type="radio" value="family" />Family</label><br /><label><input name="tag'+id+'" id="undefined" type="radio" value="undefined" />Undefined</label><br><label><input type="checkbox" id="repeat'+id+'" name="repeat" '+repeat+'>Repeat Every Week</label></div>';
							var shareDiv = "<div id='sharedialog"+id+"' class='sharedialog' title='Share Event'><a>User:</a><input type='text' id='user"+id+"'><input type='hidden' id='token"+id+"' name='token' value='"+"<?php if(isset($_SESSION['token'])){echo $_SESSION['token'];}?>"+"' /></div>";
							eventHTML += "<div id='"+category+"'><h3>"+time+" "+title+"</h3> "+note+"</div><input type='button' value='Edit Event' onclick=editEvent("+id+") />"+editDiv+"<input type='button' value='Share Event' onclick=shareEvent("+id+") />"+shareDiv+"<input type='button' value='Delete Event' onclick=deleteEvent("+id+") /><br>";
						}
						eventLog.innerHTML = eventHTML;
			    }, false); // Bind the callback to the load event
			    xmlHttp.send(dateString); // Send the data
				}

				function deleteEvent(id){
					var token = '<?php if(isset($_SESSION["token"])){echo $_SESSION["token"];}?>';
					var idString = "id=" + encodeURIComponent(id)+"&token="+token;
					var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
			    xmlHttp.open("POST", "delete_event5.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
			    xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
			    xmlHttp.addEventListener("load", function(event) {
			      var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
						if(jsonData.success){
							display();
							showEvents();
						} else {
							alert("Event failed to delete.");
						}
			    }, false); // Bind the callback to the load event
			    xmlHttp.send(idString); // Send the data
				}

				function editEvent(id) {
					var dialogId = "#mydialog"+id;
					$(dialogId).dialog({
						buttons: {
			        "Edit event": function() {
								var time = document.getElementById("time"+id).value;
								var title = document.getElementById("title"+id).value;
								var note = document.getElementById("note"+id).value;
								var token = document.getElementById("token"+id).value;
								var tag_radio_pointers = document.getElementsByName("tag"+id);
								var which_tag = null;
								for(i = 0; i < tag_radio_pointers.length; i++){
									if (tag_radio_pointers[i].checked) {
										which_tag = tag_radio_pointers[i].value;
										break;
									}
								}
								var repeat = 0;
								if(document.getElementById("repeat"+id).checked){
									var repeat = currentDate.getDay()+1;
								}
								var dateString = currentMonth.year+"-"+(currentMonth.month+1)+"-"+currentDate.getDate();
								var dataString = "id="+encodeURIComponent(id)+"&date="+encodeURIComponent(dateString)+"&time="+encodeURIComponent(time)+"&title="+encodeURIComponent(title)+"&note="+encodeURIComponent(note)+"&category="+encodeURIComponent(which_tag)+"&repeat="+encodeURIComponent(repeat)+"&token="+encodeURIComponent(token);
								var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
								xmlHttp.open("POST", "edit_event5.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
								xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
								xmlHttp.addEventListener("load", function(event) {
										var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
										if (jsonData.success) { // in PHP, this was the "success" key in the associative array; in JavaScript, it's the .success property of jsonData
												display();
												showEvents();
										} else {
												alert("Event failed to update.");
										}
								}, false); // Bind the callback to the load event
								xmlHttp.send(dataString); // Send the data

			          $(dialogId).dialog( "close" );
			        }
			      }
					});
				}

				function shareEvent(id) {
					var dialogId = "#sharedialog"+id;
					$(dialogId).dialog({
						buttons: {
			        "Share Event": function() {
								var user = document.getElementById("user"+id).value;
								var token = document.getElementById("token"+id).value;
								var dataString = "id="+encodeURIComponent(id)+"&user="+encodeURIComponent(user)+"&token="+encodeURIComponent(token);
								var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
								xmlHttp.open("POST", "share_event5.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
								xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
								xmlHttp.addEventListener("load", function(event) {
										var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
										if (jsonData.success) { // in PHP, this was the "success" key in the associative array; in JavaScript, it's the .success property of jsonData
												alert("Event shared successfully.")
										} else {
												alert("Event failed to share. " + jsonData.message);
										}
								}, false); // Bind the callback to the load event
								xmlHttp.send(dataString); // Send the data
			          $(dialogId).dialog( "close" );
			        }
			      }
					});
				}

				function showdialog() {
					$("#mydialog").dialog({
						buttons: {
			        "Create an event": function() {
								var time = document.getElementById("time").value;
								var title = document.getElementById("title").value;
								var note = document.getElementById("note").value;
								var token = document.getElementById("token").value;
								var tag_radio_pointers = document.getElementsByName("tag");
								var which_tag = null;
								for(i = 0; i < tag_radio_pointers.length; i++){
									if (tag_radio_pointers[i].checked) {
										which_tag = tag_radio_pointers[i].value;
										break;
									}
								}
								var repeat = 0;
								if(document.getElementById("repeat").checked){
									var repeat = currentDate.getDay()+1;
								}
								var dateString = currentMonth.year+"-"+(currentMonth.month+1)+"-"+currentDate.getDate();
								var dataString = "date="+encodeURIComponent(dateString)+"&time="+encodeURIComponent(time)+"&title="+encodeURIComponent(title)+"&note="+encodeURIComponent(note)+"&category="+encodeURIComponent(which_tag)+"&repeat="+encodeURIComponent(repeat)+"&token="+encodeURIComponent(token);
								var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
						    xmlHttp.open("POST", "new_event5.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
						    xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
						    xmlHttp.addEventListener("load", function(event) {
						        var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
						        if (jsonData.success) { // in PHP, this was the "success" key in the associative array; in JavaScript, it's the .success property of jsonData
						            display();
												showEvents();
						        } else {
						            alert("Event failed to create.");
						        }
						    }, false); // Bind the callback to the load event
						    xmlHttp.send(dataString); // Send the data

			          $("#mydialog").dialog( "close" );
			        }
			      }
					});
				}

				function newDate(date){
					var table = document.getElementById("calendar");
					var week = table.rows[Math.floor((currentDate.getDate()-currentDate.getDay()-2)/7)+2].cells[currentDate.getDay()].bgColor = "White";
					currentDate.setDate(date);
					week = table.rows[Math.floor((currentDate.getDate()-currentDate.getDay()-2)/7)+2].cells[currentDate.getDay()].bgColor = "LightBlue";
					showEvents();
				}

				document.getElementById("calendar").style.height = "200px";
				document.getElementById("calendar").createCaption();
				var currentDate = new Date();
				var currentMonth = new Month(currentDate.getFullYear(), currentDate.getMonth());
				$("#prevBtn").click(function() {
					currentMonth = currentMonth.prevMonth();
					currentDate.setDate(1);
					currentDate.setMonth(currentMonth.month);
					currentDate.setYear(currentMonth.year);
					display();
					showEvents();
				});
				$("#nextBtn").click(function() {
					currentMonth = currentMonth.nextMonth();
					currentDate.setDate(1);
					currentDate.setMonth(currentMonth.month);
					currentDate.setYear(currentMonth.year);
					display();
					showEvents();
				});
				document.addEventListener("DOMContentLoaded", display, false);
				document.addEventListener("DOMContentLoaded", showEvents, false);
			</script>
	</div>
</body>

</html>
