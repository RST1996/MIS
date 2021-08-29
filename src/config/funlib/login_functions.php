<?php
	function isLogin()
	{
		//require "config/dbconnect.php";
		global $dbcon;
		if (isset($_SESSION['user_uid']) && isset($_SESSION['user_ref_id']))
		{
			$user_uid = $_SESSION['user_uid'];
			$query = "SELECT `user_type` FROM `users` WHERE `id` = '$user_uid' ";
			if($res = mysqli_query($dbcon,$query))
			{
				$row = mysqli_fetch_assoc($res);
				return $row["user_type"];
			}	
			else
			{
				echo mysqli_error($dbcon);
				return null;
			}
		}
		else
		{
			return null;
		}
	}
	function login($username,$password)
	{
		//require "config/dbconnect.php";
		global $dbcon;
		$username = htmlentities($username);
		$password = base64_encode(md5($password));
		$query = "SELECT `id`,`type_id`,`logout_time`,`login_IP` FROM `users` WHERE `username` = '$username' AND `password` = '$password'";
		if ($res = mysqli_query($dbcon,$query))
		{
			if (mysqli_num_rows($res) == 1)
			{	
				$row = mysqli_fetch_assoc($res);
				$lg_time = new DateTime($row['logout_time']);
				$logout_time = $lg_time->getTimestamp();
				
				$uid = $row['id'];
				$row['logout_time']."<br/>";
				$logout_time."<br/>";
				
				$current = date('Y-m-d H:i:s', strtotime("now"));
				$current_time = new DateTime($current);
				$current_tim_st = $current_time->getTimestamp();
				if(time() > $logout_time)
				{
					/***********************************************/
					if (!empty($_SERVER['HTTP_CLIENT_IP'])){
					  $ip_new=$_SERVER['HTTP_CLIENT_IP'];
					//Is it a proxy address
					}elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
					  $ip_new=$_SERVER['HTTP_X_FORWARDED_FOR'];
					}else{
					  $ip_new=$_SERVER['REMOTE_ADDR'];
					}
					if($ip_new == "::1")
					{
						$user_ip = 0;
					}
					else
					{
						$user_ip = get_inet_aton($ip_new);
					}
					echo $update_query = "UPDATE `users` SET `login_time`=NOW(),`logout_time`=NOW()+100 ,`login_IP`='$user_ip' WHERE `id` = '$uid'";
					if ($up_res = mysqli_query($dbcon,$update_query)) {
						$uid = $_SESSION['user_uid'] = $row['id'];
						$_SESSION['user_ref_id'] = $row['type_id'];
						session_regenerate_id();
						header('Location:../');
					}
					else
					{
						echo mysqli_error($dbcon);
					}
				}
				else
				{
					return "You account is already been loged in from :". get_inet_ntoa($row['login_IP']);
				}
			}
			else
			{
				return "Invalid username/password combination";	
			}
		}
		else
		{
			return "Failed to login.. ";
		}
	}
	function logout()
	{
		//require "config/dbconnect.php";
		global $dbcon;
		$user_uid = $_SESSION['user_uid'];
		$logout_query = "UPDATE `users` SET `logout_time`=NOW()  WHERE `id` = '$user_uid'";
		if($res = mysqli_query($dbcon,$logout_query))
		{
			session_destroy();
			header("Location:../template/index.php");
		}
	}
	function get_inet_ntoa($number)
	{
		//require "config/dbconnect.php";
		global $dbcon;
		$query = "SELECT INET_NTOA('$number')";
		if ($res = mysqli_query($dbcon,$query))
		{
			$row = mysqli_fetch_assoc($res);
			return $row["INET_NTOA('$number')"];	
		}
		else
		{
			echo mysqli_error($dbcon);
			
		}
			
	}
	function get_inet_aton($address)
	{
		global $dbcon;
		$query = "SELECT INET_ATON('$address')";
		if ($res = mysqli_query($dbcon,$query))
		{
			$row = mysqli_fetch_assoc($res);
			return $row["INET_ATON('$address')"];	
		}
		else
		{
			echo mysqli_error($dbcon);
			
		}
	}
?>