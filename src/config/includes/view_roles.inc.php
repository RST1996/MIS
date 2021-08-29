<table id="role_view_table" class="table table-bordered table-striped table-hover js-basic-example dataTable">
			<thead>
				<tr>
					<th>Role</th>
					<th>Usre Type</th>
					<th>Staff Type</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
<?php
	$query = "SELECT `role_id`, `user_type`, `staff_type` FROM `role_assign` ORDER BY `role_id` ASC";
	if ($res = mysqli_query($dbcon,$query)) {
		if (mysqli_num_rows($res) > 0) {
			while ($row = mysqli_fetch_assoc($res)) {
				$role_id = $row['role_id'];
				$user_type = $row['user_type'];

				$staff_type = $row['staff_type'];
				$role_name = get_role_name($role_id);
				$user_type_name = get_user_type_name($user_type);
				if($user_type == 2)
				{
					$staff_type_name = get_staff_type_name($staff_type);	
				}
				else
				{
					$staff_type_name = "NOT A STAFF..";
				}
				
?>
				<tr>
					<td><?php echo $role_name; ?></td>
					<td><?php echo $user_type_name; ?></td>
					<td><?php echo $staff_type_name; ?></td>
					<td><button onclick="remove_role('<?php echo $role_id; ?>','<?php echo $user_type; ?>','<?php echo $staff_type ?>')" class="btn btn-danger">REMOVE</button></td>
				</tr>
<?php

			}
		} else {
?>
				<tr>
					<td colspan="4">NO ROLES ASSIGNED YET..!!</td>
				</tr>
<?php			
		}
		
		
	} else {
?>
				<tr>
					<td colspan="4">UNABLE TO FETCH ROLES..!!</td>
				</tr>
<?php
	}
	
?>
			</tbody>
		</table>