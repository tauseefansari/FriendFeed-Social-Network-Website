<?php 
	//Project Version 7 
	include("includes/header.php");
	include("includes/form_handlers/settings_handler.php");
?>
<link rel="stylesheet" href="setting.css">
<!-- for on scroll animations -->
      <link rel="stylesheet" href="animate.css">
      <script src="wow.min.js"></script>
<div class="main_column column animated shake" id="noti_column">
<div class="container_acc ">
	<h4>Account Settings 📃</h4>
	<?php  
		echo "<img src='".$user['profile_pic']."' id='small_profile_pic'>";
	?>
	<br>
	<div class="newpro">
	<a href="upload.php">Upload new profile picture</a><br><br><br><br>
	</div>
	<h5 align="center">Modify the values and click 'Update Details'</h5> 

	<?php  
		$user_data_query=mysqli_query($con,"SELECT first_name,last_name,email FROM users WHERE username='$userLoggedIn'");
		$row=mysqli_fetch_array($user_data_query);

		$first_name=$row['first_name'];
		$last_name=$row['last_name'];
		$email=$row['email'];
	?>
	
	<form action="settings.php" method="POST">
		First Name : <input type="text" name="first_name" value="<?php echo $first_name; ?>" id="settings_input"> <br>
		Last Name : <input type="text" name="last_name" value="<?php echo $last_name; ?>" id="settings_input"> <br>
		E-Mail : <input type="email" name="email" value="<?php echo lcfirst($email); ?>" id="settings_input"> <br>

		<?php echo $message; ?>

		<input type="submit" name="update_details" id="save_details" value="Update Details" class="info settings_submit">
	</form>
</div>
<div class="container_pass ">
	<h4>Change Password 🤫</h4>
	<form action="settings.php" method="POST">
		Old Password : <input type="password" name="old_password" id="settings_input"> <br>
		New Password : <input type="password" name="new_password_1" id="settings_input"> <br>
		Confirm New Password : <input type="password" name="new_password_2" id="settings_input"> <br>

		<?php echo $password_message; ?>

		<input type="submit" name="update_password" id="close_account" value="Update Password" class="info settings_submit">
	</form>
</div>
<div class="container_close">
	<h4>Close Account ☹️</h4>
	<form action="settings.php" method="POST">
		<input type="submit" name="close_account" id="close_account" value="Close Account" class="danger settings_submit">
	</form>
</div>
</div>
