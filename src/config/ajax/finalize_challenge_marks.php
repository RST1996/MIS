<?php
	session_start();
	require_once "../dbconnect.php";
	require_once "../funlib/login_functions.php";
	require_once "../funlib/lock_management_function.php";
	require_once "../funlib/marks_entry_functions.php";
	
	if (isset($_POST['course']) && isset($_POST['exam']) && ( isLogin() != null)) {
		$course = $_POST['course'];
		$exam = $_POST['exam'];

		$query = "SELECT `student`.`id`,`student`.`prn`,`student`.`name`,`student`.`department`,`student`.`current_semester`,`marks_th_ese`.`reval_final`,`marks_th_ese`.`challenge_marks`,`marks_th_ese`.`challenge_final` FROM `student`,`course_assign`,`exam_registration`,`ses_conf`,`marks_th_ese` WHERE `student`.`status` = 'ONGOING' AND `course_assign`.`sub_id` = '$course' AND `course_assign`.`sem` = `student`.`current_semester` AND `course_assign`.`branch` = `student`.`department` AND exam_registration.stud_id = `student`.`id` AND `exam_registration`.`course_id` = `course_assign`.`sub_id` AND `exam_registration`.`sesn_id` = `ses_conf`.`current_session` AND `exam_registration`.`conform_status` = '1' AND `ses_conf`.`id` = '1' AND `marks_th_ese`.`sesn_id` = `ses_conf`.`current_session` AND `student`.`id` = `marks_th_ese`.`stud_id` AND `marks_th_ese`.`course_id` = '$course' AND `marks_th_ese`.`exam_type` = '$exam' AND `marks_th_ese`.`challenge_flag` = '1'";
			
		if($res = mysqli_query($dbcon,$query))
		{
			if(mysqli_num_rows($res) > 0)
			{
?>
							<table class="table table-bordered table-striped table-hover ">
                                <thead>
                                    <tr>
										<th>SR No</th>
										<th>PRN</th>
										<th>Name</th>
										<th>Reval Marks</th>
										<th>Challenge Marks</th>
										<th>Fianl Challenge Marks</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
										<th>SR No</th>
										<th>PRN</th>
										<th>Name</th>
										<th>Reval Marks</th>
										<th>Challenge Marks</th>
										<th>Fianl Challenge Marks</th>
                                    </tr>
                                </tfoot>
                                <tbody>
<?php
				$count = 1;
				while ($row = mysqli_fetch_assoc($res)) {
					$prn = $row['prn'];
					$name = $row['name'];
					
					$reval_marks = $row['reval_final'];
					$challenge_marks = $row['challenge_marks'];
					$challenge_final = $row['challenge_final'];
?>
									<tr>
										<td><?php echo $count++; ?></td>
										<td><?php echo $prn; ?></td>
										<td><?php echo $name; ?></td>
										<td><?php echo $reval_marks; ?></td>
										<td><?php echo $challenge_marks; ?></td>
										<td><?php echo $challenge_final; ?></td>
										
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
				echo "NO students found";
			}
		}
?>
							<div class="row clearfix">
										<div class="col-sm-4">
											<input type="button" onclick="show_list()" value="Back to edit" class="btn bg-teal waves-effect"/> 
										</div>
										<div class="col-sm-4">
											<input type="submit"  name="lock_marks" value="LOCK" class="btn bg-teal waves-effect"/> 
										</div>
							</div> 
<?php
	}
?>