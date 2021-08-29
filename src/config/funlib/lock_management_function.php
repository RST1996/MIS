<?php
	function lock_ne_list($sesn_id,$course_id,$exam_type)
	{
		global $dbcon;
		$user_id = $_SESSION['user_uid'];
		$query = "INSERT INTO `ne_lock` (`sesn_id`, `course_id`, `exam_type`,`locked_by`) VALUES ('$sesn_id', '$course_id', '$exam_type','$user_id')";
		if($res = mysqli_query($dbcon,$query))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function lock_internal_marks($sesn_id,$course_id,$exam_type)
	{
		global $dbcon;
		$user_id = $_SESSION['user_uid'];
		$query = "INSERT INTO `internal_marks_lock` (`sesn_id`, `course_id`, `exam_type`,`locked_by`) VALUES ('$sesn_id', '$course_id', '$exam_type','$user_id')";
		if($res = mysqli_query($dbcon,$query))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function lock_ese_marks($sesn_id,$course_id,$dept,$exam_type)
	{
		global $dbcon;
		$user_id = $_SESSION['user_uid'];
		$query = "INSERT INTO `ese_marks_lock` (`sesn_id`, `branch`, `course_id`, `exam_type`, `reval_lock`, `sec_reval_lock`, `pc_reval_lock`,`locked_by`) VALUES ('$sesn_id', '$dept', '$course_id', '$exam_type', '0', '0', '0','$user_id')";
		if($res = mysqli_query($dbcon,$query))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function lock_ese_reval_marks($sesn_id,$course_id,$dept,$exam_type)
	{
		global $dbcon;
		$query = "UPDATE `ese_marks_lock` SET `reval_lock`='1' WHERE `sesn_id`='$sesn_id' AND `branch`='$dept' AND `course_id`='$course_id' AND `exam_type`='$exam_type'";
		if($res = mysqli_query($dbcon,$query))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function lock_ese_sec_reval_marks($sesn_id,$course_id,$dept,$exam_type)
	{
		global $dbcon;
		$query = "UPDATE `ese_marks_lock` SET `sec_reval_lock`='1' WHERE `sesn_id`='$sesn_id' AND `branch`='$dept' AND `course_id`='$course_id' AND `exam_type`='$exam_type' AND `reval_lock`='1'";
		if($res = mysqli_query($dbcon,$query))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function lock_pc_reval_marks($sesn_id,$course_id,$dept,$exam_type)
	{
		global $dbcon;
		$query = "UPDATE `ese_marks_lock` SET `pc_reval_lock`='1' WHERE `sesn_id`='$sesn_id' AND `branch`='$dept' AND `course_id`='$course_id' AND `exam_type`='$exam_type' AND `reval_lock`='1'";
		if($res = mysqli_query($dbcon,$query))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	function  check_ne_lock($sesn_id,$course_id,$exam_type)
	{
		global $dbcon;
		$query = "SELECT `locked_by` FROM `ne_lock` WHERE `sesn_id`= '$sesn_id' AND `course_id` = '$course_id' AND `exam_type`='$exam_type'";
		if($res = mysqli_query($dbcon,$query))
		{
			if(mysqli_num_rows($res) == 1)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	function check_internal_marks_lock($sesn_id,$course_id,$exam_type)
	{
		global $dbcon;
		$query = "SELECT `locked_by` FROM `internal_marks_lock` WHERE `sesn_id`= '$sesn_id' AND `course_id` = '$course_id' AND `exam_type`='$exam_type'";
		if($res = mysqli_query($dbcon,$query))
		{
			if(mysqli_num_rows($res) == 1)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	function check_ese_marks_lock($sesn_id,$course_id,$dept,$exam_type)
	{
		global $dbcon;
		$query = "SELECT `locked_by` FROM `ese_marks_lock` WHERE `sesn_id`='$sesn_id' AND `branch`='$dept' AND `course_id`='$course_id' AND `exam_type`='$exam_type'";
		if($res = mysqli_query($dbcon,$query))
		{
			if(mysqli_num_rows($res) == 1)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	function check_ese_reval_marks_lock($sesn_id,$course_id,$dept,$exam_type)
	{
		global $dbcon;
		$query = "SELECT `locked_by` FROM `ese_marks_lock` WHERE `sesn_id`='$sesn_id' AND `branch`='$dept' AND `course_id`='$course_id' AND `exam_type`='$exam_type' AND `reval_lock`='1'";
		if($res = mysqli_query($dbcon,$query))
		{
			if(mysqli_num_rows($res) == 1)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	function check_sec_reval_marks_lock($sesn_id,$course_id,$dept,$exam_type)
	{
		global $dbcon;
		$query = "SELECT `locked_by` FROM `ese_marks_lock` WHERE `sesn_id`='$sesn_id' AND `branch`='$dept' AND `course_id`='$course_id' AND `exam_type`='$exam_type' AND `reval_lock`='1' AND `sec_reval_lock`='1'";
		if($res = mysqli_query($dbcon,$query))
		{
			if(mysqli_num_rows($res) == 1)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}	
	}

	function check_pc_reval_marks_lock($sesn_id,$course_id,$dept,$exam_type)
	{
		global $dbcon;
		$query = "SELECT `locked_by` FROM `ese_marks_lock` WHERE `sesn_id`='$sesn_id' AND `branch`='$dept' AND `course_id`='$course_id' AND `exam_type`='$exam_type' AND `pc_reval_lock`='1'";
		if($res = mysqli_query($dbcon,$query))
		{
			if(mysqli_num_rows($res) == 1)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}	
	}
?>