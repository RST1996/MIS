<?php
	if (isset($_POST['staff_id']) && ( isLogin() != null)) {
		$staff = $_POST['staff_id'];
		$query = "SELECT `staff_role`.`staff_id`,`staff_role`.`staff_type_id`,`staff_type`.`staff_type_name` FROM `staff_role`,`staff_type` WHERE `staff_role`.`staff_id`='$staff' AND `staff_role`.`staff_type_id` = `staff_type`.`id`";
		if ($res = mysqli_query($dbcon,$query)) {
			if (mysqli_num_rows($res) > 0) {
?>
		<table id="role_view_table" class="table table-bordered table-striped table-hover js-basic-example dataTable">
			<thead>
				<tr>
					<th>Staff Role</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
<?php
				while ($row = mysqli_fetch_assoc($res)) {
					$staff_id = $row['staff_id'];
					$staff_type_id = $row['staff_type_id'];
					$staff_type_name = $row['staff_type_name'];
?>
				<tr>
					<td><?php echo $staff_type_name; ?></td>
					<td>
						<button onclick="remove_staff_role('<?php echo $staff_id ?>','<?php echo $staff_type_id ?>')" class="btn btn-danger">REMOVE</button>
					</td>
				</tr>
<?php
				}
?>
			</tbody>
		</table>
<?php
			} else {
				echo "No ROLES assigned to selected staff!!";
			}
			
		} else {
			echo "ERROR... ".mysqli_error($dbcon);
		}
		
	}
	
?>