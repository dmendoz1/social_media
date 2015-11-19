<? 
    // enable session
    session_start();
	include 'includes/credentials.php';
	global $connection;
	$me = $_SESSION["id"];
    $partialStates = $_POST['partialState'];
    $query = "SELECT firstn, id, image, lastn FROM members WHERE firstn LIKE '%$partialStates%' OR lastn LIKE '%$partialStates%' ORDER BY firstn LIMIT 5";
    $states = mysqli_query($connection, $query);
    while($stateArray= mysqli_fetch_array($states)) {
    	if($stateArray['id'] == $me) {
			if($stateArray['image'] == "")
				echo "<span><img width='40' class='search-pics' height='40' src='pictures/default.jpg' alt='Profile Pic'> "."<a href='/boot/profile_view.php'>".$stateArray['firstn']."&nbsp;".$stateArray['lastn']."</a></span><br>";
			else
				echo "<span><img width='40' class='search-pics' height='40' src='pictures/".$stateArray['image']."' alt='Profile Pic'> "."<a href='/boot/profile_view.php'>".$stateArray['firstn']." ".$stateArray['lastn']."</a></span><br>";
		}
		else {
			if($stateArray['image'] == "")
				echo "<span><img width='40' class='search-pics' height='40' src='pictures/default.jpg' alt='Profile Pic'> "."<a href='/boot/friend_profile.php?uid=".$stateArray['id']."'>".$stateArray['firstn']."&nbsp;".$stateArray['lastn']."</a></span><br>";
			else
				echo "<span><img width='40' class='search-pics' height='40' src='pictures/".$stateArray['image']."' alt='Profile Pic'> "."<a href='/boot/friend_profile.php?uid=".$stateArray['id']."'>".$stateArray['firstn']." ".$stateArray['lastn']."</a></span><br>";
		}
																																					
	}																							
?>