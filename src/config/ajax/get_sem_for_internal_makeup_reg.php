<?php
	session_start();
	require_once "../dbconnect.php";
	require_once "../funlib/login_functions.php";
	require_once "../funlib/utilities_function.php";
	require_once "../funlib/marks_entry_functions.php";
	if (isset($_POST['exam_id']) && ( isLogin() != null)) 
	{
		$exam_id = $_POST['exam_id'];
		$sesn_id = get_sesn_id();
		$dept = get_hod_department();

		switch ($exam_id) {
			case '1':
				$query = "SELECT DISTINCT `student`.`current_semester` FROM `student`,`exam_registration`,`th_mks_scheme` WHERE `exam_registration`.`sesn_id` = '$sesn_id' AND `exam_registration`.`stud_id` = `student`.`id` AND `exam_registration`.`regular_flag` = '1' AND `exam_registration`.`conform_status` = '1' AND `th_mks_scheme`.`sub_id` = `exam_registration`.`course_id` AND `th_mks_scheme`.`ise1` > 0 AND `student`.`current_semester` > 2 AND `student`.`department` = '$dept'";
				break;
			case '2':
				$query = "SELECT DISTINCT `student`.`current_semester` FROM `student`,`exam_registration`,`th_mks_scheme` WHERE `exam_registration`.`sesn_id` = '$sesn_id' AND `exam_registration`.`stud_id` = `student`.`id` AND `exam_registration`.`regular_flag` = '1' AND `exam_registration`.`conform_status` = '1' AND `th_mks_scheme`.`sub_id` = `exam_registration`.`course_id` AND `th_mks_scheme`.`ise2` > 0 AND `student`.`current_semester` > 2 AND `student`.`department` = '$dept'";
				break;
			case '3':
				$query = "SELECT DISTINCT `student`.`current_semester` FROM `student`,`exam_registration`,`th_mks_scheme` WHERE `exam_registration`.`sesn_id` = '$sesn_id' AND `exam_registration`.`stud_id` = `student`.`id` AND `exam_registration`.`regular_flag` = '1' AND `exam_registration`.`conform_status` = '1' AND `th_mks_scheme`.`sub_id` = `exam_registration`.`course_id` AND `th_mks_scheme`.`isa` > 0 AND `student`.`current_semester` > 2 AND `student`.`department` = '$dept'";
				break;
			case '4':
				$query = "SELECT DISTINCT `student`.`current_semester` FROM `student`,`exam_registration`,`pr_mks_scheme` WHERE `exam_registration`.`sesn_id` = '$sesn_id' AND `exam_registration`.`stud_id` = `student`.`id` AND `exam_registration`.`regular_flag` = '1' AND `exam_registration`.`conform_status` = '1' AND `pr_mks_scheme`.`sub_id` = `exam_registration`.`course_id` AND `pr_mks_scheme`.`ica` > 0 AND `student`.`current_semester` > 2 AND `student`.`department` = '$dept'";
				break;
			
			default:
				echo "Invalid Results.!!";
				break;
		}
		if($res = mysqli_query($dbcon,$query))
		{
			if(mysqli_num_rows($res) > 0)
			{
?>
	<div class="row clearfix">
		<div class="col-sm-3">
			<div class="form-group">
				<div>
					<label>SEMESTER : </label> 
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<select id="sem" name="sem" onchange="show_course()" required>
					<option> -- SELECT SEMESTER -- </option>
<?php
				while ($row = mysqli_fetch_assoc($res)) 
				{
					$sem = $row['current_semester'];
					$roman_sem = romanic_number($sem);
?>
					<option value="<?php echo $sem; ?>"><?php echo "SEM ".$roman_sem; ?></option>
<?php
				}
?>
			</select>
		</div>
	</div>
<?php
			}
			else
			{
				echo "No Data found";
			}
		}
		else
		{
			echo "Failed to fetch data ... :(";
		}
		

	}

?>