<?php 
	require 'config/config.php';
	require 'includes/form_handlers/register_handler.php';
	require 'includes/form_handlers/login_handler.php';
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <link rel="stylesheet" href="registerstyle.css">
    <link rel="stylesheet" href="animate.css">
	 <!-- JavaSript Files -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="assets/js/register.js"></script>
	<!-- for on scroll animations -->
      <link rel="stylesheet" href="animate.css">
      <script src="wow.min.js"></script>
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
    <header>
	 <!------------Registration page*--->
				  <div class="logo">
					<a href="#">Create new account</a>
            <div class="login-box">
				
					<form action="registerpage.php" method="POST">
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
				
				</div>
				</div>
				 <div class="btnGroup button animated shake infinite slower ">
                    <div class="btnColor">
						<input type="submit" name="register_button" value="Register"> <br>
						<?php if(in_array("<span style='color:#14C800;'>You're all set! Go ahead and Login!</span><br>", $error_array)) echo "<span style='color:#14C800;'>You're all set! Go ahead and Login!</span><br>"; ?>
				</div>
					</div>
					<div class="callToAction">
						<h1><a href="register.php" id="signin" class="signin">Already have an Account? <span>  Sign In Here!</span></h1></a>
					</div>
					</div>	
					</form>

                   
            
    
        
        
    </header>
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
    </body>
    </html>