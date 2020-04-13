<?php
//set up the connection here --> this is my local DB for now
	function connect(){
		$servername = "dbs2.eecs.utk.edu";
		$dbname = "cosc465_ssteinb2";
		$username = "ssteinb2";
		$password = "Tigers812@";
		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		// Check connection
		if ($conn->connect_error) {
			die(json_encode(array('Connection failed' => $conn->connect_error)));
		}
		return $conn;
	}
	//function from W3 schools!
	function sanitize_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	error_reporting(E_ALL); //report errors
	ini_set('display_errors', 1); //set display error mode

	$conn = connect(); //set connection
	if (!isset($_GET["email"]) || $_GET["email"] == ''){
		die (json_encode(array('Error' => 'Invalid or empty email')));
	}
	else {
		$userEmail = sanitize_input($_GET["email"]);
		$userEmail = mysqli_real_escape_string($conn, $userEmail);
		if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
			die (json_encode(array('Error' => 'Invalid email')));
		  }
	}
	if (!isset($_GET["password"]) || sanitize_input($_GET["password"]) == ''){
		die (json_encode(array('Error' => 'Invalid password input')));
	}
	else {
		$userPassword = sanitize_input($_GET["password"]);
	}
	echo "Email is: " . $userEmail . " Password is: " . $userPassword;
    $query = "UPDATE Instructors
			  SET password=PASSWORD(?)
			  WHERE email=?";

	$stmt = $conn->prepare($query);
	$stmt->bind_param("ss", $userPassword, $userEmail); //ss for types of binded params
	if ($stmt->execute()) {
		$stmt->close();
	}
	else {
		echo json_encode(array('msg' => 'Query failed.'));
	}
	$conn->close();
?>
