<?php 
	//session_start();
	ob_start();
	include("../template/index.php");
	require_once "../config/dbconnect.php";
	require_once "../config/funlib/login_functions.php";
	require_once "../config/funlib/auth_functions.php";
	require_once "../config/funlib/class_teacher_functions.php";
	
	$user_type = isLogin();
	if($user_type != null)
	{
		$user_id = $_SESSION['user_uid'];
		$user_ref_id = $_SESSION['user_ref_id'];		
		require_once "header.inc/manage_class_teacher.php";
?>
<body>
<?php
		require_once "main.inc/manage_class_teacher.php";
?>
</body>
</html>
<?php
	}
	else
	{
		header('Location:../login.php');
	}	
	ob_end_flush();
?>