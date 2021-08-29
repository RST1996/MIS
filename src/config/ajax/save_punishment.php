<?php
	session_start();
	require_once "../dbconnect.php";
	require_once "../funlib/login_functions.php";
	require_once "../funlib/auth_functions.php";
	if(isset($_POST['sesn_id']) && isset($_POST['pid']) && isset($_POST['stud_id']) && isset($_POST['course_id']) && isset($_POST['exam_type']) && isLogin() != null)
	{
		$sesn_id = $_POST['sesn_id'];
		$stud_id = $_POST['stud_id'];
		$course_id = $_POST['course_id'];
		$exam_type = $_POST['exam_type'];
		$pid = $_POST['pid'];
		$update_punishment = "UPDATE `copy_case` SET `punishment_flag`='1',`punish_id`='$pid' WHERE `sesn_id`='$sesn_id' AND `stud_id`='$stud_id' AND `course_id`='$course_id' AND `exam_type`='$exam_type'";
		if($res = mysqli_query($dbcon,$update_punishment))
		{
			echo "success";
		}
		else
		{
			echo "Filed.!";
		}
	}
?>