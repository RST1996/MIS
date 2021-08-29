<?php
	session_start();
	require_once "../dbconnect.php";
	require_once "../funlib/login_functions.php";
	require_once "../funlib/lock_management_function.php";
	require_once "../funlib/marks_entry_functions.php";
	
	if (isset($_POST['course']) && isset($_POST['exam'] ) && ( isLogin() != null)) {
		$sesn_id = get_sesn_id();
		$course = $_POST['course'];
		$exam = $_POST['exam'];
		$department = $_POST['department'];
		if(check_ese_marks_lock($sesn_id,$course,$department,$exam))
		{
			echo "<h4>Marks Are Locked.</h4>";
			if($exam == 5)
			{
			?>
			<div class="row clearfix" align="center">
				<div class="col-sm-4">
					<input type="button"  name="generate_marks" value="Generate Report(R05)" onclick="window.location.href='../formats/R05.php?id=<?php $no = rand(1000,2000); $_SESSION['sec_access_code'] = $no; echo base64_encode($no); ?>&course=<?php echo $course ?>&department=<?php echo $department?>'" class="btn bg-deep-purple waves-effect"/> 
				</div>
			</div> 
			<?php
			}
			else if($exam == 6)
			{
				?>
				<div class="row clearfix" align="center">
					<div class="col-sm-4">
						<input type="button"  name="generate_marks" value="Generate Report(R06)" onclick="window.location.href='../formats/R06.php?id=<?php $no = rand(1000,2000); $_SESSION['sec_access_code'] = $no; echo base64_encode($no); ?>&course=<?php echo $course ?>&department=<?php echo $department?>'" class="btn bg-deep-purple waves-effect"/> 
					</div>
				</div> 
				<?php
			}
			else
			{
				?>
				<script type="text/javascript">
					swal("Failed!","Unable to generate reports....","error");
					
				</script>
			<?php
			}
		}
		else
		{
			$stud_temp_query = "SELECT `student`.`id` FROM `student`,`course_assign`,`exam_registration`,`ses_conf` WHERE `student`.`status` = 'ONGOING' AND `course_assign`.`sub_id` = '$course'  AND `student`.`department`='$department' AND `course_assign`.`branch` = `student`.`department` AND exam_registration.stud_id = `student`.`id` AND `exam_registration`.`course_id` = `course_assign`.`sub_id` AND `exam_registration`.`sesn_id` = `ses_conf`.`current_session` AND `exam_registration`.`conform_status` = '1' AND `ses_conf`.`id` = '1' LIMIT 1 ";

		
			if ($r = mysqli_query($dbcon,$stud_temp_query)) 
			{
				
				if(mysqli_num_rows($r) != 0)
				{
					$res_row = mysqli_fetch_assoc($r);
					//print_r($res_row);
					
					$test_stud = $res_row['id'];
					if (check_ese_marks_entry($test_stud,$course,$exam)) {
						echo "Marks has already been filled .";
						require_once "../includes/ese_marks_edit_form.inc.php";
						require_once "../includes/ese_back_marks_edit_form.inc.php";
						
					}
					else
					{
						require_once "../includes/ese_marks_entry_form.inc.php";
						require_once "../includes/ese_back_marks_entry_form.inc.php";
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
