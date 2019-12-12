<?php
    $fname=""; //First name
    $lname=""; //Last name
    $em=""; //E-Mail
    $em2=""; //Confirm E-Mail
    $password=""; //Password
    $password2=""; //Confirm Password
    $date=""; //Sign Up Date
    $error_array=array(); //Holds Error Messages

    if(isset($_POST['register_button']))
    {
    	//Registration Form values Store in variables

    	//First Name
    	$fname=strip_tags($_POST['reg_fname']); //Remove HTML tags
    	$fname=str_replace(' ', '', $fname); //Remove Spaces
    	$fname=ucfirst(strtolower($fname)); //First Letter Upper Case
    	$_SESSION['reg_fname']=$fname; //Store First name in Session variable

    	//Last Name
    	$lname=strip_tags($_POST['reg_lname']); //Remove HTML tags
    	$lname=str_replace(' ', '', $lname); //Remove Spaces
    	$lname=ucfirst(strtolower($lname)); //First Letter Upper Case
    	$_SESSION['reg_lname']=$lname; //Store Last name in Session variable

    	//E-Mail
    	$em=strip_tags($_POST['reg_email']); //Remove HTML tags
    	$em=str_replace(' ', '', $em); //Remove Spaces
    	$em=ucfirst(strtolower($em)); //First Letter Upper Case
    	$_SESSION['reg_email']=$em; //Store E-Mail in Session variable

    	// Confirm E-Mail
    	$em2=strip_tags($_POST['reg_email2']); //Remove HTML tags
    	$em2=str_replace(' ', '', $em2); //Remove Spaces
    	$em2=ucfirst(strtolower($em2)); //First Letter Upper Case
    	$_SESSION['reg_email2']=$em2; //Store Confirm E-Mail in Session variable

    	//Password
    	$password=strip_tags($_POST['reg_password']); //Remove HTML tags
  		
  		//Confirm Password
    	$password2=strip_tags($_POST['reg_password2']); //Remove HTML tags

    	//Date
    	$date=date("Y-m-d"); //Current Date

    	if($em == $em2)
    	{
    		//If Both E-Mails are same
    		if(filter_var($em,FILTER_VALIDATE_EMAIL))
    		{
    			$em=filter_var($em,FILTER_VALIDATE_EMAIL);

    			//Check if E-Mail is already exists
    			$e_check=mysqli_query($con,"SELECT email FROM users WHERE email='$em'");

    			//Count the Number of records
    			$num_rows=mysqli_num_rows($e_check);

    			if($num_rows > 0)
    			{
    				array_push($error_array, "E-Mail already in Use <br>");
    			}
    		}
    		else
    		{
    			array_push($error_array, "Invalid E-Mail Format <br>");
    		}
    	}
    	else 
    	{
    		array_push($error_array, "E-Mail Do Not Match <br>");
    	}
		if(strlen($fname) > 25 || strlen($fname) < 2)
    	{
    		array_push($error_array, "First Name Should be in between 2 to 25 Characters <br>");
    	}
    	if(strlen($lname) > 25 || strlen($lname) < 2)
    	{
    		array_push($error_array, "Last Name Should be in between 2 to 25 Characters <br>");
    	}
    	if($password != $password2)
    	{
    		array_push($error_array, "Both Passwords do not match <br>");
    	}
    	else
    	{
    		if(preg_match('/[^A-Za-z0-9]/', $password))
    		{
    			array_push($error_array, "Your Password only contain English letters or Numbers <br>");
    		}
    	}
    	if(strlen($password) > 30 || strlen($password) < 8)
    	{
    		array_push($error_array, "Your Password must be in between 8 to 30 Characters <br>");
    	}

    	if(empty($error_array)) 
    	{
    		$password=md5($password); //Use MD5 Encryption to encrypt the password

    		//Auto Generating Username by concatenating First and Last Name
    		$username=strtolower($fname."_".$lname);
    		$check_username_query=mysqli_query($con,"SELECT username FROM users WHERE username='$username'");
    		$i=0; //Counter to Add Numbers in Username
    		while(mysqli_num_rows($check_username_query) != 0) 
    		{
    			$i++;
    			$username=$username."_".$i;
    			$check_username_query=mysqli_query($con,"SELECT username FROM users WHERE username='$username'");
    		}

    		//Profile Picture
    		$rand=rand(1,6); //Random Number between 1 to 6
    		if($rand==1)
    			$profile_pic="assets/images/profile_pics/defaults/head_deep_blue.png";
    		elseif($rand==2)
    			$profile_pic="assets/images/profile_pics/defaults/head_emerald.png";
    		elseif($rand==3)
    			$profile_pic="assets/images/profile_pics/defaults/head_carrot.png";
    		elseif($rand==4)
    			$profile_pic="assets/images/profile_pics/defaults/head_belize_hole.png";
    		elseif($rand==5)
    			$profile_pic="assets/images/profile_pics/defaults/head_amethyst.png";
    		elseif($rand==6)
    			$profile_pic="assets/images/profile_pics/defaults/head_alizarin.png";

    		//Inserting Values in database
    		$query=mysqli_query($con,"INSERT INTO users VALUES('','$fname','$lname','$username','$em','$password','$date','$profile_pic','0','0','no',',')");
    		array_push($error_array, "<span style='color:#14C800;'>You're all set! Go ahead and Login!</span><br>");

    		//Clear Session variables
    		$_SESSION['reg_fname']="";
    		$_SESSION['reg_lname']="";
    		$_SESSION['reg_email']="";
    		$_SESSION['reg_email2']="";

    	}
    
	}
?>