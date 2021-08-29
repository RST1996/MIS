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

		if(check_sec_reval_marks_lock($sesn_id,$course,$dept,$exam_id))
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
			$course_info = "SELECT `th_mks_scheme`.`ese` FROM `th_mks_scheme` WHERE `th_mks_scheme`.`sub_id` = '$course' ";
			if($info_res = mysqli_query($dbcon,$course_info))
			{
				if(mysqli_num_rows($info_res) == 1)
				{
					$r = mysqli_fetch_assoc($info_res);
					$max_marks = $r['ese'];
				}
			}
			$recheck_limit = 0.2*$max_marks;

			$stud_temp_query = "SELECT `student`.`id` FROM `student`,`reval_registration`,`marks_th_ese` WHERE `reval_registration`.`sesn_id`='$sesn_id' AND `reval_registration`.`sesn_id` = `marks_th_ese`.`sesn_id` AND `reval_registration`.`stud_id` = `student`.`id` AND `marks_th_ese`.`stud_id` = `reval_registration`.`stud_id` AND `reval_registration`.`course_id` = `marks_th_ese`.`course_id` AND `reval_registration`.`course_id` = '$course' AND `reval_registration`.`conf_flag` = '1' AND `marks_th_ese`.`reval_flag` = '1' AND `marks_th_ese`.`reval_marks` <> '-1' AND `student`.`department` = '$dept' AND `reval_registration`.`exam_type` = '$exam_id' AND `reval_registration`.`exam_type` = '5' AND `marks_th_ese`.`sec_reval_flag` = '1' AND `marks_th_ese`.`sec_reval_marks` <> '-1' AND ABS(`marks_th_ese`.`marks` - `marks_th_ese`.`reval_marks`) >= $recheck_limit LIMIT 1 ";
			//echo "<br/>";
			if ($r = mysqli_query($dbcon,$stud_temp_query)) 
			{
				if(mysqli_num_rows($r) != 0)
				{
					require_once "../includes/second_reval_marks_edit_form.inc.php";
				}
				else
				{
					require_once "../includes/second_reval_marks_entry_form.inc.php";
				}

			} 
			else 
			{
				die("failed to access resources.. contact admin..!");
			}

		}
	}
?>