<?php
	session_start();
	require_once "../dbconnect.php";
	require_once "../funlib/login_functions.php";
	//require_once "../funlib/not_elligible_functions.php";
	require_once "../funlib/marks_entry_functions.php";
	
	if (isset($_POST['course']) && isset($_POST['exam']) && ( isLogin() != null)) {
		$course = $_POST['course'];
		$exam = $_POST['exam'];

		$query = "SELECT `student`.`id`,`student`.`prn`,`student`.`name`,`student`.`department`,`student`.`current_semester`,`marks_others`.`marks`,`marks_others`.`ne_flag`,`marks_others`.`ab_flag` FROM `student`,`course_assign`,`exam_registration`,`ses_conf`,`marks_others` WHERE `student`.`status` = 'ONGOING' AND `course_assign`.`sub_id` = '$course' AND `course_assign`.`sem` = `student`.`current_semester` AND `course_assign`.`branch` = `student`.`department` AND exam_registration.stud_id = `student`.`id` AND `exam_registration`.`course_id` = `course_assign`.`sub_id` AND `exam_registration`.`sesn_id` = `ses_conf`.`current_session` AND `ses_conf`.`id` = '1' AND `marks_others`.`sesn_id` = `ses_conf`.`current_session` AND `student`.`id` = `marks_others`.`stud_id` AND `marks_others`.`course_id` = '$course' AND `marks_others`.`exam_type` = '$exam' AND `exam_registration`.`conform_status` = '1' ;";

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
						echo sprintf('%02d', $marks);
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