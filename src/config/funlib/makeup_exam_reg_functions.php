<?php
	function  register_makeup_exam($tcourse_list,$pcourse_list,$stud_id)
	{
		//echo "function called";
		global $dbcon;
		$sesn_id = get_cur_sesn_id();

		if($sesn_id != false)
		{
		
			$query = "INSERT INTO `makeup_registration` (`sesn_id`, `stud_id`, `course_id`,`exam_type`) VALUES ('$sesn_id', '$stud_id', '$tcourse_list[0]','5')";
			for ($i = 1 ; $i < sizeof($tcourse_list) ; $i++) {
				$query .= ", ('$sesn_id', '$stud_id', '$tcourse_list[$i]','5')";
			}
			for ($i = 0 ; $i < sizeof($pcourse_list) ; $i++) {
				$query .= ", ('$sesn_id', '$stud_id', '$pcourse_list[$i]','6')";
			}
			$query;
			if ($res = mysqli_query($dbcon,$query)) {
				return "success";
			} else {
				return mysqli_error($dbcon);
			}			
		}
	}
	function registration_status_makeup($stud_id)
	{
		global $dbcon;
		$sesn_id = get_cur_sesn_id();
		if ($sesn_id == false) {
			return false;
		}
		
		$query = "SELECT * FROM `exam_registration`,`marks_th_ese`  WHERE `exam_registration`.`sesn_id` = '$sesn_id' AND `marks_th_ese`.`sesn_id` = '$sesn_id' AND `exam_registration`.`stud_id` = '$stud_id' AND `marks_th_ese`.`stud_id` = '$stud_id'  AND `marks_th_ese`.`ab_flag` = '1' AND `exam_registration`.`conform_status` = '1'";
		
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
	function makeup_exam_registration_stat($stud_id)
	{
		global $dbcon;
		$sesn_id = get_cur_sesn_id();
		if ($sesn_id == false) {
			return false;
		}
		$query = "SELECT * FROM `makeup_registration` WHERE `sesn_id` = '$sesn_id' AND `stud_id` = '$stud_id'";
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
	function conform_exam_makeup_reg($id)
	{
		global $dbcon;
		
		$query = "UPDATE `makeup_registration` SET `conf_flag`='1' WHERE `stud_id`= $id ";
		if ($res = mysqli_query($dbcon,$query)) {
				return "success";
		} else {
				return mysqli_error($dbcon);
		}	
	}
	function makeup_exam_reg_conform_stat($stud_id)
	{
		global $dbcon;
		$sesn_id =get_cur_sesn_id();
		$query = "SELECT `conf_flag` FROM `makeup_registration` WHERE `stud_id` = '$stud_id'";
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
	function get_makeup_courses($stud_id)
	{
		global $dbcon;
		$sesn_id =get_cur_sesn_id();
		$query = "SELECT `course_id` FROM `makeup_registration` WHERE `stud_id` = '$stud_id' ";
		if ($res = mysqli_query($dbcon,$query)) {
			if(mysqli_num_rows($res) > 0){
				$str = "";
				while($row = mysqli_fetch_assoc($res))
				{
					$c_id = $row['course_id'];
					$cc= get_makeup_course_code($c_id);
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
	function get_makeup_course_code($id)
	{
		global $dbcon;
		$sesn_id =get_cur_sesn_id();
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
	function get_cur_sesn_id()
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
	function get_courses($stud_id)
	{
		global $dbcon;
		$sesn_id =get_cur_sesn_id();
		$query = "SELECT `course_id` FROM `makeup_registration` WHERE `stud_id` = '$stud_id' ";
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
		$sesn_id =get_cur_sesn_id();
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
?>