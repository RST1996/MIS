    <table id="course_table" class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
										<th>Course Code</th>
										<th>Course Name</th>
										<th>Semester</th>
										<th>Department</th>
										<th>Details</th>
										<th>Action</th>

                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
										<th>Course Code</th>
										<th>Course Name</th>
										<th>Semester</th>
										<th>Department</th>
										<th>Details</th>
										<th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
  <?php 
	$view_query = "SELECT `course`.`course_code`,`course`.`course_name`,`course_assign`.`sem`,`course_assign`.`branch` FROM `course_assign`,`course` WHERE `course`.`id` = `course_assign`.`sub_id`";
	if ($res = mysqli_query($dbcon,$view_query)) {
		if (mysqli_num_rows($res) > 0)
		{
			while ($row = mysqli_fetch_assoc($res)) {
				$course_code = $row['course_code'];
				$sem = $row['sem'];
				$course_name = $row['course_name'];
				$department_no = $row['branch'];
?>
			<tr>
				<td><?php echo $course_code; ?></td>
				<td><?php echo $course_name; ?></td>
				<td><?php echo $sem ; ?></td>
				<td><?php echo $department; ?></td>
				<td><button onclick="view_course(<?php echo $id; ?>)" class="btn btn-primary waves-effect">VIEW</button></td>
				<td>Action</td>
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
				<td colspan="4"> Something Went Wrong!!!</td>
			</tr>
<?php
	}
?>
                                </tbody>
                            </table>