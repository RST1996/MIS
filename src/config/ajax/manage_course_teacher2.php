<?php
	session_start();
	require_once "../dbconnect.php";
	require_once "../funlib/login_functions.php";
	require_once "../funlib/course_teacher_functions.php";
	if (isset($_POST['course']) && isset($_POST['department']) && isset($_POST['teacher']) && ( isLogin() != null)) {
		$course = $_POST['course'];
		$department = $_POST['department'];
		$teacher = $_POST['teacher'];
		update_course_teacher($course,$department,$teacher);
		include "../includes/manage_course_teacher.inc.php";

	}
?>
