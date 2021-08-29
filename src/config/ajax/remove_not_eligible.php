<?php
	session_start();
	require_once "../dbconnect.php";
	require_once "../funlib/login_functions.php";
	require_once "../funlib/not_elligible_functions.php";
	
	if (isset($_POST['stud']) && isset($_POST['course']) && isset($_POST['exam']) && ( isLogin() != null)) {
		$stud = $_POST['stud'];
		$course = $_POST['course'];
		$exam = $_POST['exam'];
		$sesn_id = get_sesn_id();

		if(check($stud,$course,$exam))
		{
			if(remove($stud,$course,$exam))
			{
				echo "removed from ne list";
			}
			else
			{
				echo "not removed";
			}
		}
		else
		{
			echo "not present";
		}
	}
?>