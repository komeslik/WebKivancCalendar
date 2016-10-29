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
	</style>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" type="text/javascript"></script>
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
							cell = row.insertCell(day);
							var date = currentMonth.getWeeks()[week].getDates()[day];
							cell.innerHTML = date.getDate();
							if (date.getMonth() != currentMonth.month) {
								cell.bgColor = "LightGrey";
							}else if (date.getDate() == currentDate.getDate()) {
								cell.bgColor = "LightBlue";
							}
						}
					}
				}
				document.getElementById("calendar").style.height = "200px";
				document.getElementById("calendar").createCaption();
				var currentMonth = new Month(2016, 9);
				var currentDate = new Date();
				$("#prevBtn").click(function() {
					currentMonth = currentMonth.prevMonth();
					display();
				});
				$("#nextBtn").click(function() {
					currentMonth = currentMonth.nextMonth();
					display();
				});
				document.addEventListener("DOMContentLoaded", display, false);
			</script>
		</div>
	</div>
</body>

</html>
