<?php
	session_start();
	require_once "../dbconnect.php";
	require_once "../funlib/login_functions.php";
	require_once "../funlib/results_function.php";
	if (isset($_POST['sesn_id']) && isset($_POST['sem']) && isset($_POST['dept']) && ( isLogin() != null))
	{
		$sesn_id = $_POST['sesn_id'];
		$sem = $_POST['sem'];
		$dept = $_POST['dept'];
		$grade_points_weightage =  array('A+' => 10,'A' => 9,'B+' => 8,'B' => 7,'C+' => 6,'C' => 5, 'F' => 0,'Z' => 0,'I' => 0 );

		/***** SELECTING THE SET OF THE SUBJECTS AC_YR WISE FOR THE RESPECTIVE SEM AND DEPT******/
		$course_sel_query = "SELECT `course_assign`.`ac_yr`,`course_assign`.`sub_id` FROM `course_assign` WHERE `course_assign`.`branch`='$dept' AND `course_assign`.`sem` = '$sem' AND `course_assign`.`ac_yr` IN (SELECT DISTINCT `exam_registration`.`reg_ac_yr`FROM `exam_registration`,`student`,`course_assign` WHERE `exam_registration`.`sesn_id` = '$sesn_id' AND `exam_registration`.`course_id` = `course_assign`.`sub_id` AND `exam_registration`.`reg_ac_yr` = `course_assign`.`ac_yr` AND `exam_registration`.`stud_id` = `student`.`id` AND `student`.`department` = '1' AND `course_assign`.`branch` = '1' AND `exam_registration`.`conform_status` = '1' ) ORDER BY `course_assign`.`ac_yr` DESC, `course_assign`.`sub_id` ASC  ";
		if($course_sel_res = mysqli_query($dbcon,$course_sel_query))
		{
			$ac_yr_ptr = "";
			$course_array = Array();
			if(mysqli_num_rows($course_sel_res) > 0)
			{
				while($course_sel_row = mysqli_fetch_assoc($course_sel_res))
				{
					if($ac_yr_ptr == $course_sel_row['ac_yr'])
					{
						$course_array[$ac_yr_ptr][] = $course_sel_row['sub_id'];
					}
					else
					{
						$ac_yr_ptr = $course_sel_row['ac_yr'];
						$course_array[$ac_yr_ptr] = Array();
						$course_array[$ac_yr_ptr][] = $course_sel_row['sub_id'];

					}
				}
			}
			else
			{
				die("No cources found!!");
			}
			//print_r($course_array);
			// $distinct_course_set = Array();
			// foreach ($course_array as $acyr => $course_set)
			// {
			// 	if(!in_array($course_set, $distinct_course_set))
			// 	{
			// 		$distinct_course_set[] = $course_set;
			// 	}
			// }
			// echo "<br/>";
			// print_r($distinct_course_set);
			//echo "<br/>";
			foreach ($course_array as $ac_yr => $cources) 
			{
				//$ac_yr_set  = array_keys($course_array,$cources );
				//print_r($ac_yr_set);

				$sub_set = "(".implode(",", $cources).")";
				//echo $sub_set;
				$student_sel_query = "SELECT DISTINCT `exam_registration`.`stud_id`,`student`.`prn`,`student`.`name` FROM `exam_registration`,`student` WHERE `exam_registration`.`sesn_id` = '$sesn_id' AND `exam_registration`.`stud_id` = `student`.`id` AND `student`.`department` = '$dept' AND `exam_registration`.`course_id` IN $sub_set AND `exam_registration`.`reg_ac_yr` = '$ac_yr' AND `exam_registration`.`conform_status` = '1' ORDER BY `student`.`prn` ASC";
				if($student_sel_res = mysqli_query($dbcon,$student_sel_query))
				{
					if(mysqli_num_rows($student_sel_res) > 0)
					{
?>	
	<table class="table table-responsive table-bordered table-striped table-hover js-basic-example dataTable">
		<tbody>
			<th>Sr.No.</th>
			<th>PRN</th>
			<th>Name</th>
<?php
						$couse_credit_array = Array();
						foreach($cources as $course_id)
						{
							$course_info_query = "SELECT `course`.`course_code`,`course`.`credits` FROM `course` WHERE `course`.`id` = '$course_id'";
							if($course_info_res = mysqli_query($dbcon,$course_info_query))
							{
								$course_info_row = mysqli_fetch_assoc($course_info_res);
								$course_code = $course_info_row['course_code'];
								$credits = $course_info_row['credits'];
								$course_credit_array[$course_id] = $credits;
?>
			<th>
				<?php echo $course_code; ?><br/>
				(<?php echo $credits; ?>)
			</th>

<?php
							} 
						}

?>
			<th>SGPA</th>
			<th>CGPA</th>
		</tbody>
		<tfoot>
			<th>Sr. No.</th>
			<th>PRN</th>
			<th>Name</th>
<?php
						foreach($cources as $course_id)
						{
							$course_info_query = "SELECT `course`.`course_code`,`course`.`credits` FROM `course` WHERE `course`.`id` = '$course_id'";
							if($course_info_res = mysqli_query($dbcon,$course_info_query))
							{
								$course_info_row = mysqli_fetch_assoc($course_info_res);
								$course_code = $course_info_row['course_code'];
								$credits = $course_info_row['credits'];

?>
			<th>
				<?php echo $course_code; ?><br/>
				(<?php echo $credits; ?>)
			</th>

<?php
							} 
						}

?>
			<th>SGPA</th>
			<th>CGPA</th>
		</tfoot>
		<tbody>
<?php
						$sr_no = 1;
						while($student_sel_row = mysqli_fetch_assoc($student_sel_res) )
						{
							/******************** IN UPCOMING MODULES CHECK HERE IF THE STUDENT HAS APPLIED FOR THE SUBJECT UNDER THIS SET  OR NOT ***********************/
							$stud_id = $student_sel_row['stud_id'];
							$prn = $student_sel_row['prn'];
							$name = $student_sel_row['name'];
?>
			<tr>
				<td><?php echo $sr_no ++; ?></td>
				<td><?php echo $prn; ?></td>
				<td><?php echo $name ?></td>	
<?php
							$egp = 0;
							foreach($cources as $course_id)
							{
								/*find the latest grades of the student in this subject*/
								$grade_sel_query = "SELECT 	`exam_registration`.`grade` FROM `exam_registration` WHERE `exam_registration`.`stud_id` = '$stud_id' AND `exam_registration`.`course_id` = '$course_id' AND `exam_registration`.`sesn_id` <= '$sesn_id' ORDER BY `sesn_id` DESC LIMIT 1";
								if($grade_sel_res = mysqli_query($dbcon,$grade_sel_query))
								{
									$grade_sel_row = mysqli_fetch_assoc($grade_sel_res);
									$grade = $grade_sel_row['grade'];
									$egp += $grade_points_weightage[$grade]*$course_credit_array[$course_id];
?>
				<td><?php echo $grade; ?></td>
<?php
								}
							}
							$total_credit = 0;
							foreach ($course_credit_array as $course_id => $credit) {
								$total_credit += $credit;
							}
?>
				<td><?php echo round($egp/$total_credit,2) ?></td>
				<td><?php echo get_cgpa($stud_id,$sem,$dept,$sesn_id); ?></td>
			</tr>
<?php
						}
?>
		</tbody>
	</table>
<?php
					}
					else
					{
						echo "No students found..!!";
					}
				}
			}
		}
	}
?>