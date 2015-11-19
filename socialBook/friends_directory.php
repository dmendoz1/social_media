<?php
	session_start();
	require_once('includes/display.php');
	$logged_user_id = $_SESSION["id"];
	$firstname = $_SESSION["firstname"];
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Members</title>
		
		<link href="css/bootstrap.css" rel="stylesheet">
		<link href="css/landing-page.css" rel="stylesheet">
		<link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

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
					<li class="active"><a href="friends_directory.php"><i class="fa fa-users icon-size"></i></a></i>
					<li><a href="messages.php" id="messages-link"><i class="fa fa-comments icon-size"></i><span class="badge" id="badge">2</span></a></i>
					<li><a href="logout.php">logout</a></li>
				  </ul>
				</div><!--/.nav-collapse -->
				<div id="members-search-list"></div>
			  </div>
		  
			</div>
		</header>
		<div id="follow_notification_wrapper"></div>
		<div class="container marginTop">
			<div class="row">
				<div class="col-md-12" id="member-dir">
					<div id="members-wrapper">
						<h1>Members Directory</h1>
							<?php $display->all_members($logged_user_id); ?> 
					</div>
				</div>
			</div>
		</div>
		
		
		
		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    	<script src="javascript.js"></script>
	</body>
</html>