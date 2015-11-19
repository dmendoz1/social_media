<?php
	include 'includes/credentials.php';
	session_start();
	if ($_SESSION['authenticated'] == true) {
    	header('Location: home.php');
    	exit;
	}


    $username = mysqli_real_escape_string($connection, $_POST['user']);
    $password = mysqli_real_escape_string($connection, $_POST['pass']);
	
    // if username and password were submitted, check them
	if(!empty($_POST))
    {
        // prepare SQL
        $sql = sprintf("SELECT 1 FROM members WHERE username='%s' AND password='%s'",
                       $username, $password);
         // execute query
         $queryTwo = sprintf("SELECT ID, firstn, lastn FROM members WHERE username='%s'",
                       $username);
        $result = mysqli_query($connection, $sql);
        $resultTwo = mysqli_query($connection, $queryTwo);
        $row = $resultTwo->fetch_assoc();
        if ($result === false)
            die("Could not query database");

        // check whether we found a row
        if (mysqli_num_rows($result) == 1)
        {
            // remember that user's logged in
            $_SESSION["firstname"] = $row['firstn'];
            $_SESSION["id"] = $row["ID"]; 
            $_SESSION["lastname"] = $row["lastn"];
            $_SESSION["authenticated"] = true;
            exit; 
        }
        else
        {
        	echo "Invalid username or password.  Please try again";
        	exit;
        }
       mysqli_close($connection);
    }
?>