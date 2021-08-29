

                            <table id="staff_table" class="table table-bordered table-striped table-hover js-basic-example dataTable" >
                                <thead>
                                    <tr>
										<th>Name</th>
										<th>Designation</th>
										<th>Department</th>
										<th >Action-Edit</th>
										<th>Action-delete</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
										<th>Name</th>
										<th>Designation</th>
										<th>Department</th>
										<th >Action-Edit</th>
										<th>Action-delete</th>
                                    </tr>
                                </tfoot>
                                <tbody>
  <?php
	$sel_query = "SELECT `staff`.`id`, `staff`.`name`,`staff`.`designation`,`staff`.`department`,`department`.`department_name` FROM `staff` LEFT JOIN`department` ON `staff`.`department` = `department`.`id`";
	if ($res = mysqli_query($dbcon,$sel_query)) {
		if (mysqli_num_rows($res) > 0) {
			
			while ($row = mysqli_fetch_assoc($res)) {
				$id = $row['id'];
				$name = $row['name'];
				$designation = $row['designation'];
				$department = $row['department_name'];
				$department_id = $row['department'];
?>
				<tr>
					<td><input type="text" id="name<?php echo $id; ?>"  name = "name<?php echo $id; ?>" value="<?php echo $name ?>" required disabled  /></td>
					<td><input type="text" id="designation<?php echo $id; ?>"  name = "designation<?php echo $id; ?>" value="<?php echo $designation ?>" required disabled /></td>
					<td>
						<select id="department<?php echo $id; ?>"  name = "department<?php echo $id; ?>" required disabled >

						<?php
							$dep_sel_query = "SELECT `id`, `department_name` FROM `department`";
							if ($res1 = mysqli_query($dbcon,$dep_sel_query)) {
								if (mysqli_num_rows($res) > 0) {
									while ($row1 = mysqli_fetch_assoc($res1)) {
						?>
						<option value="<?php echo $row1['id']; ?>" <?php if($department_id == $row1['id']){echo "selected"; }?> ><?php echo $row1['department_name'];  ?></option>
						<?php				
									}
								}
							}

						?>
						</select>
					</td>
					<td id="cell<?php echo $id; ?>"><button class="btn btn-primary waves-effect" onclick='make_editable("name<?php echo $id; ?>","designation<?php echo $id; ?>","department<?php echo $id; ?>","cell<?php echo $id; ?>","<?php echo $id; ?>")' class="btn btn-default">EDIT</button></td>
					<td><button class="btn bg-red waves-effect"onclick="delete_staff(<?php echo $id; ?>)" class="btn btn-danger">Delete</button></td>
				</tr>
<?php
			}
		} else {
			echo "No Staff has been Added yet!";
		}
		
	} else {
		echo "Something went wrong!";
	}
	
?>
                                </tbody>
                            </table>
                      
