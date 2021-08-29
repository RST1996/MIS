<?php
	session_start();
	require_once "../dbconnect.php";
	require_once "../funlib/login_functions.php";
	require_once "../funlib/lock_management_function.php";
	require_once "../funlib/marks_entry_functions.php";
	
	if (isset($_POST['course']) && isset($_POST['exam']) && ( isLogin() != null)) {
		$sesn_id = get_sesn_id();
		$course = $_POST['course'];
		$exam = $_POST['exam'];
		if(check_internal_marks_lock($sesn_id,$course,$exam))
		{
			echo "<h4>Marks Are Locked.</h4>";
			
			require_once "generate_report.php";
			?>
			
			<?php
		}
		else
		{
		$stud_temp_query = "SELECT `student`.`id` FROM `student`,`course_assign`,`exam_registration`,`ses_conf` WHERE `student`.`status` = 'ONGOING' AND `course_assign`.`sub_id` = '$course' AND `course_assign`.`sem` = `student`.`current_semester` AND `course_assign`.`branch` = `student`.`department` AND exam_registration.stud_id = `student`.`id` AND `exam_registration`.`course_id` = `course_assign`.`sub_id` AND `exam_registration`.`sesn_id` = `ses_conf`.`current_session` AND `exam_registration`.`conform_status` = '1' AND `ses_conf`.`id` = '1' LIMIT 1 ";
		if ($r = mysqli_query($dbcon,$stud_temp_query)) 
		{
			if(mysqli_num_rows($r) != 0)
			{
				$res_row = mysqli_fetch_assoc($r);
				$test_stud = $res_row['id'];
				if (check_marks_entry($test_stud,$course,$exam)) {
					echo "Marks has already been filled .";
					require_once "../includes/marks_edit_form.inc.php";
				}
				else
				{
					require_once "../includes/marks_entry_form.inc.php";
				}
			}
			else
			{
				die("No students are assigned to this course..!");
			}

		} 
		else 
		{
			die("failed to access resources.. contact admin..!");
		}
		
		}
		
	}	
?>
