<?php
	function marks_entry($exam_id,$course_id,$student_list,$marks_list,$ne_stud_list,$absent_stud_list)
	{
		global $dbcon;
		$sesn_id = get_sesn_id();
		$query = "INSERT INTO `marks_others` (`sesn_id`, `stud_id`, `course_id`, `marks`, `exam_type`, `ne_flag`,`ab_flag`) VALUES ";
		$element_array = array();
		foreach ($student_list as $stud_id) {
			if(in_array($stud_id, $ne_stud_list))
			{
				$element_array[] = "('$sesn_id','$stud_id','$course_id','0','$exam_id','1','0')";
			}
			else if(in_array($stud_id, $absent_stud_list))
			{
				$element_array[] = "('$sesn_id','$stud_id','$course_id','0','$exam_id','0','1')";
			}
			else
			{
				$ind = "'".$stud_id."'";
				//settype($ind, "string");

				$marks = $marks_list[$ind];
				//print_r($marks_list);
				$element_array[] = "('$sesn_id','$stud_id','$course_id','$marks','$exam_id','0','0')";
			}
		}
		$query = $query . implode(", ", $element_array);
		//echo $query;
		if($res = mysqli_query($dbcon,$query))
		{
			return "success";
		}
		else
		{
			echo mysqli_error($dbcon);
			return "Failed ".mysqli_error($dbcon);
		}

	}

	function check_ne($stud_id,$course_id,$exam_id)
	{
		global $dbcon;
		$sesn_id = get_sesn_id();
		$query = "SELECT * FROM `ne_list` WHERE `sesn_id` = '$sesn_id' AND `stud_id` = '$stud_id' AND `course_id` = '$course_id' AND `exam_id` = '$exam_id'";
		if ($res = mysqli_query($dbcon,$query)) {
			if (mysqli_num_rows($res) > 0) {
				return true;
			} else {
				return false;
			}
			
		} else {
			return false;
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

	function check_marks_entry($stud_id,$course_id,$exam_id)
	{
		global $dbcon;
		$sesn_id = get_sesn_id();
		$query = "SELECT * FROM `marks_others` WHERE `sesn_id` = '$sesn_id' AND `stud_id` = '$stud_id' AND `course_id` = '$course_id' AND `exam_type` = '$exam_id'";
		if ($res = mysqli_query($dbcon,$query)) {
			if (mysqli_num_rows($res) == 1) {
				return true;			
			}
			else if(mysqli_num_rows($res) == 0)
			{
				return false;
			}
			else
			{
				die("Unusual conditions found...! :( ");
			}
		}
	}

	function ese_th_marks_entry($exam_id,$course_id,$student_list,$marks_list,$ne_stud_list,$absent_stud_list)
	{
		global $dbcon;
		$sesn_id = get_sesn_id();
		$query = "INSERT INTO `marks_th_ese` (`sesn_id`, `stud_id`, `course_id`, `marks`, `exam_type`, `ne_flag`,`ab_flag`) VALUES ";
		$element_array = array();
		foreach ($student_list as $stud_id) {
			if(in_array($stud_id, $ne_stud_list))
			{
				$element_array[] = "('$sesn_id','$stud_id','$course_id','0','$exam_id','1','0')";
			}
			else if(in_array($stud_id, $absent_stud_list))
			{
				$element_array[] = "('$sesn_id','$stud_id','$course_id','0','$exam_id','0','1')";
			}
			else
			{
				$ind = "'".$stud_id."'";
				//settype($ind, "string");

				$marks = $marks_list[$ind];
				//print_r($marks_list);
				$element_array[] = "('$sesn_id','$stud_id','$course_id','$marks','$exam_id','0','0')";
			}
		}
		$query = $query . implode(", ", $element_array);
		//echo $query;
		if($res = mysqli_query($dbcon,$query))
		{
			return "success";
		}
		else
		{
			echo mysqli_error($dbcon);
			return "Failed ".mysqli_error($dbcon);
		}

	}
	function ese_pr_marks_entry($exam_id,$course_id,$student_list,$marks_list,$ne_stud_list,$absent_stud_list)
	{
		global $dbcon;
		$sesn_id = get_sesn_id();
		$query = "INSERT INTO `marks_pr_ese` (`sesn_id`, `stud_id`, `course_id`, `marks`, `exam_type`, `ne_flag`,`ab_flag`) VALUES ";
		$element_array = array();
		foreach ($student_list as $stud_id) {
			if(in_array($stud_id, $ne_stud_list))
			{
				$element_array[] = "('$sesn_id','$stud_id','$course_id','0','$exam_id','1','0')";
			}
			else if(in_array($stud_id, $absent_stud_list))
			{
				$element_array[] = "('$sesn_id','$stud_id','$course_id','0','$exam_id','0','1')";
			}
			else
			{
				$ind = "'".$stud_id."'";
				//settype($ind, "string");

				$marks = $marks_list[$ind];
				//print_r($marks_list);
				$element_array[] = "('$sesn_id','$stud_id','$course_id','$marks','$exam_id','0','0')";
			}
		}
		$query = $query . implode(", ", $element_array);
		//echo $query;
		if($res = mysqli_query($dbcon,$query))
		{
			return "success";
		}
		else
		{
			echo mysqli_error($dbcon);
			return "Failed ".mysqli_error($dbcon);
		}

	}
	function check_ese_marks_entry($stud_id,$course_id,$exam_id)
	{
		global $dbcon;
		$sesn_id = get_sesn_id();
		if($exam_id == 5)
			$query = "SELECT * FROM `marks_th_ese` WHERE `sesn_id` = '$sesn_id' AND `stud_id` = '$stud_id' AND `course_id` = '$course_id' AND `exam_type` = '$exam_id'";
		
		else if($exam_id == 6)
			$query = "SELECT * FROM `marks_pr_ese` WHERE `sesn_id` = '$sesn_id' AND `stud_id` = '$stud_id' AND `course_id` = '$course_id' AND `exam_type` = '$exam_id'";
		if ($res = mysqli_query($dbcon,$query)) {
			
			if (mysqli_num_rows($res) == 1) {
				return true;			
			}
			else if(mysqli_num_rows($res) == 0)
			{
				return false;
			}
			else
			{
				die("Unusual conditions found...! :( ");
			}
		}
	}
	function makeup_marks_entry($exam_id,$course_id,$student_list,$marks_list)
	{
		global $dbcon;
		$sesn_id = get_sesn_id();
		$error = 0;
		foreach ($student_list as $stud_id) {
			$mark = $marks_list[$stud_id];
			$query = "UPDATE `marks_others` SET `marks` = '$mark'  WHERE `sesn_id`='$sesn_id' AND `stud_id`='$stud_id' AND `course_id`='$course_id' AND `exam_type`='$exam_id' AND `ne_flag`='0' AND `ab_flag`='1'";
			//echo "<br/>";
			if($res = mysqli_query($dbcon,$query))
			{

			}
			else
			{
				//echo mysqli_error($dbcon);
				//echo "<br/>";
				$error ++;
			}
		}
		if($error == 0)
			return "success";
		else
			return "No. of failures: ".$error ;
	}

	function ese_makeup_marks_entry($exam_id,$course_id,$student_list,$marks_list)
	{
		global $dbcon;
		$sesn_id = get_sesn_id();
		$error = 0;
		foreach ($student_list as $stud_id) {
			$mark = $marks_list[$stud_id];
			switch($exam_id){
			case 5:
				$query = "UPDATE `marks_th_ese` SET `marks` = '$mark'  WHERE `sesn_id`='$sesn_id' AND `stud_id`='$stud_id' AND `course_id`='$course_id' AND `exam_type`='$exam_id' AND `ne_flag`='0' AND `ab_flag`='1'";
			break;
			case 6:
				$query = "UPDATE `marks_pr_ese` SET `marks` = '$mark'  WHERE `sesn_id`='$sesn_id' AND `stud_id`='$stud_id' AND `course_id`='$course_id' AND `exam_type`='$exam_id' AND `ne_flag`='0' AND `ab_flag`='1'";
			break;
			}
			if($res = mysqli_query($dbcon,$query))
			{

			}
			else
			{
				
				$error ++;
			}
		}
		if($error == 0)
			return "success";
		else
			return "No. of failures: ".$error ;
	}

	function check_ese_makeup_marks_entry($stud_id,$course_id,$exam_id)
	{
		global $dbcon;
		$sesn_id = get_sesn_id();
		switch($exam_id){
			case '5':
				$query = "SELECT * FROM `marks_th_ese` WHERE `sesn_id` = '$sesn_id' AND `stud_id` = '$stud_id' AND `course_id` = '$course_id' AND `exam_type` = '$exam_id' AND `marks` > 0";
			break;
			case '6':
				$query = "SELECT * FROM `marks_pr_ese` WHERE `sesn_id` = '$sesn_id' AND `stud_id` = '$stud_id' AND `course_id` = '$course_id' AND `exam_type` = '$exam_id' AND `marks` > 0";
			break;
		}
		if ($res = mysqli_query($dbcon,$query)) {
			if (mysqli_num_rows($res) == 1) {
				return true;			
			}
			else if(mysqli_num_rows($res) == 0)
			{
				return false;
			}
			else
			{
				die("Unusual conditions found...! :( ");
			}
		}
	}
	
	function get_hod_department()
	{
		global $dbcon;
		//print_r($_SESSION);
		//echo "<br/>";
		$staff_id = $_SESSION['user_ref_id'];
		$query = "SELECT `id` FROM `department` WHERE `hod` = '$staff_id'";
		if($res = mysqli_query($dbcon,$query))
		{
			if(mysqli_num_rows($res) == 1)
			{
				$row  = mysqli_fetch_assoc($res);
				return $row['id'];
			}
			else
				return false;
		}
	}



		/* FUNATION TO REGITSER STUDENTS FOR MAKEUP INTERNAL EXAMINATION BY HOD*/
	function internal_makeup_register($sesn_id,$student_list,$course_id,$exam_id)
	{
		global $dbcon;
		$query = "INSERT INTO `makeup_registration` (`sesn_id`, `stud_id`, `course_id`, `exam_type`, `conf_flag`) VALUES ";
		$tuples = array();
		foreach ($student_list as $stud_id) {
			$tuples[] = "('$sesn_id', '$stud_id', '$course_id', '$exam_id', '1')";
		}
		$query = $query. implode(', ', $tuples);
		if($res = mysqli_query($dbcon,$query))
		{
			return "success";
		}
		else
			return "failed ";
	}

	function reval_marks_entry($stud_list,$course_id,$marks_list)
	{
		global $dbcon;
		$msg = '';
		$error_count = 0;
		$sesn_id = get_sesn_id();
		foreach ($stud_list as $stud_id) {
			$reval_marks = $marks_list[$stud_id];
			//echo "<br/>";
			$original_marks = get_original_ese_marks($stud_id,$course_id);
			// echo "<br/>";
			$ese_max_marks = get_th_ese_max_marks($course_id);
			// echo "<br/>";
			if(abs($reval_marks - $original_marks) >= 0.05*$ese_max_marks)
			{
				// echo "setting new value as final";
				// echo "<br/>";
				$final_reval_marks = $reval_marks;
			}
			else
			{
			//	echo $reval_marks;
				if($reval_marks >=  ($ese_max_marks / 3))
				{
					// echo "Change is less than 5%";
					// echo "<br/>";
					if(results_alter($stud_id,$course_id,$reval_marks,$original_marks))
					{
						$final_reval_marks = $reval_marks;
					}
					else
					{
						$final_reval_marks = $original_marks;
					}
				}
				else
				{
					$final_reval_marks = $original_marks;
				}
					
			}
			$query = "UPDATE `marks_th_ese` SET `reval_flag`='1',`reval_marks`='$reval_marks',`reval_final`='$final_reval_marks' WHERE `sesn_id` = '$sesn_id' AND `stud_id`= '$stud_id' AND `course_id` = '$course_id'";
			if($res = mysqli_query($dbcon,$query))
			{

			}
			else
			{
				$error_count ++ ;
			}

		}
		if($error_count != 0)
		{
			$msg = "Failed to update ".$error_count." records";
		}
		else
			$msg = "success";

		return $msg;

	}

	function get_original_ese_marks($stud_id,$course_id)
	{
		global $dbcon;
		$sesn_id = get_sesn_id();
		$query = "SELECT marks FROM marks_th_ese WHERE `sesn_id` = '$sesn_id' AND `stud_id` = '$stud_id' AND `course_id` = '$course_id'";
		if($res = mysqli_query($dbcon,$query))
		{
			if(mysqli_num_rows($res) > 0)
			{
				$row = mysqli_fetch_assoc($res);
				return $row['marks'];
			}
			else
				return false;
		}
		return false;
	}

	function get_th_ese_max_marks($course_id)
	{
		global $dbcon;
		$query = "SELECT `th_mks_scheme`.`ese` FROM `th_mks_scheme` WHERE `th_mks_scheme`.`sub_id` = '$course_id'";
		if($res = mysqli_query($dbcon,$query))
		{
			if(mysqli_num_rows($res) > 0)
			{
				$row = mysqli_fetch_assoc($res);
				return $row['ese'];
			}
			else
			{
				// echo mysqli_error($dbcon);
				// echo "<br/>";
				return false;
			}
		}
		return false;

	}

	function results_alter($stud_id,$course_id,$reval_marks,$original_marks)
	{
		global $dbcon;
		/*
		In this function check for the isa calcellation if after its module get ready!!
		*/
		/**/
		$sesn_id = get_old_sesn_id($stud_id,$course_id);
		/*get tha max'm marks for the subject */
		$max_marks = get_th_max_marks($course_id);
		$internal_marks_obt = get_ise1_marks($stud_id,$course_id,$sesn_id) + get_ise2_marks($stud_id,$course_id,$sesn_id) + get_isa_marks($stud_id,$course_id,$sesn_id);
		if( ( ($internal_marks_obt + $reval_marks) >= (0.4*$max_marks) ) && ( ($internal_marks_obt + $original_marks) < (0.4*$max_marks) ) )
		{
			return true;
		}
		else
			return false;

	}

	function get_old_sesn_id($stud_id,$course_id)
	{
		global $dbcon;
		$query = "SELECT `sesn_id` FROM `exam_registration` WHERE `stud_id` = '$stud_id' AND `course_id` = '$course_id' AND `regular_flag` = '1'  ORDER BY `sesn_id` ASC;";
		if ($res = mysqli_query($dbcon,$query)) {
			if(mysqli_num_rows($res) > 0){
				$row = mysqli_fetch_assoc($res);
				return $row['sesn_id'];
			}
			else
				return false;
		} else {
			return false;
		}
	}

	function get_ise1_marks($stud_id,$course_id,$sesn_id)
	{
		global $dbcon;	
		$query  = "SELECT `marks` FROM `marks_others` WHERE `sesn_id` = '$sesn_id' AND `stud_id` = '$stud_id' AND `course_id` = '$course_id' AND `exam_type` = '1'";
		if($res = mysqli_query($dbcon,$query))
		{
			if(mysqli_num_rows($res) == 1)
			{
				$row = mysqli_fetch_assoc($res);
				return $row['marks'];
			}
			else
			{
				return (0);
			}
		}
		else
		{
			die("failed due to some technical error..!!");
		}
	}

	function get_ise2_marks($stud_id,$course_id,$sesn_id)
	{
		global $dbcon;	
		$query  = "SELECT `marks` FROM `marks_others` WHERE `sesn_id` = '$sesn_id' AND `stud_id` = '$stud_id' AND `course_id` = '$course_id' AND `exam_type` = '2'";
		if($res = mysqli_query($dbcon,$query))
		{
			if(mysqli_num_rows($res) == 1)
			{
				$row = mysqli_fetch_assoc($res);
				return $row['marks'];
			}
			else
			{
				return (0);
			}
		}
		else
		{
			die("failed due to some technical error..!!");
		}
	}

	function get_isa_marks($stud_id,$course_id,$sesn_id)
	{
		global $dbcon;	
		$query  = "SELECT `marks` FROM `marks_others` WHERE `sesn_id` = '$sesn_id' AND `stud_id` = '$stud_id' AND `course_id` = '$course_id' AND `exam_type` = '3'";
		if($res = mysqli_query($dbcon,$query))
		{
			if(mysqli_num_rows($res) == 1)
			{
				$row = mysqli_fetch_assoc($res);
				return $row['marks'];
			}
			else
			{
				return (0);
			}
		}
		else
		{
			die("failed due to some technical error..!!");
		}
	}

	function get_th_max_marks($course_id)
	{
		global $dbcon;
		$query = "SELECT `isa`, `ise1`, `ise2`, `ese` FROM `th_mks_scheme` WHERE `sub_id` = '$course_id'";
		if($res = mysqli_query($dbcon,$query))
		{
			if(mysqli_num_rows($res) == 1)
			{
				$row = mysqli_fetch_assoc($res);
				$total_marks = $row['isa'] + $row['ise1'] + $row['ise2'] + $row['ese'];
				return $total_marks;	
			}
			else
			{
				die("INVALID CONDITIONS FOUND.. plz contcat admin..!");
			}
			
		}
		else
		{
			die("Failed due to some error.. :( ");
		}
	}


	function update_reval_marks($stud_id,$course_id,$marks)
	{
		global $dbcon;
		$sesn_id = get_sesn_id();
		$reval_marks = $marks;
		$original_marks = get_original_ese_marks($stud_id,$course_id);
		$ese_max_marks = get_th_ese_max_marks($course_id);
		if(abs($reval_marks - $original_marks) >= 0.05*$ese_max_marks)
		{
			$final_reval_marks = $reval_marks;
		}
		else
		{
			if($reval_marks >=  ($ese_max_marks / 3))
			{
				if(results_alter($stud_id,$course_id,$reval_marks,$original_marks))
				{
					$final_reval_marks = $reval_marks;
				}
				else
				{
					$final_reval_marks = $original_marks;
				}
			}
			else
			{
				$final_reval_marks = $original_marks;
			}
				
		}
		$query = "UPDATE `marks_th_ese` SET `reval_flag`='1',`reval_marks`='$reval_marks',`reval_final`='$final_reval_marks' WHERE `sesn_id` = '$sesn_id' AND `stud_id`= '$stud_id' AND `course_id` = '$course_id'";
		if($res = mysqli_query($dbcon,$query))
		{
			return "success";
		}
		else
		{
			return "Failed to update .. :( ". mysqli_error($dbcon);
		}
	}

	function sec_reval_marks_entry($stud_list,$course_id,$marks_list)
	{
		global $dbcon;
		$msg = '';
		$error_count = 0;
		$sesn_id = get_sesn_id();
		foreach ($stud_list as $stud_id) {
			$reval_marks = $marks_list[$stud_id];
			//echo "<br/>";
			$original_marks = get_original_ese_marks($stud_id,$course_id);
			// echo "<br/>";
			$ese_max_marks = get_th_ese_max_marks($course_id);
			// echo "<br/>";
			if(abs($reval_marks - $original_marks) >= 0.05*$ese_max_marks)
			{
				// echo "setting mew value as final";
				// echo "<br/>";
				$final_reval_marks = $reval_marks;
			}
			else
			{
				if($reval_marks >=  ($ese_max_marks / 3))
				{
					// echo "Change is less than 5%";
					// echo "<br/>";
					if(results_alter($stud_id,$course_id,$reval_marks,$original_marks))
					{
						$final_reval_marks = $reval_marks;
					}
					else
					{
						$final_reval_marks = $original_marks;
					}
				}
				else
				{
					$final_reval_marks = $original_marks;
				}
					
			}
			$query = "UPDATE `marks_th_ese` SET `sec_reval_flag`='1',`sec_reval_marks`='$reval_marks',`reval_final`='$final_reval_marks' WHERE `sesn_id` = '$sesn_id' AND `stud_id`= '$stud_id' AND `course_id` = '$course_id'";
			if($res = mysqli_query($dbcon,$query))
			{

			}
			else
			{
				$error_count ++ ;
			}

		}
		if($error_count != 0)
		{
			$msg = "Failed to update ".$error_count." records";
		}
		else
			$msg = "success";

		return $msg;
	}

	function update_sec_reval_marks($stud_id,$course_id,$marks)
	{
		global $dbcon;
		$sesn_id = get_sesn_id();
		$reval_marks = $marks;
		$original_marks = get_original_ese_marks($stud_id,$course_id);
		$ese_max_marks = get_th_ese_max_marks($course_id);
		if(abs($reval_marks - $original_marks) >= 0.05*$ese_max_marks)
		{
			$final_reval_marks = $reval_marks;
		}
		else
		{
			if($reval_marks >=  ($ese_max_marks / 3))
			{
				if(results_alter($stud_id,$course_id,$reval_marks,$original_marks))
				{
					$final_reval_marks = $reval_marks;
				}
				else
				{
					$final_reval_marks = $original_marks;
				}
			}
			else
			{
				$final_reval_marks = $original_marks;
			}
				
		}
		$query = "UPDATE `marks_th_ese` SET `sec_reval_flag`='1',`sec_reval_marks`='$reval_marks',`reval_final`='$final_reval_marks' WHERE `sesn_id` = '$sesn_id' AND `stud_id`= '$stud_id' AND `course_id` = '$course_id'";
		if($res = mysqli_query($dbcon,$query))
		{
			return "success";
		}
		else
		{
			return "Failed to update .. :( ". mysqli_error($dbcon);
		}	
	}

	function challenge_marks_entry($stud_list,$course_id,$marks_list)
	{
		global $dbcon;
		$msg = '';
		$error_count = 0;
		$sesn_id = get_sesn_id();
		foreach ($stud_list as $stud_id) 
		{
			$reval_marks = $marks_list[$stud_id];
			//echo "<br/>";
			$original_marks = get_original_reval_marks($stud_id,$course_id);
			// echo "<br/>";
			$ese_max_marks = get_th_ese_max_marks($course_id);
			// echo "<br/>";
			if(abs($reval_marks - $original_marks) >= 0.05*$ese_max_marks)
			{
				// echo "setting mew value as final";
				// echo "<br/>";
				$final_reval_marks = $reval_marks;
			}
			else
			{
				if($reval_marks >=  ($ese_max_marks / 3))
				{
					// echo "Change is less than 5%";
					// echo "<br/>";
					if(results_alter($stud_id,$course_id,$reval_marks,$original_marks))
					{
						$final_reval_marks = $reval_marks;
					}
					else
					{
						$final_reval_marks = $original_marks;
					}
				}
				else
				{
					$final_reval_marks = $original_marks;
				}
					
			}
			$query = "UPDATE `marks_th_ese` SET `challenge_flag`='1',`challenge_marks`='$reval_marks',`challenge_final`='$final_reval_marks' WHERE `sesn_id` = '$sesn_id' AND `stud_id`= '$stud_id' AND `course_id` = '$course_id'";
			if($res = mysqli_query($dbcon,$query))
			{

			}
			else
			{
				$error_count ++ ;
			}

		}
		if($error_count != 0)
		{
			$msg = "Failed to update ".$error_count." records";
		}
		else
			$msg = "success";

		return $msg;
	}

	function get_original_reval_marks($stud_id,$course_id)
	{
		global $dbcon;
		$sesn_id = get_sesn_id();
		$query = "SELECT reval_final FROM marks_th_ese WHERE `sesn_id` = '$sesn_id' AND `stud_id` = '$stud_id' AND `course_id` = '$course_id'";
		if($res = mysqli_query($dbcon,$query))
		{
			if(mysqli_num_rows($res) > 0)
			{
				$row = mysqli_fetch_assoc($res);
				return $row['reval_final'];
			}
			else
				return false;
		}
		return false;
	}

	function update_challenge_marks($stud_id,$course_id,$marks)
	{
		global $dbcon;
		$sesn_id = get_sesn_id();
		$reval_marks = $marks;
		$original_marks = get_original_reval_marks($stud_id,$course_id);
		$ese_max_marks = get_th_ese_max_marks($course_id);
		if(abs($reval_marks - $original_marks) >= 0.05*$ese_max_marks)
		{
			$final_reval_marks = $reval_marks;
		}
		else
		{
			if($reval_marks >=  ($ese_max_marks / 3))
			{
				if(results_alter($stud_id,$course_id,$reval_marks,$original_marks))
				{
					$final_reval_marks = $reval_marks;
				}
				else
				{
					$final_reval_marks = $original_marks;
				}
			}
			else
			{
				$final_reval_marks = $original_marks;
			}
				
		}
		$query = "UPDATE `marks_th_ese` SET `challenge_flag`='1',`challenge_marks`='$reval_marks',`challenge_final`='$final_reval_marks' WHERE `sesn_id` = '$sesn_id' AND `stud_id`= '$stud_id' AND `course_id` = '$course_id'";
		if($res = mysqli_query($dbcon,$query))
		{
			return "success";
		}
		else
		{
			return "Failed to update .. :( ". mysqli_error($dbcon);
		}
	}
	function get_ica_marks($stud_id,$course_id,$sesn_id)
	{
		global $dbcon;	
		$query  = "SELECT `marks` FROM `marks_others` WHERE `sesn_id` = '$sesn_id' AND `stud_id` = '$stud_id' AND `course_id` = '$course_id' AND `exam_type` = '4'";
		if($res = mysqli_query($dbcon,$query))
		{
			if(mysqli_num_rows($res) == 1)
			{
				$row = mysqli_fetch_assoc($res);
				return $row['marks'];
			}
			else
			{
				return (0);
			}
		}
		else
		{
			die("failed due to some technical error..!!");
		}
	}
?>