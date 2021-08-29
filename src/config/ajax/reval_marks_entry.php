<?php
	session_start();
	require_once "../dbconnect.php";
	require_once "../funlib/login_functions.php";
	require_once "../funlib/marks_entry_functions.php";
	
	require_once "../funlib/lock_management_function.php";
	if (isset($_POST['dept']) && isset($_POST['course']) && isset($_POST['exam_id']) && ( isLogin() != null))
	{
		$dept = $_POST['dept'];
		$course = $_POST['course'];
		$exam_id = $_POST['exam_id'];
		$sesn_id = get_sesn_id();
		if(check_ese_reval_marks_lock($sesn_id,$course,$dept,$exam_id))
		{
			echo "<h4>Marks Are Locked.</h4>";
			?>
			<div class="row clearfix" align="center">
				<div class="col-sm-4">
					<input type="button"  name="generate_marks" value="Generate Report(R05)" onclick="window.location.href='../formats/r5.php?course_id=<?php echo $course ?>'" class="btn bg-deep-purple waves-effect"/> 
				</div>
			</div> 
			<?php
		}
		else
		{
			$stud_temp_query = "SELECT `student`.`id` FROM `student`,`makeup_registration`,`marks_th_ese` WHERE `makeup_registration`.`sesn_id`='$sesn_id' AND `makeup_registration`.`sesn_id` = `marks_th_ese`.`sesn_id` AND `makeup_registration`.`stud_id` = `student`.`id` AND `marks_th_ese`.`stud_id` = `makeup_registration`.`stud_id` AND `makeup_registration`.`course_id` = `marks_th_ese`.`course_id` AND `makeup_registration`.`course_id` = '$course' AND `makeup_registration`.`conf_flag` = '1' AND `marks_th_ese`.`reval_flag` = '1' AND `marks_th_ese`.`reval_marks` <> '-1' AND `student`.`department` = '$dept' AND `makeup_registration`.`exam_type` = '$exam_id' LIMIT 1 ";
			if ($r = mysqli_query($dbcon,$stud_temp_query)) 
			{
				if(mysqli_num_rows($r) != 0)
				{
					require_once "../includes/reval_marks_edit_form.inc.php";
				}
				else
				{
					require_once "../includes/reval_marks_entry_form.inc.php";
				}

			} 
			else 
			{
				die("failed to access resources.. contact admin..!");
			}
		}
	}
?>