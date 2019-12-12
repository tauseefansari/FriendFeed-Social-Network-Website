<?php 
	require 'config/config.php';
	require 'includes/form_handlers/register_handler.php';
	require 'includes/form_handlers/login_handler.php';
    
?>

<html>
<head>
	<title>Welcome to FriendFeed!</title>
	<!-- CSS Files -->
	<link rel="stylesheet" type="text/css" href="assets/css/register_style.css">
	<script src="assets/js/bootstrap.js"></script>
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
    <!-- JavaSript Files -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="assets/js/register.js"></script>
</head>
<body>
	<?php 
		if(isset($_POST['register_button']))
		{
			echo '
				<script>
					$(document).ready(function() {
						$("#first").hide();
						$("#second").show();
					});
				</script>
			';
		}
	?>

	<div class="container-lg-fluid">
		<div class="wrapper">
			<div class="login_box">
					<div class="login_header">
						<h1>FriendFeed!</h1>
						Login or Sign Up below!
					</div>

				<div id="first">
					<form action="Register.php" method="POST">
						<input type="email" name="log_email" placeholder=" E-Mail Address" value="<?php 
						if(isset($_SESSION['log_email'])) {
							echo $_SESSION['log_email'];
						} 
						?>" required> <br>
						<input type="password" name="log_password" placeholder=" Password"> <br>
						<input type="submit" name="login_button" value="Login"> <br>

						<?php if(in_array("E-Mail or Password is Incorrect <br>" ,$error_array)) echo "E-Mail or Password is Incorrect <br>"; ?>

						<a href="#" id="signup" class="signup">Need an Account? Register Here!</a>
					</form>
				</div>
				
				<div id="second">
					<form action="Register.php" method="POST">
						<input type="text" name="reg_fname" placeholder=" First Name" value="<?php 
						if(isset($_SESSION['reg_fname'])) {
							echo $_SESSION['reg_fname'];
						} 
						?>" required> <br>
						<?php if(in_array("First Name Should be in between 2 to 25 Characters <br>", $error_array)) echo "First Name Should be in between 2 to 25 Characters <br>"; ?>
						
						<input type="text" name="reg_lname" placeholder=" Last Name" value="<?php 
						if(isset($_SESSION['reg_lname'])) {
							echo $_SESSION['reg_lname'];
						} 
						?>" required> <br>
						<?php if(in_array("Last Name Should be in between 2 to 25 Characters <br>", $error_array)) echo "Last Name Should be in between 2 to 25 Characters <br>"; ?>

						<input type="email" name="reg_email" placeholder=" E-Mail" value="<?php 
						if(isset($_SESSION['reg_email'])) {
							echo $_SESSION['reg_email'];
						} 
						?>" required> <br>

						<input type="email" name="reg_email2" placeholder=" Confirm E-Mail" value="<?php 
						if(isset($_SESSION['reg_email2'])) {
							echo $_SESSION['reg_email2'];
						} 
						?>" required> <br>
						<?php if(in_array("E-Mail already in Use <br>", $error_array)) echo "E-Mail already in Use <br>";
						elseif(in_array("Invalid E-Mail Format <br>", $error_array)) echo "Invalid E-Mail Format <br>";
						elseif(in_array("E-Mail Do Not Match <br>", $error_array)) echo "E-Mail Do Not Match <br>"; ?>

						<input type="password" name="reg_password" placeholder=" Password" required> <br>
						<input type="password" name="reg_password2" placeholder=" Confirm Password" required> <br>
						<?php if(in_array("Both Password do not match <br>", $error_array)) echo "Both Password do not match <br>";
						elseif(in_array("Your Password only contain English letters or Numbers <br>", $error_array)) echo "Your Password only contain English letters or Numbers <br>";
						elseif(in_array("Your Password must be in between 8 to 30 Characters <br>", $error_array)) echo "Your Password must be in between 8 to 30 Characters <br>"; ?>
						
						<input type="submit" name="register_button" value="Register"> <br>
						<?php if(in_array("<span style='color:#14C800;'>You're all set! Go ahead and Login!</span><br>", $error_array)) echo "<span style='color:#14C800;'>You're all set! Go ahead and Login!</span><br>"; ?>

						<a href="#" id="signin" class="signin">Already heve an Account? Sign In Here!</a>
					</form>
				</div>
				
			</div>
		</div>
	</div>
</body>
</html>