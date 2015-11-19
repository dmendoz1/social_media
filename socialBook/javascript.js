$(document).ready( function() {
	$("#login-button").click( function() {
		if($("#username").val() == "" || $("#password").val() == "") 
		{
			$("#incorrectPass").html("Please enter both username and password");
			$("#incorrectPass").css("visibility", "visible");
		}
		else
			$.post("login.php", 
				   $("#loginForm :input").serializeArray(),
					function(data) 
					{
						if(data == "Invalid username or password.  Please try again") 
						{
							$("#incorrectPass").html(data);
							$("#incorrectPass").css("visibility", "visible");
						}
						else
							window.location.replace("home.php");			
					});
			$("#loginForm").submit( function() {
				return false;
			});
	});
	
	
	/************** MOBILE LOGIN ***************/
	$("#login-button-two").click( function() {
		if($("#usernameMobile").val() == "" || $("#passwordMobile").val() == "") 
		{
			$("#incorrectPassMobile").html("Please enter both username and password");
			$("#incorrectPassMobile").css("visibility", "visible");
		}
		else
			$.post($("#loginFormMobileTwo").attr("action"), 
				   $("#loginFormMobileTwo :input").serializeArray(),
					function(data) 
					{
						if(data == "Invalid username or password.  Please try again") 
						{
							$("#incorrectPassMobile").html(data);
							$("#incorrectPassMobile").css("visibility", "visible");
						}
						else
							window.location.replace("home.php");			
					});
			$("#loginFormMobileTwo").submit( function() {
				return false;
			});
	});
	
	
	
	$("#registerButton").click( function() {
		if($("#usernameNew").val() == "" || $("#passwordNew").val() == "" || $("#passwordAgain").val() == "" || $("#firstName").val() == "" 
		|| $("#lastName").val() == "" || $("#age").val() == ""  || $("#hometown").val() == "" || $('input[name=sex]:checked').length == 0 ) {
			$("#registerError").html("All fields are required");
			$("#registerError").css("visibility", "visible");
		}
		else 
			$.post($("#registerForm").attr("action"), 
				   $("#registerForm :input").serializeArray(),
					function(result) 
					{
						if(result == "That username has already been taken.  Please try a different one." || result == "Passwords did not match.  Please try again") 
						{
							$("#registerError").html(result);
							$("#registerError").css("visibility", "visible");
						}
						
						else if(result == "success")
							window.location.replace("home.php");			
					}
				);
			$("#registerForm").submit( function() {
				return false;
			});
	
	});

	
	
	
	/**** SEARCH BAR **********/
	
	$('#search-bar').keyup(function() {
		results = $(this).val();
		$.post("searchbar.php",{partialState:results}, function(data) {
			$("#members-search-list").html(data);
			$("#members-search-list").css("visibility","visible");
		}); 
	});
	
	$('#search-bar').click(function() {
		$.post("searchbar.php", function(data) {
			$("#members-search-list").html(data);
			$("#members-search-list").css("visibility","visible");
		}); 
	});
	
	$('body').click(function(evt){    
       if(evt.target.id == "members-search-list")
          return;
       //For descendants of menu_content being clicked, remove this check if you do not want to put constraint on descendants.
       if($(evt.target).closest('#members-search-list').length)
          return; 
        else 
			$('#members-search-list').css("visibility", "hidden");
		});  
		
		
		/**** AUTO REFRESHING MESSAGES *******/
		function autoRefresh_msg() {
			$("#message-inbox").load("msgfeed.php");// a function which will load data from other file after x seconds
		}
		setInterval(autoRefresh_msg, 3000); // refresh feed after 3 secs
		
		
		/**** AUTO REFRESHING FEED *******/
		function autoRefresh_feed() {
			$("#feed").load("feed.php");// a function which will load data from other file after x seconds
		}
		setInterval(autoRefresh_feed, 5000); // refresh feed after 5 secs
		
		
		/****** MESSAGES NOTIFICATION *******/
		function message_notif() {
                $.ajax({
                    url: 'new_messages.php' ,
                    cache: false,
                    success: function(data)
                    {
                    	if(data == '1') {
                        	$('#message_notification').html("you have " + data + " new message");
                        	$('#badge').html(data);
                        	$('#badge').css('visibility', 'visible');
                        }
                        else if(data == '0')
                        	return false;
                        else
                        	$('#message_notification').html("you have " + data + " new messages");
                        	$('#badge').html(data);
                        	$('#badge').css('visibility', 'visible');
                    },                                          
                });
                
        }
		setInterval(message_notif,1000);
		
		
		/********* NEW FOLLOWER NOTIFICATION **********/
		
		function follower_notif() {
                $.ajax({
                    url: 'new_followers.php' ,
                    cache: false,
                    success: function(data)
                    {
                        $('#follow_notification_wrapper').html(data);
                    },                                          
                });
                
        }
		setInterval(follower_notif,2000);			
});

function notifDisappear(x) {
	var id = x.id;
	$('#'+id).fadeOut();
	$.ajax({
		type: 'POST',
		url: 'change_status_notification.php',
		data: 'delete_id='+id,
		success: function() {
			$('#'+id).fadeOut();
		}
	});
}

