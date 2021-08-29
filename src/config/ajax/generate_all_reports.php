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
		$query = "SELECT `course_type_id` FROM `course` WHERE `id` = '$course_id'";
		if ($res = mysqli_query($dbcon,$query)) {
			if (mysqli_num_rows($res) == 1) {
				$row = mysqli_fetch_assoc($res);
				$course_type = $row['course_type_id'];
			}
		}
		if($course_type == 1)
		{
		?>
		
		<div class="row clearfix" align="center">
				<div class="col-sm-4">
					
					<input type="button"  name="generate_marks" value="Generate Report(R07)" onclick="get_print('R07','<?php $no = rand(1000,2000); $_SESSION['sec_access_code'] = $no; echo base64_encode($no); ?>')" class="btn bg-deep-purple waves-effect"/> 
				</div>
				
			</div> 
			
		<?php
		}
		else if($course_type == 2)
		{
			$query = "SELECT `student`.`id` ,`student`.`prn`,`student`.`name`,`exam_registration`.`regular_flag` FROM `student`,`exam_registration` WHERE `exam_registration`.`sesn_id` = '$sesn_id' AND `exam_registration`.`stud_id` = `student`.`id` AND `exam_registration`.`course_id` = '$course_id' AND `exam_registration`.`conform_status` = '1' AND `student`.`department` = '$dept'";
			if ($res = mysqli_query($dbcon,$query)) {
			if (mysqli_num_rows($res) > 0 ) {
				
			
			?>
			<div class="row clearfix" align="center">
				<div class="col-sm-4">
					
					<input type="button"  name="generate_marks" value="Generate Report(R08)" onclick="get_print('R08','<?php $no = rand(3000,4000); $_SESSION['sec_access_code'] = $no; echo base64_encode($no); ?>')" class="btn bg-deep-purple waves-effect"/> 
				</div>
			</div> 
			<?php
			}
			else
			{
				echo "No students Applied For this course";
			}
		}
		}
		
	}
?>