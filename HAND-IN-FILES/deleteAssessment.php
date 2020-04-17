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
		$conn->set_charset("utf-8");
		return $conn;
	}

	error_reporting(E_ALL); //report errors
	ini_set('display_errors', 1); //set display error mode

	$conn = connect(); //set connection
	if (!isset($_POST["assessmentId"]) || $_POST["assessmentId"] == '' || !is_numeric($_POST["assessmentId"])){
		die (json_encode(array('Error' => 'Must enter a valid number for assessment ID')));
	}
	else {
		$assessmentId = stripslashes(trim($_POST["assessmentId"]));
	}

    $query = "DELETE FROM Assessments
			  WHERE assessmentId=?";

	$stmt = $conn->prepare($query);
	$stmt->bind_param("i", $assessmentId);

	if ($stmt->execute()) {
		echo 1;
	}
	else {
		echo 0;
	}
	$stmt->close();
	$conn->close();
?>
