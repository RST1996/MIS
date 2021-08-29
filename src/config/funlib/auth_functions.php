<?php 
	function is_eligible($page,$user_ref_id,$user_type)
	{
		global $dbcon;
		if($user_type == 2)
		{
			$check_query = "SELECT `role_assign`.`role_id`,`staff_role`.`staff_id` FROM `staff_role`,`role_assign`,`roles` WHERE `roles`.`path` = '$page' AND `roles`.`id` = `role_assign`.`role_id` AND `role_assign`.`user_type` = '$user_type' AND `staff_role`.`staff_id` = '$user_ref_id' AND `staff_role`.`staff_type_id` = `role_assign`.`staff_type`";	
		}
		else
		{
			$check_query = "SELECT `role_assign`.`role_id` FROM `role_assign`,`roles` WHERE `roles`.`path` = '$page' AND `roles`.`id` = `role_assign`.`role_id` AND `role_assign`.`user_type` = '$user_type' ";
		}
		if ($res = mysqli_query($dbcon,$check_query)) {
			if (mysqli_num_rows($res) > 0) {
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
		return false;
	}
	function clean_ip($string)
	{
		global $dbcon;
		return  mysqli_real_escape_string($dbcon,htmlentities($string));
	}

	function check_activity($page)
	{
		date_default_timezone_set('Asia/Kolkata');
		global $dbcon;
		$query = "SELECT `activity_manager`.`act_id` FROM `activity_manager` WHERE `activity_manager`.`sesn_id` = '1' AND `activity_manager`.`start_time` < NOW() AND `activity_manager`.`stop_time` > NOW() AND `activity_manager`.`act_id` IN ( SELECT `roleofactivity`.`act_id` FROM `roles`,`roleofactivity` WHERE `roles`.`path`='$page' AND `roles`.`id` = `roleofactivity`.`role_id` )";
		if ($res = mysqli_query($dbcon,$query))
		{
			$act_id_array = array();
				if(mysqli_num_rows($res) == 0)
				{
					return "No Related Activity has been started";
				}	
				else
				{
					while ($row = mysqli_fetch_assoc($res)) {
						$act_id_array[] = $row['act_id'];
					}
					return $act_id_array;
				}
		}	
	}
?>