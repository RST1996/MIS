<?php
	function get_course_type($course_id)
	{
		global $dbcon;
		$query = "select `course`.`course_type_id` FROM `course` WHERE `course`.`id` = '$course_id'";
		if($res = mysqli_query($dbcon,$query))
		{
			if(mysqli_num_rows($res)  == 1)
			{
				$row = mysqli_fetch_assoc($res);
				return $row['course_type_id'];
			}
			else
			{
				return "INVALID RESULTS...";
			}
		}
		else
		{
			return "something went wrong .. ".mysqli_error($dbcon);
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

	function get_ese_max_marks($course_id)
	{
		global $dbcon;
		$course_type = get_course_type($course_id);
		if($course_type == 1)
		{
			$query = "SELECT `ese` FROM `th_mks_scheme` WHERE `sub_id` = '$course_id'";
			if($res = mysqli_query($dbcon,$query))
			{
				if(mysqli_num_rows($res) == 1)
				{
					$row = mysqli_fetch_assoc($res);
					return $row['ese'];
				}
			}
		}
		elseif($course_type == 2)
		{
			$query = "SELECT `ese` FROM `pr_mks_scheme` WHERE `sub_id` = '$course_id'";
			if($res = mysqli_query($dbcon,$query))
			{
				if(mysqli_num_rows($res) == 1)
				{
					$row = mysqli_fetch_assoc($res);
					return $row['ese'];
				}
			}
		}
		else
		{
			echo "Invalid Results.. plz  contact admin";
		}
	}

	function get_max_marks($course_id)
	{
		global $dbcon;
		$course_type = get_course_type($course_id);
		switch ($course_type) {
			case '1':
				return get_th_max_marks($course_id);
				break;
			case '2':
				return get_pr_max_marks($course_id);
				break;
			
			default:
				die("INVALID RESULTS .. plz contact admin");
				break;
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

	function get_pr_max_marks($course_id)
	{
		global $dbcon;
		$query = "SELECT  `ica`, `ese` FROM `pr_mks_scheme` WHERE `sub_id` = '$course_id'";
		if($res = mysqli_query($dbcon,$query))
		{
			if(mysqli_num_rows($res) == 1)
			{
				$row = mysqli_fetch_assoc($res);
				$total_marks = $row['ica'] + $row['ese'];
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
	function get_total_marks_obtained($stud_id,$course_id)
	{
		global $dbcon;
		$sesn_id = get_sesn_id();
		$course_type = get_course_type($course_id);
		if($course_type == 1)
		{
			return $total_marks_obtained = get_ise1_marks($stud_id,$course_id,$sesn_id) + get_ise2_marks($stud_id,$course_id,$sesn_id) + get_isa_marks($stud_id,$course_id,$sesn_id) + get_ese_th_marks($stud_id,$course_id,$sesn_id);
		}	
		else if( $course_type == 2 )
		{
			return $total_marks_obtained = get_ica_marks($stud_id,$course_id,$sesn_id) + get_ese_pr_marks($stud_id,$course_id,$sesn_id);
		}
		else
		{
			die("Invalid course data.. plz report to admin..");
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

	function get_ese_th_marks($stud_id,$course_id,$sesn_id)
	{
		global $dbcon;
		$query = "SELECT * FROM `marks_th_ese` WHERE `sesn_id` = '$sesn_id' AND `stud_id` = '$stud_id' AND `course_id` = '$course_id'";
		if($res = mysqli_query($dbcon,$query))
		{
			if(mysqli_num_rows($res) == 1)
			{
				$row = mysqli_fetch_assoc($res);
				if ($row['challenge_flag'] == 1) 
				{
					return $row['challenge_final'];
				} 
				else if($row['reval_flag'] == 1) 
				{
					return $row['reval_final'];
				}
				else
				{
					return $row['marks'];
				}
				
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

	function get_ese_pr_marks($stud_id,$course_id,$sesn_id)
	{
		global $dbcon;
		$query = "SELECT  `marks` FROM `marks_pr_ese` WHERE `sesn_id` = '$sesn_id' AND `stud_id` = '$stud_id' AND course_id = '$course_id'";
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

	function get_limit($marks,$count,$max_marks)
	{
		//print_r($marks);
		rsort($marks);
		//$max_marks = 100;
		$cut_off = round($max_marks * 0.8);
		$threshold = round($max_marks * 0.7);
		$max_allowed = round($count / 10);
		/*echo "Top 10% : <br/>";
		for ($i=0; $i < $max_allowed ; $i++) { 
			echo $marks[$i]."<br/>";
		}
		echo "Next: ".$marks[$max_allowed]."<br/>";*/

		/**************************/

		if($marks[$max_allowed] == $marks[$max_allowed - 1])
		{
			if($marks[$max_allowed] >= $cut_off)
			{
				$limit = $marks[$max_allowed];
			}
			else if($marks[0] >= $cut_off)
			{
				$limit = $cut_off - 1;
			}
			else if($marks[0] > $threshold)
			{
				$limit = $marks[0];
			}
			else
			{
				$limit = $threshold;		
			}
		}
		else
		{
			if($marks[$max_allowed-1] >= $cut_off)
			{
				$limit = $marks[$max_allowed-1] -1;
			}
			else if($marks[0] >= $cut_off)
			{
				$limit = $cut_off - 1;
			}
			else if($marks[0] > $threshold)
			{
				$limit = $marks[0];
			}
			else
			{
				$limit = $threshold;		
			}
		}
		return $limit;

		/**************************/

		

	}

	function get_total_marks_obtained_back($stud_id,$course_id)
	{
		global $dbcon;
		$sesn_id = get_sesn_id();
		$prev_sesnid = get_old_sesn_id($stud_id,$course_id);
		$course_type = get_course_type($course_id);

		if($course_type == 1)
		{
			return $total_marks_obtained = get_ise1_marks($stud_id,$course_id,$prev_sesnid) + get_ise2_marks($stud_id,$course_id,$prev_sesnid) + get_isa_marks($stud_id,$course_id,$prev_sesnid) + get_ese_th_marks($stud_id,$course_id,$sesn_id);
		}	
		else if( $course_type == 2 )
		{
			return $total_marks_obtained = get_ica_marks($stud_id,$course_id,$prev_sesnid) + get_ese_pr_marks($stud_id,$course_id,$sesn_id);
		}
		else
		{
			die("Invalid course data.. plz report to admin..");
		}
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


	function is_internal_cancel($sesn_id,$stud_id,$course_id)
	{
		global $dbcon;
		$query = "SELECT `sesn_id` FROM `internal_cancellation` WHERE `stud_id`='$stud_id' AND `course_id`='$course_id' AND `conf_flag`= '1'";
		if($res = mysqli_query($dbcon,$query))
		{	
			if(mysqli_num_rows($res) == 1)
			{
				$row = mysqli_fetch_assoc($res);
				if($sesn_id >= $row['sesn_id'])
					return true;
				else
					return false;
			}
			else
				return false;
		}
		else
		{
			return false;
		}
	}

	function copycase($sesn_id,$course_id,$stud_id,$exam_type)
	{
		global $dbcon;
		$query = "SELECT * FROM `copy_case` WHERE `sesn_id` = '$sesn_id' AND `stud_id` = '$stud_id' AND `course_id` = '$course_id' AND `exam_type` = '$exam_type'";
		if($res = mysqli_query($dbcon,$query))
		{
			if(mysqli_num_rows($res) == 1)
				return true;
			else
				return false;
		}
		return false;
	}

	function get_course_credit($course_id)
	{
		global $dbcon;
		$query = "SELECT credits FROM course WHERE id = 'course_id'";
		if($res = mysqli_query($dbcon,$query))
		{
			if(mysqli_num_rows($res) == 1)
			{
				$row = mysqli_fetch_assoc($res);
				return $row['credits'];
			}
			else
				return "Failed";
		}
		else
			return "Failed";
	}
?>