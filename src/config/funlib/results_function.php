<?php
	function get_cgpa($stud_id,$sem,$dept,$sesn_id)
	{
		global $dbcon;
		$grade_points_weightage =  array('A+' => 10,'A' => 9,'B+' => 8,'B' => 7,'C+' => 6,'C' => 5, 'F' => 0,'Z' => 0,'I' => 0 );
		$sub_sel_query = "SELECT DISTINCT `exam_registration`.`course_id`,`course`.`credits` FROM `exam_registration`,`course_assign`,`course` WHERE `exam_registration`.`stud_id` = '$stud_id' AND `exam_registration`.`sesn_id` <= '$sesn_id' AND `exam_registration`.`regular_flag` = '1' AND `exam_registration`.`course_id` = `course_assign`.`sub_id` AND `exam_registration`.`reg_ac_yr` = `course_assign`.`ac_yr` AND `course_assign`.`branch` = '$dept' AND `course_assign`.`sem` <= '$sem' AND `course_assign`.`sub_id` = `course`.`id`";
		if($sub_sel_res = mysqli_query($dbcon,$sub_sel_query))
		{
			if(mysqli_num_rows($sub_sel_res) > 0)
			{
				$egp = 0;
				$total_credits = 0;
				while($sub_sel_row = mysqli_fetch_assoc($sub_sel_res))
				{
					$course_id = $sub_sel_row['course_id'];
					$credits = $sub_sel_row['credits'];
					$total_credits += $credits;
					$grade_sel_query = "SELECT 	`exam_registration`.`grade` FROM `exam_registration` WHERE `exam_registration`.`stud_id` = '$stud_id' AND `exam_registration`.`course_id` = '$course_id' AND `exam_registration`.`sesn_id` <= '$sesn_id' ORDER BY `sesn_id` DESC LIMIT 1";
					if($grade_sel_res = mysqli_query($dbcon,$grade_sel_query))
					{
						$grade_sel_row = mysqli_fetch_assoc($grade_sel_res);
						$grade = $grade_sel_row['grade'];
						$egp += $grade_points_weightage[$grade]*$credits;
					}
				}
				return round($egp/$total_credits,2);
			}
			else
				return "--";
		}
	}
?>