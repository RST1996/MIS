<?php
	function register_cource($course_list,$stud_id)
	{
		global $dbcon;
		$sesn_id = get_sesn_id();
		if($sesn_id != false)
		{
			$query = "INSERT INTO `course_registration` (`sesn_id`, `stud_id`, `course_id`) VALUES ('$sesn_id', '$stud_id', '$course_list[0]')";
			for ($i = 1 ; $i < sizeof($course_list) ; $i++) {
				$query .= ", ('$sesn_id', '$stud_id', '$course_list[$i]')";
			}
		//	echo $query;
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
	function course_registration_stat($stud_id)
	{
		global $dbcon;
		$sesn_id = get_sesn_id();
		if ($sesn_id == false) {
			return false;
		}
		$query = "SELECT * FROM `course_registration` WHERE `sesn_id` = '$sesn_id' AND `stud_id` = '$stud_id'";
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
?>