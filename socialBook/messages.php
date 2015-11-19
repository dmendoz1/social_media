<?php
	session_start();
	require_once('includes/display.php');
	require_once('includes/modify.php');
	include('change_status.php');
	$logged_user_id = $_SESSION["id"];
	$firstname = $_SESSION["firstname"];
	date_default_timezone_set("America/Los_Angeles");

	
	if (!empty ($_POST)) {
		$send_message = $modify->send_message($_POST);
		$notification_message = $modify->notify_message($_POST);
	}
	$friend_ids = $display->get_following_friends($logged_user_id);
	
	foreach ( $friend_ids as $friend_id ) {
		$friend_objects[] = $display->load_user($friend_id);
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Messages</title>
		
		<link href="css/bootstrap.css" rel="stylesheet">
		<link href="css/landing-page.css" rel="stylesheet">
		<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>

	<body>
		<!-- Navigation -->
    <header class="header-main">
		<div class="navbar navbar-inverse navbar-fixed-top" role="navigation" id="mainnav">
		  <div class="container">
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			  </button>
			</div>
			<div class="collapse navbar-collapse">
				<form class="navbar-form navbar-left" role="search">
					<div class="form-group">
				       <input type="text" id="search-bar" placeholder="Search SocialBook Members">
				    </div>
				    <button type="submit" id="search-button" class="search-btn"><i class="fa fa-search search-icon"></i></button>
			    </form>
			  <ul class="nav navbar-nav pull-right">
				<li><a href="home.php"><i class="fa fa-home icon-size"></i></a></li>
				<li><a href="profile_view.php"><?php echo "$firstname";?></a></li>
				<li><a href="friends_directory.php"><i class="fa fa-users icon-size"></i></a></i>
				<li class="active"><a href="messages.php" id="messages-link"><i class="fa fa-comments icon-size"></i><span class="badge" id="badge">2</span></a></i>
                <li><a href="logout.php">logout</a></li>
			  </ul>
			</div><!--/.nav-collapse -->
			<div id="members-search-list"></div>
		  </div>
		  
		</div>
	</header>
	<div id="follow_notification_wrapper" class="mesages-follow-notification"></div>
		<div class="container marginTopAlways">
			<div id="message-create">
					<h3>Create a New Message!</h3>
					<p> You can only message those you are following </p>
					<form method="post">
						<input name="message_time" type="hidden" value="<?php echo date('F j, Y, g:i a'); ?>" />
						<input name="sender_id" type="hidden" value="<?php echo "$logged_user_id"; ?>" />
						<input name="status" type="hidden" value="1" />
						<p>
							<label for="recipient_id">To:</label>
							<select name="recipient_id" class="option" required>
								<option value="">-----Pick a Person-----</option>
								<?php foreach ($friend_objects as $friend) { ?>
									<option class="option" value="<?php echo $friend->ID; ?>"><?php echo "$friend->firstn $friend->lastn"; ?></option>
								<?php } ?>
							</select>
						</p>
						<p>
							<label for="message_content">Message:</label>
							<textarea name="content"></textarea>
						</p>
						<p>
							<button type="submit" class="button" />send </button>
						</p>
					</form>
					
					<div id="message-status"> 
						<?php echo $send_message; ?>
					</div>
			</div>
			<div id="message-inbox">
				<?php $display->do_inbox($logged_user_id); ?>
				
			</div>
		</div>
		
    	<script src="js/jquery.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="javascript.js"></script>
	</body>
</html>