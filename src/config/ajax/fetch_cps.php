<?php
	session_start();
	require_once "../dbconnect.php";
	require_once "../funlib/login_functions.php";
	require_once "../funlib/auth_functions.php";
	if(isset($_POST['sesn_id']) && isLogin()!=null)
	{
		$sesn_id = $_POST['sesn_id'];
		$case_sel_query = "SELECT `student`.`prn`,`student`.`name`,`course`.`course_code`,`course`.`course_name`,`exam_table`.`exam_name_abvr`,`copy_case`.`stud_id`,`copy_case`.`course_id`,`copy_case`.`exam_type` FROM `student`,`course`,`exam_table`,`copy_case` WHERE `copy_case`.`sesn_id`= '$sesn_id' AND `copy_case`.`stud_id` = `student`.`id` AND `copy_case`.`course_id` = `course`.`id` AND `copy_case`.`exam_type` = `exam_table`.`id` AND `punishment_flag` = '0' ";
		if($case_sel_res = mysqli_query($dbcon,$case_sel_query))
		{
			if(mysqli_num_rows($case_sel_res) > 0)
			{
?>
	<table class="table table-bordered table-striped table-hover dataTable">
		<thead>
			<th>#</th>
			<th>PRN</th>
			<th>Name</th>
			<th>Course</th>
			<th>Exam</th>
			<th>Punishment</th>
			<th>Action</th>
		</thead>
		<tbody>
<?php
				$i = 1;
				while ($case_sel_row = mysqli_fetch_assoc($case_sel_res)) 
				{
					$prn = $case_sel_row['prn'];
					$name = $case_sel_row['name'];
					$stud_id = $case_sel_row['stud_id'];
					$course_id = $case_sel_row['course_id'];
					$course = $case_sel_row['course_code']." : ".$case_sel_row['course_name'];
					$exam_type = $case_sel_row['exam_type'];
					$exam_name = $case_sel_row['exam_name_abvr'];
?>
			<tr>
				<td><?php echo $i++; ?></td>
				<td><?php echo $prn; ?></td>
				<td><?php echo $name; ?></td>
				<td><?php echo $course; ?></td>
				<td><?php echo $exam_name; ?></td>
				<td id="punish_<?php echo $stud_id.$course_id?>">Not Assigned</td>
				<td id="action_<?php echo $stud_id.$course_id?>">
					<button id="acbtn_<?php echo $stud_id.$course_id?>" class="btn btn-primary" onclick="update_punish('<?php echo $stud_id ?>','<?php echo $course_id ?>','<?php echo $exam_type ?>','<?php echo $sesn_id ?>')">Assign Punishment</button>
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
				echo "No unpunish cases";
			}
		}
	}
?>