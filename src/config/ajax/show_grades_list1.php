<?php
	session_start();
	require_once "../dbconnect.php";
	require_once "../funlib/login_functions.php";
	require_once "../funlib/grades_eval_functions.php";
	if (isset($_POST['dept']) && isset($_POST['sem']) && isset($_POST['course']) && ( isLogin() != null)) {
		//print_r($_POST);
		$dept = $_POST['dept'];
		$sem = $_POST['sem'];
		$course_id = $_POST['course'];
		/*********************************************/
		$sesn_id = get_sesn_id();
		$max_marks = get_max_marks($course_id);
		$ese_max_marks = get_ese_max_marks($course_id);
		$query ="SELECT `student`.`id`,`exam_registration`.`regular_flag` FROM `student`,`exam_registration` WHERE `exam_registration`.`sesn_id` = '$sesn_id' AND `exam_registration`.`course_id` = '$course_id' AND `exam_registration`.`stud_id` = `student`.`id` AND `exam_registration`.`conform_status` = '1'";
		$marks = array();

		if($res = mysqli_query($dbcon,$query))
		{
			$num_of_students = mysqli_num_rows($res);
			if(mysqli_num_rows($res) > 0)
			{
				
				while ($row = mysqli_fetch_assoc($res)) {
					$stud_id = $row['id'];
					$regular_flag = $row['regular_flag'];
					if ($regular_flag == 1) {
						$marks[] = get_total_marks_obtained($stud_id,$course_id);
					} else {
						$marks[] = get_total_marks_obtained_back($stud_id,$course_id);
					}
					
					
				}
				//print_r($marks);
				
			}
		}
		if($num_of_students >= 15)
		{
			$limit =  get_limit($marks,sizeof($marks),$max_marks);
			$pass_limit = $max_marks * 0.4 ;
			$diff = ($limit - $pass_limit) / 5 ;
			$limit2 = $limit - $diff ;
			$limit3 = $limit2 - $diff;
			$limit4 = $limit3 - $diff;
			$limit5 = $limit4 - $diff;
		}
		else
		{
			$limit = $max_marks * 0.79;
			$pass_limit = $max_marks * 0.4;
			$limit2 = $max_marks * 0.71;
			$limit3 = $max_marks * 0.62;
			$limit4 = $max_marks * 0.54;
			$limit5 = $max_marks * 0.46;	
		}
		 
		
		/*********************************************/

		$query = "SELECT `course_type_id` FROM `course` WHERE `id` = '$course_id'";
		if($res = mysqli_query($dbcon,$query))
		{
			if(mysqli_num_rows($res) == 1)
			{
				$row  = mysqli_fetch_assoc($res);
				$course_type = $row['course_type_id'];
				if($course_type == 1)
				{
					include "../includes/th_grades_list.php";
				}
				elseif($course_type == 2)
				{

					include "../includes/pr_grades_list.php";
				}
				else
				{
					echo "Different cource yet to classify";
				}
			}
			else
			{
				echo "Invalid Course";
			}
		}
		else
		{
			echo mysqli_error($dbcon);
		}
	}
?>