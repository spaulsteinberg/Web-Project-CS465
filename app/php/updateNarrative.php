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
	if (!isset($_GET["sectionId"]) || $_GET["sectionId"] == '' || !is_numeric($_GET["sectionId"])){
		die (json_encode(array('Error' => 'Must enter a section ID')));
	}
	else{
		$sectionId = stripslashes(trim($_GET["sectionId"]));
	}
	if ((!isset($_GET["major"]) || $_GET["major"] == '')){
		die (json_encode(array('Error' => 'Invalid or unset major')));
	}
	else
	{
		$approvedMajors = array('CS', 'CpE', 'EE');
		if(!in_array($_GET["major"], $approvedMajors)) die (json_encode(array('Error' => 'Invalid or unset major')));
		$major = stripslashes(trim($_GET["major"]));
	}
	if (!isset($_GET["outcomeId"]) || $_GET["outcomeId"] == '' || !is_numeric($_GET["outcomeId"])){
		die (json_encode(array('Error' => 'Must enter a valid outcome ID')));
	}
	else {
		$outcomeId = stripslashes(trim($_GET["outcomeId"]));
	}
	if (!isset($_GET["strengths"]) || $_GET["strengths"] == ''){
		die (json_encode(array('Error' => 'Bad strength input')));
	}
	else {
		$strengths = stripslashes(trim($_GET["strengths"]));
		$strengths = mysqli_real_escape_string($conn, $strengths);
	}
	if (!isset($_GET["weaknesses"]) || $_GET["weaknesses"] == ''){
		die (json_encode(array('Error' => 'Bad weakness input')));
	}
	else {
		$weaknesses = stripslashes(trim($_GET["weaknesses"]));
		$weaknesses = mysqli_real_escape_string($conn, $weaknesses);
	}
	if (!isset($_GET["actions"]) || $_GET["actions"] == ''){
		die (json_encode(array('Error' => 'Bad action input')));
	}
	else {
		$actions = stripslashes(trim($_GET["actions"]));
		$actions = mysqli_real_escape_string($conn, $actions);
	}


	//set the query up, prepare the query to sanitize, bind the params, then execute. bind the results
	//...the accepted is to see if anything came up, if false the email or pass is incorrect
    $query = "UPDATE Narratives
			  SET strengths=?, weaknesses=?, actions=?
			  WHERE sectionId=? AND outcomeId=? AND major=?";

	$stmt = $conn->prepare($query);
	$stmt->bind_param("sssiis", $strengths, $weaknesses, $actions, $sectionId, $outcomeId, $major);

	if ($stmt->execute()) {


	}
	else {
		echo json_encode(array('msg' => 'Query failed.'));
	}
	$stmt->close();
	$conn->close();
?>
