<?php
require 'database5.php';
header("Content-Type: application/json"); // Since we are sending a JSON response here (not an HTML document), set the MIME Type to application/json

$username = $_POST['username'];
$password = $_POST['password'];

if(preg_match('/^[\w_\-]+$/', $username) || preg_match('/^[\w_\-]+$/', $password)){
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
	if(crypt($pwd_guess, $pwd_hash)==$pwd_hash){
		// Login succeeded!
		session_start();
		$_SESSION['currentUser'] = $user;
		$_SESSION['token'] = substr(md5(rand()), 0, 10); // generate a 10-character random string

		echo json_encode(array(
			"success" => true,
		));
		exit;
	}else{
		echo json_encode(array(
			"success" => false,
			"message" => "Incorrect Username or Password"
		));
		exit;
	}
}else{
	echo json_encode(array(
		"success" => false,
		"message" => "Incorrect Username or Password"
	));
	exit;
}
// if($_POST['action'] == 'Sign Up') {
// 	if($username == null){
// 		$signup = $mysqli->prepare("INSERT INTO users (username, crypted_password) VALUES (?, ?)");
// 		$signup->bind_param('ss', $user, $crypted_pass);
// 		$crypted_pass = crypt($pwd_guess);
// 		$signup->execute();
// 		$signup->close();
// 		header("Location: home3.php");
// 		exit;
// 	}else{
// 		printf("Sorry, the username exists. Try another username.");
// 	}
// }
?>
