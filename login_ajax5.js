/* Verify user creditials*/
function verify_user_Ajax(event) {
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open("POST", "check_user5.php", true);
    xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlHttp.addEventListener("load", function(event) {
			var jsonData = JSON.parse(event.target.responseText);
      var validUser = jsonData.validUser;
      if (validUser){
        //Hide the sections not needed (login and registration sections, and display the calendar)
        $("#login").hide();
        $("#logout").show();
      }else{
        //Show login, hide logout
        $("#login").show();
        $("#logout").hide();
      }
		}, false);
    xmlHttp.send(null);
}

function loginAjax(event) {
    var username = document.getElementById("username").value; // Get the username from the form
    var password = document.getElementById("password").value; // Get the password from the form

    // Make a URL-encoded string for passing POST data:
    var dataString = "username=" + encodeURIComponent(username) + "&password=" + encodeURIComponent(password);

    var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
    xmlHttp.open("POST", "login_ajax5.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
    xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
    xmlHttp.addEventListener("load", function(event) {
        var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
        if (jsonData.success) { // in PHP, this was the "success" key in the associative array; in JavaScript, it's the .success property of jsonData
            alert("You've been Logged In!");
						$("#login").hide();
			      $("#logout").show();
						location.reload();
        } else {
            alert("You were not logged in.  " + jsonData.message);
        }
    }, false); // Bind the callback to the load event
    xmlHttp.send(dataString); // Send the data
}

function signupAjax(event) {
    var username = document.getElementById("username").value; // Get the username from the form
    var password = document.getElementById("password").value; // Get the password from the form

    // Make a URL-encoded string for passing POST data:
    var dataString = "username=" + encodeURIComponent(username) + "&password=" + encodeURIComponent(password);

    var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
    xmlHttp.open("POST", "signup_ajax5.php", true); // Starting a POST request (NEVER send passwords as GET variables!!!)
    xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); // It's easy to forget this line for POST requests
    xmlHttp.addEventListener("load", function(event) {
        var jsonData = JSON.parse(event.target.responseText); // parse the JSON into a JavaScript object
        if (jsonData.success) { // in PHP, this was the "success" key in the associative array; in JavaScript, it's the .success property of jsonData
            alert("You've been Signed Up!");
						location.reload();
        } else {
            alert("You were not signed up.  " + jsonData.message);
        }
    }, false); // Bind the callback to the load event
    xmlHttp.send(dataString); // Send the data
}

function logoutAjax(event){
	var xmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
    xmlHttp.open("POST", "logout5.php", true);
    xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xmlHttp.addEventListener("load", function(event) {
			$("#login").show();
      $("#logout").hide();
			location.reload();
		}, false);
		xmlHttp.send(null); // Send the data
}

document.addEventListener("DOMContentLoaded", verify_user_Ajax, false);
document.getElementById("login_btn").addEventListener("click", loginAjax, false); // Bind the AJAX call to button click
document.getElementById("signup_btn").addEventListener("click", signupAjax, false);
document.getElementById("logout_btn").addEventListener("click", logoutAjax, false);
