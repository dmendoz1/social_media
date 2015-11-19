<?php
	include_once('credentials.php');
	if ( !class_exists('MODIFY') ) {
		class MODIFY {
			public function update_user($user_id, $postdata) {
				global $connection;
				$table = 'members';
				$query = "UPDATE $table SET firstn='$postdata[firstn]', 
				lastn='$postdata[lastn]', username='$postdata[username]', 
				password='$postdata[password]', password_retype='$postdata[password_retype]', age='$postdata[age]',
				sex='$postdata[sex]', hometown='$postdata[hometown]' 
				WHERE ID=$user_id";
				if ($postdata['password'] == "" || $postdata['password_retype'] == ""  || $postdata['firstn'] == ""   
				|| $postdata['lastn'] == ""   || $postdata['age'] == ""   || $postdata['hometown'] == ""   
				|| $postdata['username'] == "" || $postdata['sex'] == "" ) { 
					$result = "<span style='color:red'>Please fill all of the fields</span>";
					return $result;
					
				}
				if ($postdata['password'] !== $postdata['password_retype']) { 
					$result = "<span style='color:red; font-weight: normal'>passwords do not match, please try again</span>";
					return $result;
				}
				else {
					$result = mysqli_query($connection,$query);
					$success = "<span style='color:#88e188; font-weight: normal'>Successfully updated your information!</span>";
					return $success;
				}
			}
			
			public function follow($user_id, $friend_id) {
				global $connection;
				$table = 'friends';
				$query = "INSERT INTO $table (user_id, friend_id) VALUES ('$user_id', '$friend_id')";
				$result= mysqli_query($connection, $query);
				return $result;
			}
			
			
			
			public function unfollow($user_id, $friend_id) {
				global $connection;
				$table = 'friends';
				$query = "DELETE FROM $table WHERE user_id = '$user_id' AND friend_id = '$friend_id'";
				$result= mysqli_query($connection, $query);
				return $result;
			}
			
			public function send_message($messagedata) {
				global $connection;
				$table = 'messages';
				$message = mysqli_real_escape_string($connection, $messagedata['content']);
				$query = "INSERT INTO $table (time, sender_id, recipient_id, content) 
				VALUES ('$messagedata[message_time]', '$messagedata[sender_id]', '$messagedata[recipient_id]', '$message')";
				if($message == "")
					$result = "<span style='color:red;'>content is required in the textbox.</span>";
				else {
					$send = mysqli_query($connection, $query);
					$result = "<span style='color:#88e188'>your message was sent successfully</span>";
				}
				return $result;
			} 
			
			
			public function notify_message($messagedata) {
				global $connection;
				$table = 'notifications_messages';
				$query = "INSERT INTO $table (recipient_id, sender_id, status) 
				VALUES ('$messagedata[recipient_id]', '$messagedata[sender_id]', '$messagedata[status]')";
				$result = mysqli_query($connection, $query);
				return $result;
			}  
			
			public function notify_follower($data) {
				global $connection;
				$table = 'notifications_followers';
				$query = "INSERT INTO $table (recipient_id, sender_id, status, firstn, lastn) 
				VALUES ('$data[friend_id]', '$data[user_id]', '$data[status]', '$data[firstn]', '$data[lastn]')";
				$result = mysqli_query($connection, $query);
				return $result;
			}
			
			public function add_status($user_id, $statusdata) {
				global $connection;
				$table = 'status';
				$content = mysqli_real_escape_string($connection, $statusdata['status_content']);
				$query = "INSERT INTO $table (user_id, status_time, status_content) 
				VALUES ($user_id, '$statusdata[status_time]', '$content')";
				if($statusdata['status_content'] == "") {
					$error = "<span style='color: red; font-weight: normal'>nothing has been entered!</span>";
					return $error; 
				}
				else
					$result = mysqli_query($connection, $query);
			}
		}
	}	
	$modify = new MODIFY;
?>
