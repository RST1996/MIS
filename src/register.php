<?php

	//require "config/dbconnect.php";
	//echo "Hello";
	/*$count = 0;
	for($i=205;$i<=538;$i++)
	{
		$query = "SELECT course.id, course.course_code, course.course_name, course.credits,course_type.name FROM student,course_assign, course LEFT JOIN course_type ON course.course_type_id = course_type.id WHERE course.id = course_assign.sub_id AND course_assign.sem = student.current_semester AND course_assign.branch = student.department AND student.id = '$i'";
		if($res = mysqli_query($dbcon,$query))
		{
			while($row = mysqli_fetch_assoc($res))
			{
				$course_id = $row['id'];
				$ins_query = "INSERT INTO `exam_registration` (`sesn_id`, `stud_id`, `course_id`, `regular_flag`, `result_flag`, `conform_status`) VALUES ('1', '$i', '$course_id', '1', '0', '1')";
				if($r = mysqli_query($dbcon,$ins_query))
				{
					$count ++;
				}
			}
		}
	}
	echo $count." student registered";
	
	*/
	/*$count = 0;
	for($i = 442 ; $i < 490 ; $i ++)
	{
		$query = "DELETE FROM marks_th_ese WHERE `course_id` = '25' AND `stud_id` = '$i' LIMIT 1";
		if($res = mysqli_query($dbcon,$query))
		{
			$count ++;
		}
		else
		{
			echo mysqli_error($dbcon);
		}
		//echo "<br/>";
	}
	echo $count." rows deleted";*/

	/*$max_time = ini_get("max_execution_time");
	echo $max_time*/
?>