<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                        	<thead>
                                <tr>
                                	<th>Class</th>
									<th>Department</th>
									<th>Class Teacher</th>
									<th>Update</th>
                                </tr>
                            </thead>
                            <tbody>
<?php
	$query = "SELECT `department`.`department_name`,`classes`.`class_name`,`class_teacher`.`branch`,`class_teacher`.`year`,`staff`.`name` FROM `class_teacher`,`department`,`classes`,	`staff` WHERE `class_teacher`.`branch` = `department`.`id` AND `class_teacher`.`year` = `classes`.`id`AND `class_teacher`.`class_teacher_id`=`staff`.`id` AND `class_teacher`.`branch` = '$department' ";
	if ($res = mysqli_query($dbcon,$query)) {
		while ($row = mysqli_fetch_assoc($res)) {
			$branch = $row['branch'];
			$year = $row['year'];
			$ip_id = "ip".$branch."and".$year;
			$btn_id = "btn".$branch."and".$year;

?>
								<tr>
									<td><?php echo $row['class_name']; ?></td>
									<td><?php echo $row['department_name']; ?></td>
									<td id="<?php echo $ip_id; ?>"><?php echo $row['name']; ?></td>
									<td id="<?php echo $btn_id; ?>"><input type="button" class="btn btn-primary waves-effect" onclick="enable_edit('<?php echo $branch; ?>','<?php echo $year; ?>','<?php echo $ip_id ?>','<?php echo $btn_id ?>')" class="btn btn-danger" value="Update" /></td>
								</tr>
<?php
		}
	}
?>
                            </tbody>
                        </table>