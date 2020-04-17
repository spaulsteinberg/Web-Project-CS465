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
	if (!isset($_POST["strengths"]) || $_POST["strengths"] == ''){
		die (json_encode(array('Error' => 'Bad strength input')));
	}
	else {
		$strengths = stripslashes(trim($_POST["strengths"]));
		$strengths = mysqli_real_escape_string($conn, $strengths);
	}
	if (!isset($_POST["weaknesses"]) || $_POST["weaknesses"] == ''){
		die (json_encode(array('Error' => 'Bad weakness input')));
	}
	else {
		$weaknesses = stripslashes(trim($_POST["weaknesses"]));
		$weaknesses = mysqli_real_escape_string($conn, $weaknesses);
	}
	if (!isset($_POST["actions"])){
		die (json_encode(array('Error' => 'Bad action input')));
	}
	else {
		$actions = stripslashes(trim($_POST["actions"]));
		$actions = mysqli_real_escape_string($conn, $actions);
	}


	//set the query up, prepare the query to sanitize, bind the params, then execute. bind the results
	//...the accepted is to see if anything came up, if false the email or pass is incorrect
    $query = "INSERT INTO Narratives VALUES(?,?,?,?,?,?)
			  ON DUPLICATE KEY UPDATE strengths=?, weaknesses=?, actions=?, sectionId=?, outcomeId=?, major=?";

	$stmt = $conn->prepare($query);
	$stmt->bind_param("isissssssiis", $sectionId, $major, $outcomeId, $strengths, $weaknesses, $actions, $strengths, $weaknesses, $actions, $sectionId, $outcomeId, $major);

	if ($stmt->execute()) {
		echo 1;
	}
	else {
		echo 0;
	}
	$stmt->close();
	$conn->close();
?>
