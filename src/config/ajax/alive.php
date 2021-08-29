<?php
	require "../dbconnect.php";
	session_start();
	if(isset($_SESSION['user_uid']))
	{
		$user_uid = $_SESSION['user_uid'];
		$update_query = "UPDATE `users` SET `logout_time`=NOW()+100  WHERE `id` = '$user_uid'";
		//query to update the logout time field of the current users
		if ($res = mysqli_query($dbcon,$update_query)) {
		}
		else
		{
			mysqli_error($dbcon);
		}
	}
	

?>