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
		die (-1);
	}
	else{
		$sectionId = stripslashes(trim($_POST["sectionId"]));
	}
	if ((!isset($_POST["major"]) || $_POST["major"] == '')){
		die (-1);
	}
	else
	{
		$approvedMajors = array('CS', 'CpE', 'EE');
		if(!in_array($_POST["major"], $approvedMajors)) die (-1);
		$major = stripslashes(trim($_POST["major"]));
	}
	if (!isset($_POST["outcomeId"]) || $_POST["outcomeId"] == '' || !is_numeric($_POST["outcomeId"])){
		die (-1);
	}
	else {
		$outcomeId = stripslashes(trim($_POST["outcomeId"]));
	}
	if (!isset($_POST["weight"]) || $_POST["weight"] == '' || !is_numeric($_POST["weight"])){
		die (-1);
	}
	else {
		$weight = stripslashes(trim($_POST["weight"]));
	}
	if (!isset($_POST["assessmentDescription"]) || $_POST["assessmentDescription"] == ''){
		echo 0;
		die (-1);
	}
	else {
		$assessmentDescription = stripslashes(trim($_POST["assessmentDescription"]));
		$assessmentDescription = mysqli_real_escape_string($conn, $assessmentDescription);
	}


	//set the query up, prepare the query to sanitize, bind the params, then execute. bind the results
	//...the accepted is to see if anything came up, if false the email or pass is incorrect
    $query = "INSERT INTO Assessments (sectionId, assessmentDescription, weight, outcomeId, major) VALUES(?,?,?,?,?)";

	$stmt = $conn->prepare($query);
	$stmt->bind_param("isiis", $sectionId, $assessmentDescription, $weight, $outcomeId, $major);

	if ($stmt->execute()) {
		$stmt->close();
	}
	else {
		echo 0;
	}
    $query = "SELECT assessmentId FROM  Assessments WHERE sectionId=? AND assessmentDescription=? AND weight=? AND outcomeId=? AND major=?";

	$stmt = $conn->prepare($query);
	$stmt->bind_param("isiis", $sectionId, $assessmentDescription, $weight, $outcomeId, $major);
	if ($stmt->execute()) {
		$stmt->bind_result($assessmentId);
		$accepted = false;
		while ($stmt->fetch()){
			$accepted = true;
			$aId = $assessmentId;
		}
		if (!$accepted){
			echo 0;
		}
		else {
			echo $aId; 
		}
	}
	$stmt->close();
	$conn->close();
?>
