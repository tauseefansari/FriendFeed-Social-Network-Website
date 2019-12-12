<?php 

	//Project Verion 7
	
	//************************** User Details Validation OR Updation **************************

	if(isset($_POST['update_details']))
	{
		$first_name=$_POST['first_name'];
		$last_name=$_POST['last_name'];
		$email=$_POST['email'];

		$email_check=mysqli_query($con,"SELECT * FROM users WHERE email='$email'");
		$row=mysqli_fetch_array($email_check);
		$matched_user=$row['username'];

		if($matched_user == "" || $matched_user == $userLoggedIn)
		{
			$message="Details Updated! <br><br>";
			$query=mysqli_query($con,"UPDATE users SET first_name='$first_name', last_name='$last_name', email='$email' WHERE username='$userLoggedIn'");
		}
		else
		{
			$message="This email is already in use! <br><br>";
		}
	}
	else
		$message="";



	//************************** Password Validation OR Updation **************************

	if(isset($_POST['update_password']))
	{
		$old_password=strip_tags($_POST['old_password']);
		$new_password_1=strip_tags($_POST['new_password_1']);
		$new_password_2=strip_tags($_POST['new_password_2']);

		$password_query=mysqli_query($con,"SELECT password FROM users WHERE username='$userLoggedIn'");
		$row=mysqli_fetch_array($password_query);
		$db_password=$row['password'];

		if(md5($old_password) == $db_password)
		{
			if($new_password_1 == $new_password_2)
			{
				if(strlen($new_password_1<=4))
				{
					$password_message="Sorry, Your password must be greater than 4 characters <br><br>";
				}
				else
				{
					$new_password_md5=md5($new_password_1);
					$password_query=mysqli_query($con,"UPDATE users SET password='$new_password_md5' WHERE username='$userLoggedIn'");
					$password_message="Password has been changed! <br><br>";
				}
			}
			else{
				$password_message="Both the new passwords do not match! <br><br>";
			}
		}
		else
			$password_message="Old password is incorrect! <br><br>";
	}
	else
		$password_message="";

	if(isset($_POST['close_account']))
		header("Location: close_account.php");
?>