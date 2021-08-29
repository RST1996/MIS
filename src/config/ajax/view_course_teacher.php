<?php
	session_start();
	
	require_once "../dbconnect.php";
	require_once "../funlib/login_functions.php";
	
	if ( isset($_POST['department'])&& ( isLogin() != null)) {
		$department = $_POST['department'];
		
?>
<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                        	<thead>
                                <tr>
									<th>Department</th>
									<th>Course</th>
									<th>Course Teacher</th>
									<th>Update</th>
                                </tr>
                            </thead>
                            <tbody>
<?php
	$query = "SELECT  `department`.`department_name` ,  `course_teacher`.`branch` ,  `course_teacher`.`sem` ,  `staff`.`name` , `course`.`id`, `course_teacher`.`sub_id` ,  `course`.`course_name` 
FROM  `course_teacher` ,  `department` ,  `staff` ,  `course` 
WHERE  `department`.`id` = '$department'
AND  `course_teacher`.`staff_id` =  `staff`.`id` 
AND  `course_teacher`.`branch` = '$department'
AND  `course`.`id` =  `course_teacher`.`sub_id` ";
	if ($res = mysqli_query($dbcon,$query)) {
		while ($row = mysqli_fetch_assoc($res)) {
			$branch = $row['branch'];
			
			$course_id = $row['id'];
			$course = $row['course_name'];
			
			$ip_id = "ip".$branch."and".$course_id;
			$btn_id = "btn".$branch."and".$course_id;

?>
								<tr>
									
									<td><?php echo $row['department_name']; ?></td>
									<td><?php echo $row['course_name']; ?></td>
									<td id="<?php echo $ip_id; ?>"><?php echo $row['name']; ?></td>
									<td id="<?php echo $btn_id; ?>"><input type="button" class="btn btn-primary waves-effect" onclick="enable_edit('<?php echo $branch; ?>','<?php echo $course_id; ?>','<?php echo $ip_id ?>','<?php echo $btn_id ?>')" class="btn btn-danger" value="Update" /></td>
								</tr>
<?php
		}
	}
	
	
	}
?>
                            </tbody>
                        </table>
