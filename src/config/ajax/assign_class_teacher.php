<?php
	session_start();
	require_once "../dbconnect.php";
	require_once "../funlib/login_functions.php";
	if (isset($_POST['year']) && ( isLogin() != null)) {
		$year = $_POST['year'];
		if ($year == 1) {
			include "../includes/assign_fy_class_teacher.inc.php";
		}
		else
		{
			include "../includes/assign_dept_class_teacher.inc.php";
		}

	}
?>