<?php
	function assign_class_teacher($year,$department,$teacher)
	{
		global $dbcon;
		$check = check_class_teacher_assignment($year,$department);
		if($check == "vacant")
		{
			$query = "INSERT INTO `class_teacher` (`branch`, `year`, `class_teacher_id`) VALUES ('$department', '$year', '$teacher')";
			if ($res = mysqli_query($dbcon,$query)) {
				return "success";
			}
			else
			{
				return mysqli_error($dbcon);
			}	
		}
		else if($check == false){
			return "Something went wrong.. try again later..!!";
		}
		else
		{
			return "Already assigned a class teacher!! If you need to update plz use manage class teacher ";
		}
		
	}
	function check_class_teacher_assignment($year,$department)
	{
		global $dbcon;
		$query = "SELECT `branch`,`year` FROM `class_teacher` WHERE `branch`='$department' AND `year`='$year'";
		if ($res = mysqli_query($dbcon,$query)) {
			if (mysqli_num_rows($res) == 0) {
				return "vacant";
			} else {
				return "not vacant";
			}
			
		} else {
			return false;
		}
		

	}

	function update_class_teacher($year,$department,$teacher)
	{
		global $dbcon;
		$query = "UPDATE `class_teacher` SET `class_teacher_id`= '$teacher' WHERE `branch` = '$department' AND `year` = '$year';";
		if ($res = mysqli_query($dbcon,$query)) {
			return;
		}
		else
		{
			echo mysqli_error($dbcon);
		}
	}
?>