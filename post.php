<?php  
	include("includes/header.php");

	if(isset($_GET['id']))
	{
		$id=$_GET['id'];
	}
	else
		$id=0;
?>
<!-- for on scroll animations -->
      <link rel="stylesheet" href="animate.css">
      <script src="wow.min.js"></script>
<div class="container_side animated bounceInDown">
<div class="user_details_column" >
	<div class="circle">
	<a href="<?php echo $userLoggedIn; ?>" class="user_details">
	<img src="<?php echo $user['profile_pic']; ?>"></a>
	</div>
	<div class="namedetails">

	<a href="<?php echo $userLoggedIn; ?>">
	<?php echo $user['first_name']." ".$user['last_name']; ?>
	</a>
	

	</div>
	<hr>
	
	<div class="post">
	<?php echo "Posts: ".$user['num_post']."&nbsp;"."&nbsp;"."&nbsp;"; 
		  echo "Likes: ".$user['num_likes']; ?>
	</div>
	</div>
</div>
</div>
<div class="main_column column animated bounceInUp" id="noti_column">
	<div class="posts_area">
		<?php
			$post=new Post($con,$userLoggedIn);
			$post->getSinglePost($id);  
		?>
	</div>
</div>