<html>
<head><title>PHP Login Page</title></head>
<body>
    <?php
        //set up the connection here --> this is my local DB for now
        function connect(){
            $servername = "localhost";
            $dbname = "my_test_db";
            $username = "UelBerg";
            $password = "Tiggy921#";
            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            else {
                echo "Connection established successfully";
                echo "<br>";
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
    ?>
    <?php
        error_reporting(E_ALL); //report errors
        ini_set('display_errors', 1); //set display error mode

        //check if isset (whether exists or not) or after sanitizing the input is still bad...considers
        //empty string as true, so also make a check for it.
        if (!isset($_GET["email"]) || $_GET["email"] == ''){
            die (json_encode(array('Error' => 'Invalid or empty email')));
        }
        else {
            $userEmail = sanitize_input($_GET["email"]);
            if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
                die (json_encode(array('Error' => 'Invalid email')));
              }
        }
        if (!isset($_GET["password"]) || sanitize_input($_GET["password"]) == ''){
            die (json_encode(array('Error' => 'Invalid password input')));
        }
        else {
            $userPassword = sanitize_input($_GET["password"]);
        }
        $conn = connect(); //set connection

        //set the query up, prepare the query to sanitize, bind the params, then execute. bind the results
        //...the accepted is to see if anything came up, if false the email or pass is incorrect
        //re-work sql statement for actual use!
        $query = "SELECT firstName, lastName FROM users WHERE email=? AND password=PASSWORD(?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $userEmail, $userPassword); //ss for types of binded params
        if ($stmt->execute()) {
            $stmt->bind_result($fname, $lname);
            $accepted = false;
            while ($stmt->fetch()) {
                $accepted = true;
                echo json_encode(array('firstName' => $fname, 'lastName' => $lname));
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
</body>
</html>