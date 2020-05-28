<?php 
	include('includes/header.php'); //Header
	//include('includes/classes/User.php');
	//include('includes/classes/Post.php');

	if(isset($_POST['post']))
	{	

		//Project Version 8

		$uploadOk=1;
		$imageName=$_FILES['fileToUpload']['name'];
		$errorMessage="";

		if($imageName != "") 
		{
			$targetDir = "assets/images/posts/";
			$imageName = $targetDir . uniqid() . basename($imageName);
			$imageFileType = pathinfo($imageName, PATHINFO_EXTENSION);

			if($_FILES['fileToUpload']['size'] > 10000000) 
			{
				$errorMessage = "Sorry, your file is too large";
				$uploadOk = 0;
			}

			if(strtolower($imageFileType) != "jpeg" && strtolower($imageFileType) != "png" && strtolower($imageFileType) != "jpg")
			{
				$errorMessage = "Sorry, only jpeg, jpg and png files are allowed";
				$uploadOk = 0;
			}

			if($uploadOk) 
			{
				if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $imageName)) 
				{
					//image uploaded okay
				}
				else 
				{
					//image did not upload
					$uploadOk = 0;
				}
			}

		}

		if($uploadOk) 
		{
			$post = new Post($con, $userLoggedIn);
			$post->submitPost($_POST['post_text'], 'none', $imageName);
		}
		else 
		{
			echo "<div style='text-align:center;' class='alert alert-danger'>
				$errorMessage
			     </div>";
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="indestyle.css">
	<!-- for on scroll animations -->
      <link rel="stylesheet" href="animate.css">
      <script src="wow.min.js"></script>
	
   
  <title>Responsive Navigation bar with Icons</title>
</head>
<body>
	<div class="container_side wow fadeInUp" data-wow-delay="1.2s">
	<div class="user_details_column">
		<div class="circle">
		<a href="<?php echo $userLoggedIn; ?>" class="user_details">
		<img src="<?php echo $user['profile_pic']; ?>"></a> <!--Name to be display-->
		</div>
		<div class="namedetails">
		<a href="<?php echo $userLoggedIn; ?>">
		<?php echo $user['first_name']." ".$user['last_name']; ?>
		</a>
		</div>
		<hr>
		
		
		<div class="user_details_left_right">
		<div class="post">
		<?php echo "Posts: ".$user['num_post']. "&nbsp;"."&nbsp;"."&nbsp;"; 
			  echo "Likes: ".$user['num_likes']; ?>
		</div>	
		<div class="search">
				<form action="search.php" method="GET" name="search_form">
					<input type="search" onkeyup="getLiveSearchUsers(this.value,'<?php echo $userLoggedIn; ?>')" name="q" placeholder=" Search..." autocomplete="off" id="search_text_input">

					<div class="button_holder">
						<i class="fa fa-search" aria-hidden="true"></i>
					</div>
				</form>
				
				<div class="search_results">
				</div>

				<div class="search_results_footer_empty">
				</div>
		</div>
		
		
		</div>
		<hr class="new">
	</div>
</div>
	<div class="main_column column wow fadeInUp" data-wow-delay="1.6s">
		<form class="post_form" action="index.php" method="POST" enctype="multipart/form-data">
		 <br><br>
			<textarea name="post_text" id="post_text" placeholder="Write something here..."></textarea>	
			<div class="container2">
			
			<input type="submit" name="post" id="post_button" value="Post">
			<div class="button1">
			<input type="file" name="fileToUpload" id="fileToUpload"></div>
			</div>
			</form>
			
		

		<div class="posts_area"></div>
		<img id="loading" src="assets/images/icons/loading.gif" width="50" height="50">

	</div> 
	<!-- Project Version 8 (Display Trending Words) -->

	
</body>

 <script type="text/javascript">

      //Scroll reveal animations

      new WOW().init();

      //Scroll activated background change
      $(function() {
            $(document).scroll(function() {
                  var $nav = $(".nav");
                  $nav.toggleClass('scrolled', $(this).scrollTop() > $nav.height());
            });
      });
	  </script>
	<script>
		var userLoggedIn='<?php echo $userLoggedIn; ?>';
		$(document).ready(function ()
		{
			$('#loading').show();
			//AJAX (Asynchronous JavaScript and XML) Request for loading first post
			$.ajax({
				url: "includes/handlers/ajax_load_posts.php",
				type: "POST",
				data: "page=1&userLoggedIn=" + userLoggedIn,
				cache: false,

				success: function(data)
				{
					$('#loading').hide();
					$('.posts_area').html(data);

				} 
			});

			$(window).scroll(function()
			{
				var height=$('.posts_area').height(); //Div Containing Post
				var scroll_top=$(this).scrollTop();
				var page=$('.posts_area').find('.nextPage').val();
				var noMorePosts=$('.posts_area').find('.noMorePosts').val();

				if((document.body.scrollHeight == document.body.scrollTop + window.innerHeight) && noMorePosts == 'false')
				{
					$('#loading').show();
					var ajaxReq = $.ajax({
					url: "includes/handlers/ajax_load_posts.php",
					type: "POST",
					data: "page=" + page + "&userLoggedIn=" + userLoggedIn,
					cache: false,

					success: function(response)
					{
						$('.posts_area').find('.nextPage').remove(); //Removes current .nextPage
						$('.posts_area').find('.noMorePosts').remove(); //Removes current .nextPage
						$('#loading').hide();
						$('.posts_area').append(response);
					} 
					});
				}
				return false;
			});
		});
	</script>
</html>