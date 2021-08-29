<?php
	function  register_reeval($rcourse_list,$bcourse_list,$stud_id)
	{
		//echo "function called";
		global $dbcon;
		$sesn_id = get_sesn_id();

		if($sesn_id != false)
		{
		
			$query = "INSERT INTO `reval_registration` (`sesn_id`, `stud_id`, `course_id`,`exam_type`) VALUES ";
			$queryset = array();
			for ($i = 0 ; $i < sizeof($rcourse_list) ; $i++) {
				$queryset[] = "('$sesn_id', '$stud_id', '$rcourse_list[$i]','5')";
			}
			for ($i = 0 ; $i < sizeof($bcourse_list) ; $i++) {
				$queryset[] = " ('$sesn_id', '$stud_id', '$bcourse_list[$i]','5')";
			}
			 $query .= implode(", ", $queryset);
			if ($res = mysqli_query($dbcon,$query)) {
				return "success";
			} else {
				return mysqli_error($dbcon);
			}			
		}
	}
	function registration_stat($stud_id)
	{
		global $dbcon;
		$sesn_id = get_sesn_id();
		if ($sesn_id == false) {
			return false;
		}
		$query = "SELECT * FROM `exam_registration`,`marks_th_ese`  WHERE `exam_registration`.`sesn_id` = '$sesn_id' AND `exam_registration`.`stud_id` = '$stud_id' AND `marks_th_ese`.`stud_id` = '$stud_id' AND `marks_th_ese`.`sesn_id` = '$sesn_id' AND `marks_th_ese`.`ab_flag` ='0'";
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
	function registration_status_photocopy($stud_id)
	{
		global $dbcon;
		$sesn_id = get_sesn_id();
		if ($sesn_id == false) {
			return false;
		}
		
	$query = "SELECT
				  *
				FROM
				  `exam_registration`,
				  `marks_th_ese`,
				  `reval_registration`
				WHERE
				  `exam_registration`.`sesn_id` = '$sesn_id' AND `exam_registration`.`stud_id` = '$stud_id' AND `marks_th_ese`.`stud_id` = '$stud_id' AND `marks_th_ese`.`sesn_id` = '$sesn_id' AND `reval_registration`.`stud_id` = '$stud_id' AND `reval_registration`.`conf_flag` = '1' AND `marks_th_ese`.`reval_flag` = '1'  AND `reval_registration`.`sesn_id` = '$sesn_id' AND `reval_registration`.`course_id` = `marks_th_ese`.`course_id` AND `exam_registration`.`course_id` = `marks_th_ese`.`course_id`";
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
	function  register_photocopy($rcourse_list,$stud_id)
	{
		//echo "function called";
		global $dbcon;
		$sesn_id = get_sesn_id();

		if($sesn_id != false)
		{
		
			for ($i = 0 ; $i < sizeof($rcourse_list) ; $i++) {
				$query = "UPDATE `reval_registration` SET `challenge_flag`= '1' WHERE `reval_registration`.`course_id` = '$rcourse_list[$i]'";
				if ($res = mysqli_query($dbcon,$query)) {
				return "success";
				} else {
					return mysqli_error($dbcon);
				}	
			}
			
					
		}
	}
	function reval_registration_stat($stud_id)
	{
		global $dbcon;
		$sesn_id = get_sesn_id();
		if ($sesn_id == false) {
			return false;
		}
		$query = "SELECT * FROM `reval_registration` WHERE `sesn_id` = '$sesn_id' AND `stud_id` = '$stud_id'";
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
	function photocopy_registration_stat($stud_id)
	{
		global $dbcon;
		$sesn_id = get_sesn_id();
		if ($sesn_id == false) {
			return false;
		}
		$query = "SELECT * FROM `reval_registration` WHERE `sesn_id` = '$sesn_id' AND `stud_id` = '$stud_id' AND `reval_registration`.`challenge_flag` = '1'";
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
	function conform_reg($id)
	{
		global $dbcon;
		
		$query = "UPDATE `reval_registration` SET `conf_flag`='1' WHERE `stud_id`= $id ";
		if ($res = mysqli_query($dbcon,$query)) {
				return "success";
		} else {
				return mysqli_error($dbcon);
		}	
	}
	function conform_photocopy_reg($id)
	{
		global $dbcon;
		
		$query = "UPDATE `reval_registration` SET `challenge_conf_flag`='1' WHERE `stud_id`= $id ";
		if ($res = mysqli_query($dbcon,$query)) {
				return "success";
		} else {
				return mysqli_error($dbcon);
		}	
	}
	function reg_conform_stat($stud_id)
	{
		global $dbcon;
		$sesn_id =get_sesn_id();
		$query = "SELECT `conf_flag` FROM `reval_registration` WHERE `stud_id` = '$stud_id'";
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
	function get_reeval_courses($stud_id)
	{
		global $dbcon;
		$sesn_id =get_sesn_id();
		$query = "SELECT `course_id` FROM `reval_registration` WHERE `stud_id` = '$stud_id' ";
		if ($res = mysqli_query($dbcon,$query)) {
			if(mysqli_num_rows($res) > 0){
				$str = "";
				while($row = mysqli_fetch_assoc($res))
				{
					$c_id = $row['course_id'];
					$cc= get_reeval_course_code($c_id);
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
	function get_reeval_course_code($id)
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
	function reeval_conform_stat($stud_id)
	{
		global $dbcon;
		$sesn_id =get_sesn_id();
		$query = "SELECT `conf_flag` FROM `reval_registration` WHERE `stud_id` = '$stud_id'";
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
	function photocopy_conform_stat($stud_id)
	{
		global $dbcon;
		$sesn_id =get_sesn_id();
		$query = "SELECT `challenge_conf_flag` FROM `reval_registration` WHERE `stud_id` = '$stud_id'";
		if ($res = mysqli_query($dbcon,$query)) {
			if(mysqli_num_rows($res) > 0){
				$row = mysqli_fetch_assoc($res);
				if($row['challenge_conf_flag']== 1)
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
	
	
	function get_courses($stud_id)
	{
		global $dbcon;
		$sesn_id =get_sesn_id();
		$query = "SELECT `course_id` FROM `reval_registration` WHERE `stud_id` = '$stud_id' ";
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
	function get_photocopy_courses($stud_id)
	{
		global $dbcon;
		$sesn_id =get_sesn_id();
		$query = "SELECT `course_id` FROM `reval_registration` WHERE `reval_registration`.`stud_id` = '$stud_id' AND `reval_registration`.`conf_flag` ='1'  AND `reval_registration`.`challenge_flag` = '1'";
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
?>