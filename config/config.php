<?php 
	ob_start(); //Turn ON Output Buffering
	session_start(); //Start of Session
	$timezone=date_default_timezone_set("Europe/London");
    $con = mysqli_connect("localhost","root","","socnetgui");
    if(mysqli_connect_errno())
    {
        echo "Failed to Connect ".mysqli_connect_errno();
    }
?>