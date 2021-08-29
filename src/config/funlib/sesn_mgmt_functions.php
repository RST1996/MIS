<?php
	function add_academic_year($name,$sec_pass)
	{
		global $dbcon;
		$pass = base64_encode(md5($sec_pass));
		$uid = $_SESSION['user_uid'];
		$query = "SELECT  `username` FROM `users` WHERE `id` = '$uid'";
		if ($res = mysqli_query($dbcon,$query)) {
			while ($row = mysqli_fetch_assoc($res)) {
				$username = $row['username'];
				$check_query = "SELECT `id` FROM `users` WHERE `username` = '$username' AND `password` = '$pass'";
				if ($r = mysqli_query($dbcon,$check_query)) {
					if(mysqli_num_rows($r) == 1 ) {
						$insert_query = "INSERT INTO `academic_year` (`ac_id`, `academic_year`) VALUES (NULL, '$name')";
						if ($ires = mysqli_query($dbcon,$insert_query)) {
							$ac_id = mysqli_insert_id($dbcon);
							
							$conf_update = "UPDATE `ses_conf` SET `prev_acyr`= `current_acyr`, `current_acyr`='$ac_id' WHERE `id` = '1'";
							
							if ($con_res = mysqli_query($dbcon,$conf_update)) {
								return "success";
							} else {
								return "Failed: ".mysqli_error($dbcon);
							}
							
						} else {
							return "Failed: ".mysqli_error($dbcon);
						}
					}
					else
					{
						return "Invalid Security Code..!!";
					}

				} else {
					return "Failed: ".mysqli_error($dbcon);
				}
			}
		} else {
			return "Failed: ".mysqli_error($dbcon);
		}
	}
	function add_new_exam_sesn($exam_sesn,$sec_pass)
	{
		global $dbcon;
		$pass = base64_encode(md5($sec_pass));
		$uid = $_SESSION['user_uid'];
		$query = "SELECT  `username` FROM `users` WHERE `id` = '$uid'";
		if ($res = mysqli_query($dbcon,$query)) {
			while ($row = mysqli_fetch_assoc($res)) {
				$username = $row['username'];
				$check_query = "SELECT `id` FROM `users` WHERE `username` = '$username' AND `password` = '$pass'";
				if ($r = mysqli_query($dbcon,$check_query)) {
					if(mysqli_num_rows($r) == 1 ) {
						
						$ac_yr = get_current_acyr();
						if( $ac_yr != -1 ){
							$insert_query = "INSERT INTO `sessions` (`sesn_id`, `academic_yr`, `exam_sesn`) VALUES (NULL, '$ac_yr', '$exam_sesn')";
							if ($ires = mysqli_query($dbcon,$insert_query)) {
								$sesn_id = mysqli_insert_id($dbcon);
								
								$conf_update = "UPDATE `ses_conf` SET `current_session`= '$sesn_id' WHERE `id` = '1'";
								
								if ($con_res = mysqli_query($dbcon,$conf_update)) {
									return "success";
								} else {
									return "Failed: ".mysqli_error($dbcon);
								}
								
							} else {
								return "Failed: ".mysqli_error($dbcon);
							}
						}
					}
					else
					{
						return "Invalid Security Code..!!";
					}

				} else {
					return "Failed: ".mysqli_error($dbcon);
				}
			}
		} else {
			return "Failed: ".mysqli_error($dbcon);
		}
	}

	function get_current_acyr()
	{
		global $dbcon;
		$query = "SELECT `current_acyr` FROM `ses_conf` WHERE `id` = 1";
		if ($res = mysqli_query($dbcon,$query)) {
			if (mysqli_num_rows($res) == 1) {
				$row = mysqli_fetch_assoc($res);
				return $row['current_acyr'];
			} else {
				return (-1);
			}
			
		} else {
			return (-1);
		}		
	}
?>