<?php

	function assign_staff_type($staff_id,$staff_type_id)
	{
		global $dbcon;
		$checkQuery = "";
		if ($res = mysqli_query($dbcon,$checkQuery)) {
			if (mysqli_num_rows($res) == 0) {
				$assignQuery = "";
				if ($res2 = mysqli_query($dbcon,$assignQuery)) {
					return "success";
				} else {
					return "Failed!! ".mysqli_error($dbcon);
				}
			} else {
				return "Already Assigned!!";
			}
		}
		else
		{
			return "Failed !! ".mysqli_error($dbcon);
		}
	}

	function assign_role($role_id,$user_type,$staff_type)
	{
		global $dbcon;
		$checkQuery = "SELECT `role_id` FROM `role_assign` WHERE `role_id` = '$role_id' AND `user_type` = '$user_type' AND `staff_type` = '$staff_type'";
		if ($res = mysqli_query($dbcon,$checkQuery)) {
			if (mysqli_num_rows($res) == 0) {
				$assignQuery = "INSERT INTO `role_assign` (`role_id`, `user_type`, `staff_type`) VALUES ('$role_id', '$user_type', '$staff_type')";
				if ($res2 = mysqli_query($dbcon,$assignQuery)) {
					return "success";
				} else {
					return "Failed!! ".mysqli_error($dbcon);
				}
			} else {
				return "Already Assigned!!";
			}
		}
		else
		{
			return "Failed !! ".mysqli_error($dbcon);
		}
	}

	function get_role_name($role_id)
	{
		global $dbcon;
		$query = "SELECT `role_name` FROM `roles` WHERE `id` = '$role_id'";
		if ($res = mysqli_query($dbcon,$query)) {
			if(mysqli_num_rows($res) > 0)
			{
				$row = mysqli_fetch_assoc($res);
				return $row['role_name'];
			}
			else
			{
				return "ERROR ".mysqli_error($dbcon);
			}
		} else {
			return "ERROR ".mysqli_error($dbcon);
		}
		
	}
	function get_user_type_name($user_type)
	{
		global $dbcon;
		$query = "SELECT  `type_name` FROM `user_type` WHERE `id` = '$user_type'";
		if ($res = mysqli_query($dbcon,$query)) {
			if(mysqli_num_rows($res) > 0)
			{
				$row = mysqli_fetch_assoc($res);
				return $row['type_name'];
			}
			else
			{
				return "ERROR ".mysqli_error($dbcon);
			}
		} else {
			return "ERROR ".mysqli_error($dbcon);
		}
	}
	function get_staff_type_name($staff_type)
	{
		global $dbcon;
		$query = "SELECT `staff_type_name` FROM `staff_type` WHERE `id` = '$staff_type'";
		if ($res = mysqli_query($dbcon,$query)) {
			if(mysqli_num_rows($res) > 0)
			{
				$row = mysqli_fetch_assoc($res);
				return $row['staff_type_name'];
			}
			else
			{
				return "ERROR ".mysqli_error($dbcon);
			}
		} else {
			return "ERROR ".mysqli_error($dbcon);
		}
	}
	function get_staff_name($staff_id)
	{
		global $dbcon;
		$query = "SELECT  `name` FROM `staff` WHERE `id` = '$staff_id'";
		if ($res = mysqli_query($dbcon,$query)) {
			if(mysqli_num_rows($res) > 0)
			{
				$row = mysqli_fetch_assoc($res);
				return $row['name'];
			}
			else
			{
				return "ERROR ".mysqli_error($dbcon);
			}
		} else {
			return "ERROR ".mysqli_error($dbcon);
		}
	}
	function delete_staff_role($role_id,$user_type,$staff_type)
	{
		global $dbcon;
		$query = "DELETE FROM `role_assign` WHERE `role_id` = '$role_id' AND `user_type` = '$user_type' AND `staff_type` = '$staff_type'";
		if ($res = mysqli_query($dbcon,$query)) {
			return "success";
		} else {
			return "Failed ".mysqli_error($dbcon);
		}
		
	}

	function assign_staff_roles($staff,$staff_type)
	{
		global $dbcon;
		$checkQuery = "SELECT `staff_id` FROM `staff_role` WHERE `staff_id`='$staff' AND `staff_type_id` = '$staff_type'";
		if ($res = mysqli_query($dbcon,$checkQuery)) {
			if (mysqli_num_rows($res) == 0) {
				$assignQuery = "INSERT INTO `staff_role` (`staff_id`, `staff_type_id`) VALUES ('$staff', '$staff_type')";
				if ($res2 = mysqli_query($dbcon,$assignQuery)) {
					return "success";
				} else {
					return "Failed!! ".mysqli_error($dbcon);
				}
			} else {
				return "Already Assigned!!";
			}
		}
		else
		{
			return "Failed !! ".mysqli_error($dbcon);
		}
	}


	function remove_staff_role($staff_id,$staff_type_id)
	{
		global $dbcon;
		$query = "DELETE FROM `staff_role` WHERE `staff_id` = '$staff_id' AND `staff_type_id` = '$staff_type_id'";
		if ($res = mysqli_query($dbcon,$query)) {
			return "success";
		} else {
			return "Failed ".mysqli_error($dbcon);
		}
	}
?>