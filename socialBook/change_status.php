<?php
    // enable session
    session_start();
     if ($_SESSION['authenticated'] == false) {
    	header('Location: index.php');
    	exit;
	}
	include 'includes/credentials.php';
	$logged_user_id = $_SESSION["id"];
	global $connection;
	$table = 'notifications_messages';
	$query= "UPDATE $table SET status='0' WHERE status='1' AND recipient_id='$logged_user_id'";
	$result = mysqli_query($connection, $query);
	
?>