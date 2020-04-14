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

	//check if isset (whether exists or not) or after sanitizing the input is still bad...considers
	//empty string as true, so also make a check for it.
	if (!isset($_POST["email"]) || $_POST["email"] == ''){
		die (json_encode(array('Error' => 'Invalid or empty email')));
	}
	else {
		$userEmail = sanitize_input($_POST["email"]);
		if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
			die (json_encode(array('Error' => 'Invalid email')));
		  }
	}
	if (!isset($_POST["password"]) || sanitize_input($_POST["password"]) == ''){
		die (json_encode(array('Error' => 'Invalid password input')));
	}
	else {
		$userPassword = sanitize_input($_POST["password"]);
	}
	$conn = connect(); //set connection
	session_start();
	//set the query up, prepare the query to sanitize, bind the params, then execute. bind the results
	//...the accepted is to see if anything came up, if false the email or pass is incorrect
    $query = "SELECT 
				i.instructorId, i.firstname, i.lastname, s.sectionId, s.courseId, c.major, s.semester, s.year
			  FROM 
				Sections s NATURAL JOIN Instructors i LEFT JOIN CourseOutcomeMapping c ON c.courseId=s.courseId 
			  WHERE 
				i.email=? AND 
				i.password=PASSWORD(?)
			  GROUP BY
				s.sectionId,
				c.major
			  ORDER BY
				year DESC,
				semester ASC";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("ss", $userEmail, $userPassword); //ss for types of binded params
	if ($stmt->execute()) {
		$stmt->bind_result($instructorId, $firstname, $lastname, $sectionId, $courseId, $major, $semester, $year);
		$accepted = false;
		$_SESSION['menuItems'] = array();
		$_SESSION['sectionId'] = array();
		$_SESSION['major'] = array();
		$_SESSION['courseId'] = array();
		$_SESSION['semester'] = array();
		$_SESSION['year'] = array();
		while ($stmt->fetch()) {
			$menuString = $courseId . " " . $semester . " " . $year . " " . $major;
			$accepted = true;
			$_SESSION['email'] = $userEmail;
			$_SESSION['instructorId'] = $instructorId;
			$_SESSION['firstname'] = $firstname;
			$_SESSION['lastname'] = $lastname;
			array_push($_SESSION['menuItems'], $menuString);
			array_push($_SESSION['sectionId'], $sectionId);
			array_push($_SESSION['major'], $major);
			array_push($_SESSION['courseId'], $courseId);
			array_push($_SESSION['semester'], $semester);
			array_push($_SESSION['year'], $year);
		}
		if(!$accepted){
			echo 0;
			session_destroy();
		}
		else{
			echo 1;
		}
		$stmt->close();
	}
	else {
		echo 0;
	}
	$conn->close();
?>
