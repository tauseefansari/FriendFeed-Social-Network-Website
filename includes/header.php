<?php 
    require 'config/config.php';
    include('includes/classes/User.php');
    include('includes/classes/Post.php');
    include('includes/classes/Message.php');
    include("includes/classes/Notification.php");
   	
   	if(isset($_SESSION['username']))
    {
    	$userLoggedIn=$_SESSION['username'];
    	$user_details_query=mysqli_query($con,"SELECT * FROM users WHERE username='$userLoggedIn'");
    	$user=mysqli_fetch_array($user_details_query);
    }
    else
    {
    	header("Location: register.php");
    }
?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Welcome to FriendFeed!!</title>
  <!-- css files -->

  <link rel="stylesheet" href="includes/headstyle.css">
  <link rel="stylesheet" type="text/css" href="indestyle.css"> <!-- extra for notification css files -->
 
  <link rel="stylesheet" href="assets/css/jquery.Jcrop.css" type="text/css" />
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
   <!-- for on scroll animations -->
  <link rel="stylesheet" href="include/animate.css">
      <script src="wow.min.js"></script>
  <!-- javascript files -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
	<script src="assets/js/bootstrap.js"></script>
	
	

	<script src="assets/js/bootbox.min.js"></script>
	
	<script src="assets/js/project.js"></script>
	<script src="assets/js/jquery.jcrop.js"></script>
	<script src="assets/js/jcrop_bits.js"></script>
  
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
  
  <title>Responsive Navigation bar with Icons</title>
</head>
<body>

	<div class="containerhead wow fadeInUp" data-wow-delay="0.4s">
		<div class="box">
		<div class="logo">
			
			<a href="index.php">FriendFeed</a>
			
		</div>
		</div>
		
	</div>	

  <div class="menuToggle">Menu</div>
  <?php  
					//Unread Messages
					$messages = new Message($con,$userLoggedIn);
					$num_messages=$messages->getUnreadNumber(); 

					//Unread notifications 
					$notifications = new Notification($con, $userLoggedIn);
					$num_notifications = $notifications->getUnreadNumber();

					//Friend Request notifications 
					$user_obj = new User($con, $userLoggedIn);
					$num_requests = $user_obj->getNumberOfFriendRequest();
				?>
  <ul class="navigation wow fadeInUp" data-wow-delay="0.9s">
    <li>
      <a href="index.php">
        <div class="icon">
          <i class="fas fa-home"></i>
		  
          <i class="fas fa-home"></i>
		  
        </div>
        <div class="name"><span data-text="Home">Home</span></div>
      </a>
    </li>
    <li>
      <a href="#">
	 <a href="javascript:void(0);" onclick="getDropdownData('<?php echo $userLoggedIn; ?>', 'notification')">
        <div class="icon">
		
          <i class="fas fa-bell"></i>
		  <i class="fas fa-bell"></i>
		  <?php
				if($num_notifications > 0)
				echo '<span class="notification_badge" id="unread_notification">' . $num_notifications . '</span>';
			?>
        </div>
        <div class="name"><span data-text="Notification">Notification</span></div>
      </a>
    </li>
      <li>
      <a href="#">
	  <a href="javascript:void(0);" onclick="getDropdownData('<?php echo $userLoggedIn; ?>','message')">
        <div class="icon">
          <i class="fas fa-envelope"></i>
		  <i class="fas fa-envelope"></i>
		  <?php 
						if($num_messages > 0)
							echo '<span class="notification_badge" id="unread_message">'.$num_messages.'</span>';
					?>
        </div>
        <div class="name"><span data-text="Message">Message</span></div>
      </a>
    </li>
    <li>
      <a href="<?php echo $userLoggedIn; ?>">
        <div class="icon">
          <i class="fas fa-user-circle"></i>
		  <i class="fas fa-user-circle"></i>
        </div>
        <div class="name"><span data-text="User">
		
					<?php echo $user['first_name']; ?>
				</span></div>
      </a>
    </li>
	 <li>
      <a href="request.php">
        <div class="icon">
         <i class="fas fa-users"></i>
          <i class="fas fa-users"></i>
		  <?php 
						if($num_requests > 0)
							echo '<span class="notification_badge" id="unread_requests">'.$num_requests.'</span>';
					?>
        </div>
        <div class="name"><span data-text="Friends">Friends</span></div>
      </a>
    </li>
	 <li>
      <a href="settings.php">
        <div class="icon">
           <i class="fas fa-cogs"></i>
          <i class="fas fa-cogs"></i>
        </div>
        <div class="name"><span data-text="Setting">Setting</span></div>
      </a>
    </li>
    <li>
      <a href="includes/handlers/logout.php">
        <div class="icon">
         <i class="fas fa-sign-out-alt"></i>
		 <i class="fas fa-sign-out-alt"></i>
        </div>
        <div class="name"><span data-text="LogOut">LogOut</span></div>
      </a>
    </li>
  </ul>
  <div class="dropdown_data_window" style="height:0px; border:none;"></div>
		<input type="hidden" id="dropdown_data_type" value="">
  
 </div>

<script type="text/javascript">

    $(document).ready(function(){
		
      $('.menuToggle').click(function(){
		  
        $('ul').toggleClass('active')
		
      })
    })
  </script> 
	<script>
		var userLoggedIn = '<?php echo $userLoggedIn; ?>';

		$(document).ready(function() 
		{

			$('.dropdown_data_window').scroll(function() 
			{
				var inner_height = $('.dropdown_data_window').innerHeight(); //Div containing data
				var scroll_top = $('.dropdown_data_window').scrollTop();
				var page = $('.dropdown_data_window').find('.nextPageDropdownData').val();
				var noMoreData = $('.dropdown_data_window').find('.noMoreDropdownData').val();

				if ((scroll_top + inner_height >= $('.dropdown_data_window')[0].scrollHeight) && noMoreData == 'false') 
				{

					var pageName; //Holds name of page to send ajax request to
					var type = $('#dropdown_data_type').val();

					if(type == 'notification')
						pageName = "ajax_load_notifications.php";
					else if(type = 'message')
						pageName = "ajax_load_messages.php"

					var ajaxReq = $.ajax({
						url: "includes/handlers/" + pageName,
						type: "POST",
						data: "page=" + page + "&userLoggedIn=" + userLoggedIn,
						cache:false,

						success: function(response) {
							$('.dropdown_data_window').find('.nextPageDropdownData').remove(); //Removes current .nextpage 
							$('.dropdown_data_window').find('.noMoreDropdownData').remove(); //Removes current .nextpage 
							$('.dropdown_data_window').append(response);
						}
					});

				} //End if 

				return false;

			}); //End (window).scroll(function())

		});

	</script>


