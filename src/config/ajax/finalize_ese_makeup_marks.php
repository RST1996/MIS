<?php
	session_start();
	require_once "../dbconnect.php";
	require_once "../funlib/login_functions.php";
	//require_once "../funlib/not_elligible_functions.php";
	require_once "../funlib/marks_entry_functions.php";
	
	if (isset($_POST['course']) && isset($_POST['exam']) && ( isLogin() != null)) {
		$course = $_POST['course'];
		$exam = $_POST['exam'];
		$sesn_id = get_sesn_id();
		switch($exam){
			case '5':
				$student_query = "SELECT DISTINCT `student`.`id`, `student`.`prn`,`student`.`name`,`marks_th_ese`.`marks` FROM `student`,`exam_registration`,`marks_th_ese` WHERE `student`.`id` = `exam_registration`.`stud_id` AND `student`.`id` = `marks_th_ese`.`stud_id` AND `exam_registration`.`sesn_id` = `marks_th_ese`.`sesn_id` AND `marks_th_ese`.`sesn_id` = '$sesn_id' AND `exam_registration`.`course_id`  = `marks_th_ese`.`course_id` AND `marks_th_ese`.`course_id` = '$course' AND `exam_registration`.`conform_status` = '1'  AND `marks_th_ese`.`exam_type` = '$exam' AND `marks_th_ese`.`ab_flag` = '1'";
				break;
				case '6':
				$student_query = "SELECT DISTINCT `student`.`id`, `student`.`prn`,`student`.`name`,`marks_pr_ese`.`marks` FROM `student`,`exam_registration`,`marks_pr_ese` WHERE `student`.`id` = `exam_registration`.`stud_id` AND `student`.`id` = `marks_pr_ese`.`stud_id` AND `exam_registration`.`sesn_id` = `marks_pr_ese`.`sesn_id` AND `marks_pr_ese`.`sesn_id` = '$sesn_id' AND `exam_registration`.`course_id`  = `marks_pr_ese`.`course_id` AND `marks_pr_ese`.`course_id` = '$course' AND `exam_registration`.`conform_status` = '1'  AND `marks_pr_ese`.`exam_type` = '$exam' AND `marks_pr_ese`.`ab_flag` = '1'";
				break;
		}
			if($res = mysqli_query($dbcon,$student_query))
			{
				if (mysqli_num_rows($res) > 0) {
?>
							<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
										<th>PRN</th>
										<th>Name</th>
										<th>Marks</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
										<th>PRN</th>
										<th>Name</th>
										<th>Marks</th>
                                    </tr>
                                </tfoot>
                                <tbody>
<?php
						while($row = mysqli_fetch_assoc($res))
						{
							$stud_id = $row['id'];
?>
									<tr>
										<td><?php echo $row['prn']; ?></td>
										<td><?php echo $row['name']; ?></td>
										<td><?php echo $row['marks'] ?></td>
									</tr>
<?php
						}
?>
                                </tbody>
                            </table>
                            <div class="row clearfix">
										<div class="col-sm-4">
											<input type="button" onclick="show_list()" value="Back to Edit" class="btn bg-teal waves-effect"/> 
										</div>
										<div class="col-sm-4">
											<input type="button"  name="lock_marks" value="LOCK" class="btn bg-teal waves-effect"/> 
										</div>
							</div>                   
<?php
				} else {
					echo "No Students for makeup marks entry!!";
				}
				
			}
			else
			{
				die("failed to access resources.. contact admin..!");
			}

	}
?>