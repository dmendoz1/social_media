<? 
    // enable session
    session_start();
    if ($_SESSION['authenticated'] == false) {
    	header('Location: index.php');
    	exit;
	}
	require_once('includes/display.php');
	$logged_user_id = $_SESSION["id"];
	
	echo $display->do_inbox($logged_user_id); 

?>