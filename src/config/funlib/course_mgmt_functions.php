<?php
	function add_course($data)
	{
		global $dbcon;
		//print_r($data);
		//return "testing";
		$course_code = $data["course_code"];
		$course_name = $data["name"];
		$ctype = $data["course_type"];
		$credits = $data["credits"];
		$query = "INSERT INTO `course` (`id`, `course_code`, `course_name`, `course_type_id`, `credits`) VALUES (NULL, '$course_code', '$course_name', '$ctype', '$credits')";
		if ($res = mysqli_query($dbcon,$query)) {
			$sub_id = mysqli_insert_id($dbcon);
			switch ($ctype) {
				case 1:
					$isa = $data["isa"];
					$ise1 = $data["ise1"];
					$ise2 = $data["ise2"];
					$ese = $data["ese"];
					$query2 = "INSERT INTO `th_mks_scheme` (`sub_id`, `isa`, `ise1`, `ise2`, `ese`) VALUES ('$sub_id', '$isa', '$ise1', '$ise2', '$ese')";
					break;
				case 2:
					$ica = $data["ica"];
					$ese = $data["ese"];
					$query2 = "INSERT INTO `pr_mks_scheme` (`sub_id`, `ica`, `ese`) VALUES ('$sub_id', '$ica', '$ese')";
					break;
			}
			if ($r = mysqli_query($dbcon,$query2)) {
				return "success";
			} else {
				return "Unable to add marking scheme contact Admin ".mysqli_error($dbcon);
			}
			
		} else {
			return "Unable to add course ".mysqli_error($dbcon);
		}
	}

	function assign_course($sub_id,$sem,$branch,$cur_acc_yr)
	{
		global $dbcon;
		$query = "INSERT INTO `course_assign`(`sub_id`, `sem`, `branch`,`ac_yr`) VALUES ('$sub_id','$sem','$branch','$cur_acc_yr')";
		if ($res = mysqli_query($dbcon,$query)) {
			return "success";
		} else {
			return "Unable to assign Course ".mysqli_error($dbcon);
		}
	}

	function assign_course_coordinator($course_id,$coordinator_id)
	{
		global $dbcon;
		$query = "INSERT INTO `course_coordinator` (`course_id`, `course_coord_id`) VALUES ('$course_id', '$coordinator_id')";
		if ($res = mysqli_query($dbcon,$query)) {
			return "success";
		} else {
			return mysqli_error($dbcon);
		}
	}

	
	function assign_course_teacher($sem,$dept,$sub_id,$staff_id)
	{
		global $dbcon;
		$query = "INSERT INTO `course_teacher` (`sub_id`,`sem`,`branch`,`staff_id`) VALUES ('$sub_id','$sem',
		'$dept','$staff_id')";
		if ($res = mysqli_query($dbcon,$query)) {
			return "success";
		} else {
			return mysqli_error($dbcon);
		}
	}
	function get_department_name($id)
	{
		global $dbcon;
		$query = "SELECT * FROM `department` WHERE `id` = '$id'";
		if ($res = mysqli_query($dbcon,$query)) {
			$row = mysqli_fetch_assoc($res);
			return $row['department_name'];
		} else {
			echo mysqli_error($dbcon);
		}
	}
	
?>