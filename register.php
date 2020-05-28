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
    
    <link rel="stylesheet" href="style.css">
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
		
            <div class="logo">
                    <a href="#">FRIENDS FEEDS</a>
                </div>
            <div class="passicon"> 
                    <img src="images/password.png" class="img wow fadeInUp" alt="">
                    
            </div>
            <div class="usericon"> 
                    <img src="images/user.png" class="img wow fadeInUp" alt="">
                    
            </div>
        <div class="logo">

            <div class="login-box">
            
            <div class="textbox wow fadeInUp" data-wow-delay="0.4s">
              <form action="register.php" method="POST">
                <input type="text"  name="log_email" placeholder="Email" value="<?php 
						if(isset($_SESSION['log_email'])) {
							echo $_SESSION['log_email'];
						} 
						?>" required>
            </div>
           
                
            <div class="textbox wow fadeInUp" data-wow-delay="0.4s">
                    
                    <input type="password" name="log_password" placeholder="Password" >
                </div>
                </div>
            </div>
                
                <div class="btnGroup button animated shake infinite slower ">
                        <div class="btnColor">
						<input type="submit" name="login_button" value="Login"> <br>
						<div class="message">
						<?php if(in_array("E-Mail or Password is Incorrect <br>" ,$error_array)) echo "E-Mail or Password is Incorrect <br>"; ?>
						</div>
						</div>
					
                        <div class="whiteBG">
                    </div>
                    </div>

                    <div class="callToAction">
                    <h1> Don't have an account ? <span><a href="registerpage.php" class="signup"> Sign Up</a></span></h1>
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