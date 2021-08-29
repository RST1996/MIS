<?php

	session_start();
	require_once "../dbconnect.php";
	require_once "../funlib/login_functions.php";

	if (isset($_POST['department']) &&isset($_POST['course']) && ( isLogin() != null)) {
			$department = $_POST['department'];
			$course = $_POST['course'];
			$sem = 0;
			$query1 = "SELECT `sem` FROM `course_assign` WHERE `sub_id`='$course' AND `branch`='$department'";
			if ($res1 = mysqli_query($dbcon,$query1)) {
					
					if (mysqli_num_rows($res1) > 0) {
						
						while ($row1 = mysqli_fetch_assoc($res1)) {
							
							$sem = $row1['sem'];
						}
					}
					else
					{
						?>
						<tr>
							<td colspan="4"> Course not assigned!!</td>
						</tr>
						<?php
					}
			}
			
			
	}
?>
							<table id="student_table" class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
										<th>PRN</th>
										<th>Name</th>
										<th>Action</th>

                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
										<th>PRN</th>
										<th>Name</th>
										<th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
  <?php 
	$view_query = "SELECT `student`.`id`, `prn`, `name`,`department`, `current_semester`, `status` FROM `student`,`exam_registration`  WHERE `status` = 'ONGOING' AND `department`='$department' AND `current_semester` = '$sem' AND `id` = `exam_registration`.`stud_id` AND `exam_registration`.`course_id`='$course' AND `exam_registration`.`conform_status` = '1' ORDER BY `prn` ASC ";
	if ($res = mysqli_query($dbcon,$view_query)) {
		if (mysqli_num_rows($res) > 0)
		{
			while ($row = mysqli_fetch_assoc($res)) {
				$id = $row['id'];
				$prn = $row['prn'];
				$name = $row['name'];
				
?>
			<tr>
				<td><?php echo $prn; ?></td>
				<td><?php echo $name; ?></td>
				<td></td>
			</tr>
<?php
			}
		}
		else
		{
?>
			<tr>
				<td colspan="4"> No student entry found!!</td>
			</tr>
<?php
		}
	}
	else
	{
?>
			<tr>
				<td colspan="4"><?php echo mysqli_error($dbcon);?> Something Went Wrong!!!</td>
			</tr>
<?php
	}
?>
                                </tbody>
                            </table>