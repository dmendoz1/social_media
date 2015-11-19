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
	$table = 'notifications_followers';
    $query = "SELECT id, status, recipient_id, sender_id, firstn, lastn FROM $table WHERE status='1' AND recipient_id='$logged_user_id'";
    $result = mysqli_query($connection, $query);
    if($result > 0) {
    	while ( $obj = $result->fetch_object() ) {
			$followers[] = $obj;
		}
		if (is_array($followers) || is_object($followers)) {
			foreach ($followers as $follower ) { ?>
				<div class="follower_notification" id="<?php echo $follower->id; ?>">
					<button class="follow-notification-close" id="<?php echo $follower->id; ?>" onclick="notifDisappear(this)" name='notif<?php echo $follower->id; ?>'> <img src="pictures/close.png" width="15" alt="close" /></button>
					<a href='/boot/friend_profile.php?uid=<?php echo "$follower->sender_id"; ?>'> <?php echo "$follower->firstn $follower->lastn"; ?> </a><?php echo "has followed you!"; ?>			
				</div> 
<?php 		}
		}
	}
	else
		echo "no new followers";
?>


