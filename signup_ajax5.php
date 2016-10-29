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
	$stmt->bind_result($userMatch, $pwd_hash);
	$stmt->fetch();

	$pwd_guess = (string)$_POST['password'];

	if($userMatch == null){
			$signup = $mysqli->prepare("INSERT INTO users (username, crypted_password) VALUES (?, ?)");
			$signup->bind_param('ss', $user, $crypted_pass);
			$crypted_pass = crypt($pwd_guess);
			$signup->execute();
			$signup->close();
			echo json_encode(array(
				"success" => true,
			));
			exit;
	}else{
		echo json_encode(array(
			"success" => false,
			"message" => "User already exists."
		));
		exit;
	}
}
?>
