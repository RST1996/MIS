<?php 
	//session_start();
	ob_start();
	include("../template/index.php");
	require_once "../config/dbconnect.php";
	require_once "../config/funlib/login_functions.php";
	require_once "../config/funlib/auth_functions.php";
	require_once "../config/funlib/grades_eval_functions.php";
	require_once "../config/funlib/lock_results_functions.php";

	$user_type = isLogin();
	if($user_type != null)
	{
		$user_id = $_SESSION['user_uid'];
		$user_ref_id = $_SESSION['user_ref_id'];		
		require_once "header.inc/lock_grades.php";
?>
<?php
		require_once "main.inc/lock_grades.php";
?>
</body>
</html>
<?php
	}
	else
	{
		header('Location:../template/login.php');
	}	
	ob_end_flush();
?>