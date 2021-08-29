<?php
	function create_act($name,$exam_id)
	{
		global $dbcon;
		$query = "INSERT INTO `activities` (`id`, `name`,`exam_id`) VALUES (NULL, '$name','$exam_id')";
		if (mysqli_query($dbcon,$query)) 
		{
			return "success";
		}
		else if (mysqli_error($dbcon) == "Duplicate entry '$name' for key 'name'")
		{
			return "Duplicate Activity Name";
		}
		else
		{
			return "Due to some technical reasons! Plzz report to admin";
		}
	}

	function assign_role_to_activity($activity,$role)
	{
		global $dbcon;
		$query = "INSERT INTO `roleofactivity`(`role_id`, `act_id`) VALUES ('$role','$activity')";
		if (mysqli_query($dbcon,$query)) 
		{
			return "success";
		}
		else if (mysqli_error($dbcon) == "Duplicate entry '$role-$activity' for key 'PRIMARY'")
		{
			return "Already Assigned";
		}
		else
		{
			return "Due to some technical reasons! Plzz report to admin";
		}
		return ;
	}

	function add_activity($activity_id,$start,$end)
	{
		global $dbcon;
		echo $query = "INSERT INTO `activity_manager` (`sesn_id`,`act_id`, `start_time`, `stop_time`) VALUES ('1',$activity_id, '$start', '$end')";
		if (mysqli_query($dbcon,$query)) 
		{
			return "success";
		}
		/*else if (mysqli_error($dbcon) == "Duplicate entry '$role-$activity' for key 'PRIMARY'")
		{
			return "Already Assigned";
		}*/
		else
		{
			return "Due to some technical reasons! Plzz report to admin ".mysqli_error($dbcon);
		}
	}
?>