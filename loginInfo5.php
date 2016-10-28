<?php
require 'database3.php';
$username1 = $_POST['username'];
if( !preg_match('/^[\w_\-]+$/', $username1) ){
	echo "Invalid username";
	exit;
}
$username1 = $_POST['password'];
if( !preg_match('/^[\w_\-]+$/', $username1) ){
	echo "Invalid password";
	exit;
}
$stmt = $mysqli->prepare("SELECT username, crypted_password FROM users WHERE username=?");

// Bind the parameter
$stmt->bind_param('s', $user);
$user = (string)$_POST['username'];
$stmt->execute();

// Bind the results
$stmt->bind_result($username, $pwd_hash);
$stmt->fetch();

$pwd_guess = (string)$_POST['password'];
// Compare the submitted password to the actual password hash
if($_POST['action'] == 'Log In'){
	if(crypt($pwd_guess, $pwd_hash)==$pwd_hash){
		// Login succeeded!
		session_start();
		$_SESSION['currentUser'] = $user;
		$_SESSION['token'] = substr(md5(rand()), 0, 10); // generate a 10-character random string
		// Redirect to your target page
		header("Location: user_home3.php");
	}else{
		// Login failed; redirect back to the login screen
		printf("Sorry, seems like you entered a wrong username.");
		header("Location: home3.php");
	}
}else if($_POST['action'] == 'Sign Up') {
	if($username == null){
		$signup = $mysqli->prepare("INSERT INTO users (username, crypted_password) VALUES (?, ?)");
		$signup->bind_param('ss', $user, $crypted_pass);
		$crypted_pass = crypt($pwd_guess);
		$signup->execute();
		$signup->close();
		header("Location: home3.php");
		exit;
	}else{
		printf("Sorry, the username exists. Try another username.");
	}
}
?>
