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
    ?>
    <?php
        error_reporting(E_ALL); //report errors
        ini_set('display_errors', 1); //set display error mode

        /* SANITIZE!!!!! check if email/pass set */
        $userEmail = $_GET["email"];
        $userPassword = $_GET["password"];
        echo "<p> The email is $userEmail and the password is $userPassword </p>";
        $conn = connect(); //set connection

        //set the query up, prepare the query to sanitize, bind the params, then execute. bind the results
        //...the accepted is to see if anything came up, if false the email or pass is incorrect
        //re-work sql statement for actual use
        $query = "SELECT firstName, lastName FROM users WHERE email=? AND password=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $userEmail, $userPassword);
        if ($stmt->execute()) {
            $stmt->bind_result($fname, $lname);
            $accepted = false;
            while ($stmt->fetch()) {
                $accepted = true;
                printf("%s %s\n", $fname, $lname);
            }
            if(!$accepted){
                echo "No results!";
            }
            $stmt->close();
        }
        else {
            die("Query failed.");
        }
        $conn->close();
    ?>
</body>
</html>