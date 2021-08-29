<?php
	//print_r($_POST);
	session_start();
	require_once "../dbconnect.php";
	require_once "../funlib/login_functions.php";
	//require_once "../funlib/not_elligible_functions.php";
	require_once "../funlib/marks_entry_functions.php";
	
	if (isset($_POST['course']) && isset($_POST['exam']) && isset($_POST['stud']) && isset($_POST['mark']) && isset($_POST['ab_flag']) && ( isLogin() != null)) {
		$course = $_POST['course'];
		$exam = $_POST['exam'];
		$stud = $_POST['stud'];
		$mark = $_POST['mark'];
		$ab_flag = $_POST['ab_flag'];

		$sesn_id = get_sesn_id();
		switch($exam)
		{
			case 5:
				$query = "UPDATE `marks_th_ese` SET `marks`='$mark',`ab_flag`='$ab_flag' WHERE `ne_flag` = '0' AND `sesn_id` = '$sesn_id' AND `stud_id`= '$stud' AND `course_id` = '$course' AND `exam_type` = '$exam'";
				break;
			case 6:
				$query = "UPDATE `marks_pr_ese` SET `marks`='$mark',`ab_flag`='$ab_flag' WHERE `ne_flag` = '0' AND `sesn_id` = '$sesn_id' AND `stud_id`= '$stud' AND `course_id` = '$course' AND `exam_type` = '$exam'";
				break;
		}
		if($res = mysqli_query($dbcon,$query))
		{
			echo "success";
		}
		else
		{
			echo "Failed";
		}
	}	
?>