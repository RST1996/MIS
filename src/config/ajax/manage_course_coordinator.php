<?php
	session_start();
	require_once "../dbconnect.php";
	require_once "../funlib/login_functions.php";
	if (isset($_POST['course']) && isset($_POST['department']) && isset($_POST['set_id']) && ( isLogin() != null)) {
		$course = $_POST['course'];
		$department = $_POST['department'];
		$set_id = $_POST['set_id'];

		
		$query = "SELECT DISTINCT `staff`.`id`,`staff`.`name` FROM `staff`,`course_coordinator` WHERE `staff`.`id` =`course_coordinator`.`course_coord_id` AND `course_coordinator`.`course_id` = '$course' ";	
		
?>
	<select id="<?php echo $set_id; ?>">
		<option value="">--SELECT TEACHER--</option>
<?php
	if ($res = mysqli_query($dbcon,$query)) {
		while ($row = mysqli_fetch_assoc($res)) {
?>
		<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
<?php
		}
	}
?>
	</select>
<?php

	}
?>