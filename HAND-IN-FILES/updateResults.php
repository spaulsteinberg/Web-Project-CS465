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

	//check if isset (whether exists or not) or after sanitizing the input is still bad...considers
	//empty string as true, so also make a check for it.
	if (!isset($_POST["sectionId"]) || $_POST["sectionId"] == '' || !is_numeric($_POST["sectionId"])){
		die (json_encode(array('Error' => 'Must enter a section ID')));
	}
	else{
		$sectionId = stripslashes(trim($_POST["sectionId"]));
	}
	if ((!isset($_POST["major"]) || $_POST["major"] == '')){
		die (json_encode(array('Error' => 'Invalid or unset major')));
	}
	else
	{
		$approvedMajors = array('CS', 'CpE', 'EE');
		if(!in_array($_POST["major"], $approvedMajors)) die (json_encode(array('Error' => 'Invalid or unset major')));
		$major = stripslashes(trim($_POST["major"]));
	}
	if (!isset($_POST["outcomeId"]) || $_POST["outcomeId"] == '' || !is_numeric($_POST["outcomeId"])){
		die (json_encode(array('Error' => 'Must enter a valid outcome ID')));
	}
	else {
		$outcomeId = stripslashes(trim($_POST["outcomeId"]));
	}
	if (!isset($_POST["performanceLevel"]) || $_POST["performanceLevel"] == ''){
		die (json_encode(array('Error' => 'Must enter a valid performance level')));
	}
	else {
		$levels = array(1, 2, 3);
		if(!in_array($_POST["performanceLevel"], $levels)) die (json_encode(array('Error' => 'Invalid or unset performance level')));
		$performanceLevel = stripslashes(trim($_POST["performanceLevel"]));
	}
	if (!isset($_POST["numberOfStudents"]) || $_POST["numberOfStudents"] == '' || !is_numeric($_POST["numberOfStudents"])){
		die (json_encode(array('Error' => 'Needs a valid number')));
	}
	else {
		$numberOfStudents = stripslashes(trim($_POST["numberOfStudents"]));
	}

	$conn = connect(); //set connection

	//set the query up, prepare the query to sanitize, bind the params, then execute. bind the results
	//...the accepted is to see if anything came up, if false the email or pass is incorrect
    $query = "INSERT INTO OutcomeResults VALUES(?,?,?,?,?)
			  ON DUPLICATE KEY UPDATE performanceLevel=?, numberOfStudents=?, sectionId=?, outcomeId=?, major=?";

	$stmt = $conn->prepare($query);
	$stmt->bind_param("iisiiiiiis", $sectionId, $outcomeId, $major, $performanceLevel, $numberOfStudents, $performanceLevel, $numberOfStudents, $sectionId, $outcomeId, $major);

	if ($stmt->execute()) {
		echo 1;
		$stmt->close();
	}
	else {
		echo 0;
	}
	$conn->close();
?>
