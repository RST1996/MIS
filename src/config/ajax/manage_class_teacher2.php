<?php
	session_start();
	require_once "../dbconnect.php";
	require_once "../funlib/login_functions.php";
	require_once "../funlib/class_teacher_functions.php";
	if (isset($_POST['year']) && isset($_POST['department']) && isset($_POST['teacher']) && ( isLogin() != null)) {
		$year = $_POST['year'];
		$department = $_POST['department'];
		$teacher = $_POST['teacher'];
		update_class_teacher($year,$department,$teacher);
		include "../includes/manage_class_teacher.inc.php";

	}
?>