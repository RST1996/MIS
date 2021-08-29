
<?php
	session_start();
	require_once "../dbconnect.php";
	require_once "../funlib/login_functions.php";
		require_once "../funlib/course_mgmt_functions.php";

	if (isset($_POST['department']) && isset($_POST['sem']) && ( isLogin() != null)) {
		//print_r($_POST);
		$department = $_POST['department'];
		$sem = $_POST['sem'];
?>
    <!-- JQuery DataTable Css -->
    <link href="../plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

                            <table id="course_table" class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
										<th>Course Code</th>
										<th>Course Name</th>
										<th>Credit</th>
										<th>Course Type</th>
										
										

                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
										<th>Course Code</th>
										<th>Course Name</th>
										<th>Credit</th>
										<th>Course Type</th>
																				
                                    </tr>
                                </tfoot>
                                <tbody>
  <?php 
	$view_query = "SELECT `course`.`id`,`course`.`course_code`,`course`.`course_name`,`course_type`.`name`,`course`.`credits`,`course_assign`.`sem`,`course_assign`.`branch` FROM `course_assign`,`course`,`course_type` WHERE `course`.`id` = `course_assign`.`sub_id` AND `course_assign`.`branch`  = '$department' AND `course_assign`.`sem` = '$sem' AND `course`.`course_type_id` = `course_type`.`id`";
	if ($res = mysqli_query($dbcon,$view_query)) {
		if (mysqli_num_rows($res) > 0)
		{
			while ($row = mysqli_fetch_assoc($res)) {
				$id = $row['id'];
				$course_code = $row['course_code'];
				
				$course_name = $row['course_name'];
				$type = $row['name'];
				$course_credit = $row['credits'];
				
?>
			<tr>
				<td><?php echo $course_code; ?></td>
				<td><?php echo $course_name; ?></td>
				<td><?php echo $course_credit ; ?></td>
				<td><?php echo $type; ?></td>
				
				
			</tr>
<?php
			}
		}
		else
		{
?>
			<tr>
				<td colspan="4"> No Course entry found!!</td>
			</tr>
<?php
		}
	}
	else
	{
?>
			<tr>
				<td colspan="4"> Something Went Wrong!!! <?php
				echo mysqli_error($dbcon);
				?></td>
			</tr>
<?php
	}
	
?>
                                </tbody>
                            </table>
 <?php
	}
 ?>