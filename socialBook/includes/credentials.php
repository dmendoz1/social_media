<?php
	$hostname = "localhost";
	$username = "root";
	$password = "root";
	$database = "social";   
	// connect to database
    if (($connection = mysqli_connect($hostname, $username, $password, $database)) === false)
    {
        echo "Could not connect to database";
    }  
?>