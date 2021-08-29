<?php 
	//session_start();
	ob_start();
	include("../template/index.php");
	require_once "../config/dbconnect.php";
	require_once "../config/funlib/login_functions.php";
	require_once "../config/funlib/auth_functions.php";
	require_once "../config/funlib/course_mgmt_functions.php";
	require_once "../config/funlib/sesn_mgmt_functions.php";

	$user_type = isLogin();
	if($user_type != null)
	{
		$user_id = $_SESSION['user_uid'];
		$user_ref_id = $_SESSION['user_ref_id'];		
		require_once "header.inc/assign_course.php";
?>

<?php
		require_once "main.inc/assign_course.php";
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