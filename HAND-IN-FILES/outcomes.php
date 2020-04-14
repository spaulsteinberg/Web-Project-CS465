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
	if (!isset($_GET["sectionId"]) || $_GET["sectionId"] == ''){
		die (json_encode(array('Error' => 'Must enter a section ID')));
	}
	else{
		$sectionId = $_GET["sectionId"];
	}
	if ((!isset($_GET["major"]) || $_GET["major"] == '')){
		die (json_encode(array('Error' => 'Invalid or unset major')));
	}
	else
	{
		$approvedMajors = array('CS', 'CpE', 'EE');
		if(!in_array($_GET["major"], $approvedMajors)) die (json_encode(array('Error' => 'Invalid or unset major')));
		$major = $_GET["major"];
	}
	$conn = connect(); //set connection

	//set the query up, prepare the query to sanitize, bind the params, then execute. bind the results
	//...the accepted is to see if anything came up, if false the email or pass is incorrect
    $query = "SELECT O.outcomeId, O.outcomeDescription 
				FROM Outcomes O JOIN CourseOutcomeMapping R ON O.outcomeId=R.outcomeId AND O.major=R.major
				JOIN Sections S ON S.courseId=R.courseId AND S.semester = R.semester AND S.year = R.year
				WHERE S.sectionId=? AND O.major=?
				ORDER BY O.outcomeId";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("is", $sectionId, $major); //ss for types of binded params
	$retArray = array();	
	if ($stmt->execute()) {
		$stmt->bind_result($outcomeId, $outcomeDescription);
		$accepted = false;
		while ($stmt->fetch()) {
			$accepted = true;
			array_push($retArray, array('outcomeId' => $outcomeId, 'outcomeDescription' => $outcomeDescription));
		}
		if(!$accepted){
			echo -1;
		}
		else {
			echo json_encode($retArray);
		}
		$stmt->close();
	}
	else {
		echo -1;
	}
	$conn->close();
?>
