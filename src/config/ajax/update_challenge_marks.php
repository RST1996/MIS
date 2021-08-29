<?php
	session_start();
	require_once "../dbconnect.php";
	require_once "../funlib/login_functions.php";
	//require_once "../funlib/not_elligible_functions.php";
	require_once "../funlib/marks_entry_functions.php";
	if (isset($_POST['course']) && isset($_POST['stud']) && isset($_POST['mark'])  && ( isLogin() != null)) 
	{
		$course_id = $_POST['course'];
		$stud_id = $_POST['stud'];
		$marks = $_POST['mark'];
		$msg = update_challenge_marks($stud_id,$course_id,$marks);
		echo $msg ;
	}
?>