		<table id="student_table" class="table table-striped table-bordered" cellspacing="0" width="100%">
			<tr>
				<th>PRN</th>
				<th>Name</th>
				<th>Department</th>
				<th>Action</th>
			</tr>			
<?php 
	$view_query = "SELECT `student`.`id`,`student`.`prn`,`student`.`name`,`department`.`department_name` FROM `student` LEFT JOIN `department` ON `department`.`id` = `student`.`department`";
	if ($res = mysqli_query($dbcon,$view_query)) {
		if (mysqli_num_rows($res) > 0)
		{
			while ($row = mysqli_fetch_assoc($res)) {
				$id = $row['id'];
				$prn = $row['prn'];
				$name = $row['name'];
				$department = $row['department_name'];
?>
			<tr>
				<td><?php echo $prn; ?></td>
				<td><?php echo $name; ?></td>
				<td><?php echo $department; ?></td>
				<td><button onclick="delete_student(<?php echo $id; ?>)" class="btn btn-danger">DELETE</button></td>
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
				<td colspan="4"> Something Went Wrong!!!</td>
			</tr>
<?php
	}
?>
		</table>