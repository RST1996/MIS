<?php
	function  register_exam($rcourse_list,$bcourse_list,$stud_id,$ac_yr)
	{
		//echo "function called";
		global $dbcon;
		$sesn_id = get_sesn_id();
		if($sesn_id != false)
		{
			
			$query = "INSERT INTO `exam_registration` (`sesn_id`, `stud_id`, `course_id`,`reg_ac_yr`,`regular_flag`) VALUES ";
			$queryset = array();
			for ($i = 0 ; $i < sizeof($rcourse_list) ; $i++) {
				$queryset[] = "('$sesn_id', '$stud_id', '$rcourse_list[$i]','$ac_yr','1')";
			}
			for ($i = 0 ; $i < sizeof($bcourse_list) ; $i++) {
				$queryset[] = "('$sesn_id', '$stud_id', '$bcourse_list[$i]','$ac_yr','0')";
			}
			$query .= implode(", ", $queryset);
			if ($res = mysqli_query($dbcon,$query)) {
				return "success";
			} else {
				return mysqli_error($dbcon);
			}			
		}
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
	function exam_registration_stat($stud_id)
	{
		global $dbcon;
		$sesn_id = get_sesn_id();
		if ($sesn_id == false) {
			return false;
		}
		//$query = "SELECT * FROM `exam_registration` WHERE `sesn_id` = '$sesn_id' AND `stud_id` = '$stud_id' AND `result_flag` = '0' AND (`grade` = 'F' OR `grade` = 'Z')";
		$query = "SELECT * FROM `exam_registration` WHERE `sesn_id` = '$sesn_id' AND `stud_id` = '$stud_id' ";
		if ($res = mysqli_query($dbcon,$query)) {
			
			if (mysqli_num_rows($res) > 0) {
				
				return "Alredy registered";
			} else {
				
				return "Not registered";
			}
			
		} else {
			return false;
		}
		
	}

	function get_department($staff_id)
	{
		global $dbcon;
		$query = "SELECT `department` FROM `staff` WHERE `id` = '$staff_id';";
		if ($res = mysqli_query($dbcon,$query)) {
			$row = mysqli_fetch_assoc($res);
			return $row['department'];
		}
	}
	
	function conform_exam_reg($id)
	{
		global $dbcon;
		$sesn_id = get_sesn_id();
		$query = "UPDATE `exam_registration` SET `conform_status`='1' WHERE `stud_id`= $id AND `sesn_id` ='$sesn_id'";
		if ($res = mysqli_query($dbcon,$query)) {
				return "success";
		} else {
				return mysqli_error($dbcon);
		}	
	}
	
	function exam_reg_conform_stat($stud_id)
	{
		global $dbcon;
		$sesn_id =get_sesn_id();
		$query = "SELECT `conform_status` FROM `exam_registration` WHERE `stud_id` = '$stud_id' AND `result_flag` = '0' AND `sesn_id` = '$sesn_id' ";
		if ($res = mysqli_query($dbcon,$query)) {
			if(mysqli_num_rows($res) > 0){
				$row = mysqli_fetch_assoc($res);
				if($row['conform_status']== 1)
				{
					return 1;
				}
				else
				{
					return 0;
				}
			}
			else
				return -1;
		} else {
			return mysqli_error($dbcon);
		}	
		
	}
	function get_courses($stud_id)
	{
		global $dbcon;
		$sesn_id =get_sesn_id();
		$query = "SELECT `course_id` FROM `exam_registration` WHERE `stud_id` = '$stud_id' AND `result_flag` = '0' AND `sesn_id` = '$sesn_id' ";
		if ($res = mysqli_query($dbcon,$query)) {
			if(mysqli_num_rows($res) > 0){
				$str = "";
				while($row = mysqli_fetch_assoc($res))
				{
					$c_id = $row['course_id'];
					$cc= get_course_code($c_id);
					$str .= $cc ;
					
				}
				return $str;
			}
			else
				return "Not registered.";
		} else {
			return mysqli_error($dbcon);
		}	
	}
	function get_course_code($id)
	{
		global $dbcon;
		$sesn_id =get_sesn_id();
		$query = "SELECT `course_code` FROM `course` WHERE `id` = '$id' ";
		if ($res = mysqli_query($dbcon,$query)) {
			if(mysqli_num_rows($res) > 0){
				$str="";
				while($row = mysqli_fetch_assoc($res))
				{
					$c_id = $row['course_code'];
					$str .= $c_id .",";
				}
				return $str;
			}
			
		} else {
			return mysqli_error($dbcon);
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
