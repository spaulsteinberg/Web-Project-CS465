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
	if (!isset($_GET["outcomeId"]) || $_GET["outcomeId"] == ''){
		die (json_encode(array('Error' => 'Must enter a valid outcome ID')));
	}
	else {
		$outcomeId = $_GET["outcomeId"];
	}
	$conn = connect(); //set connection

	//set the query up, prepare the query to sanitize, bind the params, then execute. bind the results
	//...the accepted is to see if anything came up, if false the email or pass is incorrect
    $query = "SELECT 
				p.description, o.numberOfStudents
			  FROM 
				PerformanceLevels p, OutcomeResults o 
			  WHERE 
				o.outcomeId = ? AND
				o.major = ? AND
				o.sectionId = ? AND
				o.performanceLevel = p.performanceLevel
			  ORDER BY
				p.performanceLevel";

	$stmt = $conn->prepare($query);
	$stmt->bind_param("isi", $outcomeId, $major, $sectionId); //ss for types of binded params

	if ($stmt->execute()) {
		$stmt->bind_result($performanceDescription, $numberOfStudents);
		$accepted = false;
		while ($stmt->fetch()) {
			$accepted = true;
			echo json_encode(array('performanceDescription' => $performanceDescription, 'numberOfStudents' => $numberOfStudents));
		}
		if(!$accepted){
			echo json_encode(array('msg' => 'No results'));
		}
		$stmt->close();
	}
	else {
		echo json_encode(array('msg' => 'Query failed.'));
	}
	$conn->close();
?>
