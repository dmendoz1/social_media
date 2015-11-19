<?php
	include_once('credentials.php');
	if ( !class_exists('DISPLAY') ) 
	{
		class DISPLAY 
		{
			public function load_user($user_id) {
				global $connection;
				$table = 'members';
				$query = "SELECT * FROM $table WHERE ID = $user_id";
				$result = mysqli_query($connection, $query);
				if(!result)
					echo 'no user found';
				$obj = $result->fetch_object();
				return $obj;
			}

			public function all_members($logged_user_id) {
				global $connection;
				$table = 'members';	
				$query = "SELECT firstn, lastn, ID, image FROM $table ORDER BY firstn asc";			
				$obj = mysqli_query($connection, $query);
				if (mysqli_num_rows($obj) == 0)
					echo "No members found";	
				else		
				{
					while ($result = $obj->fetch_assoc()) 
					{ 
						if(!($result["ID"] == $logged_user_id)) {?>
							<div class="directory_item">
								<span><a href="/boot/friend_profile.php?uid=<?php echo $result["ID"]; ?>"><?php	echo $result["firstn"] . " " . $result["lastn"] . " <br>"; ?></a></span>
								<?php if(empty($result["image"])) { ?>
											<img class="member_names" width='80' height='80' src="pictures/default.jpg" alt="Profile Pic" >
								<?php	   }
										else 
											echo "<img width='80' class='member_names' height='80' src='pictures/".$result['image']."' alt='Profile Pic'> ";
								?>
							</div>		
				<?php	}
						else { ?>
							<div class="directory_item">
								<span><a href="/boot/profile_view.php"><?php	echo $result["firstn"] . " " . $result["lastn"] . " <br>"; ?></a></span>
								<?php if(empty($result["image"])) { ?>
											<img class="member_names" width='80' height='80' src="pictures/default.jpg" alt="Profile Pic" >
								<?php	   }
										else 
											echo "<img width='80' class='member_names' height='80' src='pictures/".$result['image']."' alt='Profile Pic'> ";
								?>
							</div>	<?php
						}
					}
				}
			}  
			
			
			
				
			public function get_following_friends($user_id) {
				global $connection;
				$table = 'friends';
				$query = "SELECT ID, friend_id FROM $table WHERE user_id = '$user_id' ORDER BY ID ASC";
				$friends = mysqli_query($connection, $query);
				if(!$friends)
					echo "<br><br><br> You have no friends yet!";
				while ( $obj = $friends->fetch_object() ) {
					$results[] = $obj;
				}
				if (is_array($results) || is_object($results)) {
					foreach ( $results as $friend ) 
						$friend_ids[] = $friend->friend_id;
				}
				return $friend_ids;
			}
			
			public function following_list($friends_array, $logged_user_id) {
				foreach ($friends_array as $friend_id) 
					$users[] = $this->load_user($friend_id);
				if(!empty($users)) {
					foreach ($users as $user) { 
						if($user->ID == $logged_user_id)
						{ ?>
							<a class="following_names" href="/boot/profile_view.php">
								<?php echo "$user->firstn $user->lastn"; ?>
							</a> 
				<?php 	}
						else { ?>
							<a class="following_names" href="/boot/friend_profile.php?uid=<?php echo $user->ID; ?>">
								<?php echo "$user->firstn $user->lastn"; ?>
							</a>
						<?php
						}
					}
				}
				else
					echo "<span style='font-weight: normal;'>no one yet </span>";
			}
			
			
			public function get_followers_friends($user_id) {
				global $connection;
				$table = 'friends';
				$query = "SELECT ID, user_id, friend_id FROM $table WHERE friend_id = '$user_id' ORDER BY ID ASC";
				$friends = mysqli_query($connection, $query);
				if(!$friends)
					echo "<br><br><br> You have no friends yet!";
				while ( $obj = $friends->fetch_object() ) {
					$results[] = $obj;
				}
				foreach ( $results as $follower ) 
					$follower_ids[] = $follower->user_id;
				return $follower_ids;
			}
			
			public function followers_list($followers_array, $logged_user_id) {
				foreach ($followers_array as $follower_id) 
					$users[] = $this->load_user($follower_id);
				if(!empty($users)) {
					foreach ($users as $user) { 
						if($user->ID == $logged_user_id)
						{ ?>
							<a class="following_names" href="/boot/profile_view.php">
								<?php echo "$user->firstn $user->lastn"; ?>
							</a> 
				<?php 	}
						else { ?>
							<a class="following_names" href="/boot/friend_profile.php?uid=<?php echo $user->ID; ?>">
								<?php echo "$user->firstn $user->lastn"; ?>
							</a>
						<?php
						}
					}
				}
				else
					echo "<span style='font-weight: normal;'>no one yet </span>";
			}
				
				
				
				
				
			
			public function get_message_objects($user_id) {
				global $connection;
				$table = 'messages';
				$query = "SELECT * FROM $table WHERE recipient_id = '$user_id' ORDER BY ID DESC";
				$result = mysqli_query($connection, $query);
				while ( $obj = $result->fetch_object() ) {
					$results[] = $obj;
				}
				return $results;
			}
			
			public function do_inbox($user_id) {
				$message_objects = $this->get_message_objects($user_id);
				if($message_objects > 0) {
					?> <h3> Messages </h3> <?php
					foreach ( $message_objects as $message ) {?>
						<div class="message-item">
							<?php $user = $this->load_user($message->sender_id); ?>
							<h5><a href="profile_view.php?uid=<?php echo $user->ID; ?>"><?php echo "$user->firstn $user->lastn"; ?></a></h3>
							<hr color='gray'>
							<p> <?php echo $message->content; ?></p>
							<p class="dateTime"> <?php echo $message->time;?> </p>
						</div>
					<?php
					}
				}
				else
					echo "You have no inbox messages yet!";
			}
			
			public function get_status_objects($user_id) {
				global $connection;
				$table = 'status';
				$friend_ids = $this->get_following_friends($user_id);
				
				if (!empty( $friend_ids )) 
					array_push($friend_ids, $user_id);
				else 
					$friend_ids = array($user_id);
				$accepted_ids = implode(', ', $friend_ids);
				$query = "SELECT * FROM $table WHERE user_id IN ($accepted_ids) ORDER BY ID DESC";
				$result = mysqli_query($connection, $query);
				while ( $obj = $result->fetch_object() ) {
					$results[] = $obj;
				}
				return $results;
			}
			
			public function get_personal_posts($logged_user_id, $user_id) {
				global $connection;
				$table = 'status';
				$query = "SELECT * FROM $table WHERE user_id= '$user_id' ORDER BY ID DESC";
				$result_query = mysqli_query($connection, $query);
				while ( $obj = $result_query->fetch_object() ) {
					$results[] = $obj;
				}
				if($results > 0) {
					foreach ( $results as $result ) {?>
						<?php $user = $this->load_user($result->user_id); 
						if($user->ID == $logged_user_id) { ?>
							<div class="status_item">
								<span><a href="/boot/profile_view.php"><?php echo "$user->firstn $user->lastn"; ?></a></span>
								<hr>
								<span class="status-content"><?php echo $result->status_content; ?></span><br>
								<span class="dateTime"><?php echo $result->status_time; ?></span>
							</div>
					<?php } 
						else {  ?>
							<div class="status_item">
								<span><a href="/boot/friend_profile.php?uid=<?php echo $user->ID; ?>"><?php echo "$user->firstn $user->lastn"; ?></a></span>
								<hr>
								<span class="status-content"><?php echo $result->status_content; ?></span><br>
								<span class="dateTime"><?php echo $result->status_time; ?></span>
							</div>
							<?php
							}
						}
					}
				else
					echo "<span style='font-weight: normal'> No posts by this user have been made yet! </span>";
			}
			
			
			public function news_feed($user_id) {
				$status_objects = $this->get_status_objects($user_id);
				if($status_objects > 0) {
					?> <h3> Status Feed </h3> <?php
					foreach ( $status_objects as $status ) {?>
							<?php $user = $this->load_user($status->user_id); 
							if($user->ID == $user_id) { ?>
								<div class="status_item">
									<span><a href="/boot/profile_view.php"><?php echo "$user->firstn $user->lastn"; ?></a></span>
									<hr>
									<span class="status-content"><?php echo $status->status_content; ?></span><br>
									<span class="dateTime"><?php echo $status->status_time; ?></span>
								</div>
						<?php }
							else {	?>
								<div class="status_item">
									<span><a href="/boot/friend_profile.php?uid=<?php echo $user->ID; ?>"><?php echo "$user->firstn $user->lastn"; ?></a></span>
									<hr>
									<span class="status-content"><?php echo $status->status_content; ?></span><br>
									<span class="dateTime"><?php echo $status->status_time; ?></span>
								</div>
							<?php
							}
					} 
				}
				else
					echo "No one that you are following has posted anything yet!";
			}
			
			public function profile_pic($user_id) {
				global $connection;
				$table = 'members';
				$query = "SELECT image FROM members WHERE ID= $user_id";
				$result = mysqli_query($connection, $query);
				$image = $result->fetch_assoc();
				if($image['image'] == "")
					echo "<img width='150' height='150' src='pictures/default.jpg' alt='Default Profile Pic'>";
				else {
					echo "<img width='150' height='150' src='pictures/".$image['image']."' alt='Profile Pic'> ";
					}
				echo "<br>";  
			}
		}
	}	
	$display = new DISPLAY;
?>



