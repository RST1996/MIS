<?php
	session_start();
	require_once "../dbconnect.php";
	require_once "../funlib/login_functions.php";
	require_once "../funlib/grades_eval_functions.php";
	if (isset($_POST['dept']) && isset($_POST['sem']) && isset($_POST['course']) && ( isLogin() != null)) {
		//print_r($_POST);
		$dept = $_POST['dept'];
		$sem = $_POST['sem'];
		$course_id = $_POST['course'];
		/*********************************************/
		$sesn_id = get_sesn_id();
		$max_marks = get_max_marks($course_id);

		$query ="SELECT `student`.`id`,`exam_registration`.`regular_flag` FROM `student`,`exam_registration` WHERE `exam_registration`.`sesn_id` = '$sesn_id' AND `exam_registration`.`course_id` = '$course_id' AND `exam_registration`.`stud_id` = `student`.`id` AND `exam_registration`.`conform_status` = '1'";
		$marks = array();

		if($res = mysqli_query($dbcon,$query))
		{
			if(mysqli_num_rows($res) > 0)
			{
				
				while ($row = mysqli_fetch_assoc($res)) {
					$stud_id = $row['id'];
					$regular_flag = $row['regular_flag'];
					if ($regular_flag == 1) {
						$marks[] = get_total_marks_obtained($stud_id,$course_id);
					} else {
						$marks[] = get_total_marks_obtained_back($stud_id,$course_id);
					}
					
					
				}
				//print_r($marks);
				
			}
		}

		$limit =  get_limit($marks,sizeof($marks),$max_marks);
		$pass_limit = $max_marks * 0.4 ;
		$diff = ($limit - $pass_limit) / 5 ;
		$limit2 = $limit - $diff ;
		$limit3 = $limit2 - $diff;
		$limit4 = $limit3 - $diff;
		$limit5 = $limit4 - $diff; 
		
		/*********************************************/

		$query = "SELECT `student`.`id` ,`student`.`prn`,`student`.`name` FROM `student`,`exam_registration` WHERE `exam_registration`.`sesn_id` = '$sesn_id' AND `exam_registration`.`stud_id` = `student`.`id` AND `exam_registration`.`course_id` = '$course_id' AND `exam_registration`.`conform_status` = '1' AND `student`.`department` = '$dept'";
		if($res = mysqli_query($dbcon,$query))
		{
			if(mysqli_num_rows($res) > 0)
			{
?>
							<table id="student_table" class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
										<th>PRN</th>
										<th>Name</th>
										<th>Marks</th>
										<th>Result</th>
										<th>Grade</th>

                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
										<th>PRN</th>
										<th>Name</th>
										<th>Marks</th>
										<th>Result</th>
										<th>Grade</th>
                                    </tr>
                                </tfoot>
                                <tbody>
<?php
				while ($row = mysqli_fetch_assoc($res)) {
					$stud_id = $row['id'];
					$prn = $row['prn'];
					$name = $row['name'];
					$mark = get_total_marks_obtained($stud_id,$course_id);
					if($mark > $limit)
					{
						$grade = "A+";
					}
					elseif ($mark >= $limit2 && $mark <=$limit) {
						$grade = "A";
					}
					elseif ($mark >= $limit3 && $mark <$limit2) {
						$grade = "B+";
					}
					elseif ($mark >= $limit4 && $mark <$limit3) {
						$grade = "B";
					}
					elseif ($mark >= $limit5 && $mark <$limit4) {
						$grade = "C+";
					}
					elseif ($mark >= $pass_limit && $mark <$limit5) {
						$grade = "C";
					}
					elseif ($mark < $pass_limit) {
						$grade = "F";
					}
					if($mark > $pass_limit)
					{
						$status = "PASS";
					}
					else
					{
						$status = "FAIL";
						$grade = "F";
					}
?>
									<tr>
										<td><?php echo $prn; ?></td>
										<td><?php echo $name; ?></td>
										<td><?php echo $mark; ?></td>
										<td><?php echo $status; ?></td>
										<td><?php echo $grade; ?></td>
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
		else
		{
			echo "Something went wrong.. ".mysqli_error($dbcon);
		}
	}
?>