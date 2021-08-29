<?php
function update_course_teacher($course,$department,$teacher)
	{
		global $dbcon;
		$query = "UPDATE `course_teacher` SET `staff_id`= '$teacher' WHERE `branch` = '$department' AND `sub_id` = '$course';";
		if ($res = mysqli_query($dbcon,$query)) {
			return;
		}
		else
		{
			echo mysqli_error($dbcon);
		}
	}
	function update_course_coordinator($year,$department,$teacher)
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
