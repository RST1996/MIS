<?php
function  register_exam($course_list,$stud_id)
	{
		//echo "function called";
		global $dbcon;
		$sesn_id = get_sesn_id();
		if($sesn_id != false)
		{
			$query =" INSERT INTO `internal_cancellation`(`sesn_id`, `stud_id`, `course_id`, `conf_flag`) VALUES ('$sesn_id', '$stud_id', '$course_list[0]','0') ";
			
			for ($i = 1 ; $i < sizeof($course_list) ; $i++) {
				$query .= ", ('$sesn_id', '$stud_id', '$course_list[$i]','0')";
			}
			
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
	function check_internal_cancellation_applicable_stat($stud_id)
	{
		global $dbcon;
		$sesn_id = get_sesn_id();
		if ($sesn_id == false) {
			return false;
		}
		$query = "SELECT * FROM `exam_registration` WHERE `exam_registration`.`sesn_id` = '$sesn_id' AND `exam_registration`.`stud_id` = '$stud_id' AND `exam_registration`.`conform_status` = '1' AND `exam_registration`.`result_flag`= '1' AND `exam_registration`.`grade_flag` = '1' AND `exam_registration`.`grade` = 'F'";
		if ($res = mysqli_query($dbcon,$query)) {
			if (mysqli_num_rows($res) > 0) {
				
				return 1;
			} else {
				
				return 0;
			}
			
		} else {
			return false;
		}
		
	}
	function internal_cancellation_registration_stat($stud_id)
	{
		global $dbcon;
		$sesn_id = get_sesn_id();
		if ($sesn_id == false) {
			return false;
		}
		$query = "SELECT * FROM `internal_cancellation` WHERE `sesn_id` = '$sesn_id' AND `stud_id` = '$stud_id'";
		
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
     function reg_conform_stat($stud_id)
	{
		global $dbcon;
		$sesn_id =get_sesn_id();
		$query = "SELECT `conf_flag` FROM `internal_cancellation` WHERE `stud_id` = '$stud_id'";
		if ($res = mysqli_query($dbcon,$query)) {
			if(mysqli_num_rows($res) > 0){
				$row = mysqli_fetch_assoc($res);
				if($row['conf_flag']== 1)
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
		$query = "SELECT `course_id` FROM `internal_cancellation` WHERE `stud_id` = '$stud_id' ";
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
	function conform_reg($id)
	{
		global $dbcon;
		
		$query = "UPDATE `internal_cancellation` SET `conf_flag`='1' WHERE `stud_id`= $id ";
		if ($res = mysqli_query($dbcon,$query)) {
				return "success";
		} else {
				return mysqli_error($dbcon);
		}	
	}
?>