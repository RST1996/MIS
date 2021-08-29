<?php
	session_start();
	require_once "../dbconnect.php";
	require_once "../funlib/login_functions.php";
	require_once "../funlib/lock_management_function.php";
	require_once "../funlib/marks_entry_functions.php";
	
	if (isset($_POST['course']) && isset($_POST['exam']) && ( isLogin() != null)) {
		$course = $_POST['course'];
		$exam = $_POST['exam'];

		if($exam == 5)
		
			$query = "SELECT `student`.`id`,`student`.`prn`,`student`.`name`,`student`.`department`,`student`.`current_semester`,`marks_th_ese`.`marks`,`marks_th_ese`.`ne_flag`,`marks_th_ese`.`ab_flag` FROM `student`,`course_assign`,`exam_registration`,`ses_conf`,`marks_th_ese` WHERE `student`.`status` = 'ONGOING' AND `course_assign`.`sub_id` = '$course' AND `course_assign`.`sem` = `student`.`current_semester` AND `course_assign`.`branch` = `student`.`department` AND exam_registration.stud_id = `student`.`id` AND `exam_registration`.`course_id` = `course_assign`.`sub_id` AND `exam_registration`.`sesn_id` = `ses_conf`.`current_session` AND `exam_registration`.`conform_status` = '1' AND `ses_conf`.`id` = '1' AND `marks_th_ese`.`sesn_id` = `ses_conf`.`current_session` AND `student`.`id` = `marks_th_ese`.`stud_id` AND `marks_th_ese`.`course_id` = '$course' AND `marks_th_ese`.`exam_type` = '$exam';";
		else if($exam == 6)
			$query = "SELECT `student`.`id`,`student`.`prn`,`student`.`name`,`student`.`department`,`student`.`current_semester`,`marks_pr_ese`.`marks`,`marks_pr_ese`.`ne_flag`,`marks_pr_ese`.`ab_flag` FROM `student`,`course_assign`,`exam_registration`,`ses_conf`,`marks_pr_ese` WHERE `student`.`status` = 'ONGOING' AND `course_assign`.`sub_id` = '$course' AND `course_assign`.`sem` = `student`.`current_semester` AND `course_assign`.`branch` = `student`.`department` AND exam_registration.stud_id = `student`.`id` AND `exam_registration`.`course_id` = `course_assign`.`sub_id` AND `exam_registration`.`sesn_id` = `ses_conf`.`current_session` AND `exam_registration`.`conform_status` = '1' AND `ses_conf`.`id` = '1' AND `marks_pr_ese`.`sesn_id` = `ses_conf`.`current_session` AND `student`.`id` = `marks_pr_ese`.`stud_id` AND `marks_pr_ese`.`course_id` = '$course' AND `marks_pr_ese`.`exam_type` = '$exam';";
		if($res = mysqli_query($dbcon,$query))
		{
			if(mysqli_num_rows($res) > 0)
			{
?>
							<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
										<th>SR No</th>
										<th>PRN</th>
										<th>Name</th>
										<th>Marks</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
										<th>SR No</th>
										<th>PRN</th>
										<th>Name</th>
										<th>Marks</th>
                                    </tr>
                                </tfoot>
                                <tbody>
<?php
				$count = 1;
				while ($row = mysqli_fetch_assoc($res)) {
					$prn = $row['prn'];
					$name = $row['name'];
					$marks = $row['marks'];
					$ne_flag =$row['ne_flag'];
					$ab_flag = $row['ab_flag'];
?>
									<tr>
										<td><?php echo $count++; ?></td>
										<td><?php echo $prn; ?></td>
										<td><?php echo $name; ?></td>
										<td>
											<label>
<?php
					if($ne_flag == 1)
					{
						echo "Not Elligible";
					}
					else if($ab_flag == 1)
					{
						echo "Absent";
					}
					else
					{
						echo $marks;
					}
?>
											</label>
										</td>
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