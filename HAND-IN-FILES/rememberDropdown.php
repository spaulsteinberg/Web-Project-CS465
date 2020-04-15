<?php
    session_start();
    if (!isset($_POST["selectedSection"]) || $_POST["selectedSection"] == ''){
		die (json_encode(array('Error' => 'Must enter a section ID')));
	}
	else{
		$_SESSION['selectedSection'] = $_POST["selectedSection"];
    }
    if (!isset($_POST["selectedMajor"]) || $_POST["selectedMajor"] == ''){
		die (json_encode(array('Error' => 'Must enter a major')));
	}
	else{
		$_SESSION['selectedMajor'] = $_POST["selectedMajor"];
    }
    echo $_SESSION['selectedSection'] . " " . $_SESSION['selectedMajor'];
?>