<?php
	function check($id,$course_id,$exam_id)
	{
		global $dbcon;
		$sesn_id = get_sesn_id();
		$query = "SELECT `stud_id` FROM `ne_list` WHERE `stud_id`=$id AND `course_id` = '$course_id' AND `exam_id`='$exam_id' AND `sesn_id`= '$sesn_id'";
		if ($res = mysqli_query($dbcon,$query)) {
			if(mysqli_num_rows($res) == 1){
				
				return true;
			}
			else
				return false;
		} else {
			return false;
		}	
	}
	function not_eligible($id,$course,$user,$exam_id,$reason)
	{
		global $dbcon;
		$sesn_id = get_sesn_id();
		//echo $sesn_id;
		//$act_id = get_activity_id($user);
		//$exam_id = get_exam_id($act_id);
		//echo $act_id;
		$query = "INSERT INTO `ne_list`(`sesn_id`, `stud_id`, `course_id`, `exam_id`, `reason`) VALUES ('$sesn_id','$id','$course','$exam_id','$reason')";
		if ($res = mysqli_query($dbcon,$query)) {
			return "success";
		} else {
			return "Failed to provide login.. ".mysqli_error($dbcon);
		}
	}
	function get_exam_id($act_id)
	{
		if($act_id == 1)
			return 1;
		else if($act_id == 2)
			return 2;
	}
	function get_sesn_id()
	{
		global $dbcon;
		$query = "SELECT `current_session` FROM `ses_conf` WHERE `id` = 1";
		if ($res = mysqli_query($dbcon,$query)) {
			if(mysqli_num_rows($res) == 1){
				$row = mysqli_fetch_assoc($res);
				return $row['current_session'];
			}
			else
				return false;
		} else {
			return false;
		}	
	}
	function get_activity_id($user)
	{
			global $dbcon;
			$query="SELECT `act_id` FROM `roleofactivity` WHERE `role_id` IN (SELECT `role_id` FROM `role_assign` WHERE `staff_type`=6)";
			if ($res = mysqli_query($dbcon,$query)) {
			if(mysqli_num_rows($res) == 1){
				$row = mysqli_fetch_assoc($res);
				return $row['act_id'];
			}
			else
				return false;
		} else {
			return false;
		}	
	}
	

	function check_lock($course,$exam){
		global $dbcon;

		$query = "SELECT * FROM `ne_list` WHERE `course_id` = '$course' AND `exam_id` = '$exam' AND `conf_flag` = 1 ";
		if ($res = mysqli_query($dbcon,$query)) {
			if (mysqli_num_rows($res) == 0){
				return false;
			}
			else{
				return true;
			}
		}
		else
		{
			return true;
		}
	}
	
	function lock($exam_id,$course_id)
	{
		global $dbcon;
		$sesn_id = get_sesn_id();
		$query = "UPDATE `ne_list` SET `conf_flag`='1' WHERE `sesn_id` = '$sesn_id' AND `course_id` = '$course_id' AND `exam_id` = '$exam_id'";
		if ($res = mysqli_query($dbcon,$query)) {
			return "success";
		}
		else
		{
			return "Failed  due to some tech reason plz contact admin !!";
		}
	}
	function remove($stud,$course,$exam){
		global $dbcon;
		$sesn_id = get_sesn_id();
		$query = "DELETE FROM `ne_list` WHERE `sesn_id` = '$sesn_id' AND `stud_id`='$stud' AND `course_id` = '$course' AND `exam_id` = '$exam'";
		if($res = mysqli_query($dbcon,$query))
		{
			return true;
		}
		else
		{
			return false;
		}
		return false;

	}

?>