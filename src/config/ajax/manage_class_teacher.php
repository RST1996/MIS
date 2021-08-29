<?php
	session_start();
	require_once "../dbconnect.php";
	require_once "../funlib/login_functions.php";
	if (isset($_POST['year']) && isset($_POST['department']) && isset($_POST['set_id']) && ( isLogin() != null)) {
		$year = $_POST['year'];
		$department = $_POST['department'];
		$set_id = $_POST['set_id'];

		if ($year == 1) {
			$query = "SELECT `staff`.`id`,`staff`.`name` FROM `staff`,`staff_role` WHERE `staff`.`department` = '7' AND `staff_role`.`staff_id` = `staff`.`id` AND `staff_role`.`staff_type_id` = '7'";
		}
		else
		{
			$query = "SELECT `staff`.`id`,`staff`.`name` FROM `staff`,`staff_role` WHERE `staff`.`department` = '$department' AND `staff_role`.`staff_id` = `staff`.`id` AND `staff_role`.`staff_type_id` = '7'";	
		}
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