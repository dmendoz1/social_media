<?php
	include 'credentials.php';
	session_start();

    $usernameNew = mysqli_real_escape_string($connection, $_POST['usernameNew']);
    $passwordNew = mysqli_real_escape_string($connection, $_POST['passwordNew']);
    $passwordAgain = mysqli_real_escape_string($connection, $_POST['passwordAgain']);
    $firstName = mysqli_real_escape_string($connection, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($connection, $_POST['lastName']);
    $age = mysqli_real_escape_string($connection, $_POST['age']);
    $hometown = mysqli_real_escape_string($connection, $_POST['hometown']);
    $sex = mysqli_real_escape_string($connection, $_POST['sex']);

    // if username and password were submitted, check them
	if(!empty($_POST))
    {
        // prepare SQL
        $sql = sprintf("SELECT 1 FROM members WHERE username='%s'",
                       $usernameNew);
         // execute query
        $result = mysqli_query($connection, $sql);
        if ($result === false)
            die("Could not query database");

        // check whether we found a row
        if (mysqli_num_rows($result) == 0)
        {	
        	if($passwordNew == $passwordAgain) {
        		$_SESSION["authenticated"] = true;
        		$_SESSION["firstname"] = $firstName;
        		$_SESSION["lastname"] = $lastName;
        		$sql2 = "INSERT INTO members (firstn, lastn, password, password_retype, username, age, hometown, sex) VALUES ('$firstName', '$lastName', '$passwordNew', '$passwordAgain', '$usernameNew', '$age', '$hometown', '$sex');";
        		$connection->query($sql2);
        		$sql3 = sprintf("SELECT ID FROM members WHERE username='%s'", $usernameNew);
        		$sql3Result = mysqli_query($connection, $sql3);
        		$row = $sql3Result->fetch_assoc();
        		$_SESSION["id"] = $row["ID"];
        		echo "success";
        		exit;  
        	}
        	else
        		echo "Passwords did not match.  Please try again";
        		exit;
        }
        else
        {
        	echo "That username has already been taken.  Please try a different one.";
            exit; 
        }
        mysqli_close($connection);
       
    }
?>