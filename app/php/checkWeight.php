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

    $query = "SELECT 
				a.sectionId, i.email, a.outcomeId, a.major, SUM(a.weight) as `weightTotal`
			  FROM
				Sections s, Instructors i, Assessments a
			  WHERE
				s.sectionId = a.sectionId AND
				s.instructorId = i.instructorId
			  GROUP BY
				a.outcomeId,
				a.sectionId
			  HAVING 
				SUM(a.weight) != 100
			  ORDER BY
				i.email ASC,
				a.major ASC,
				a.outcomeId ASC";

	$stmt = $conn->prepare($query);

	if ($stmt->execute()) {
		$stmt->bind_result($sectionId, $email, $outcomeId, $major, $weightTotal);
		$accepted = false;
		while ($stmt->fetch()) {
			$email = htmlspecialchars($email);
			$accepted = true;
			echo json_encode(array('sectionId' => $sectionId, 'email' => $email, 'outcomeId' => $outcomeId,
								   'major' => $major, 'weightTotal' => $weightTotal), JSON_PRETTY_PRINT);
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
