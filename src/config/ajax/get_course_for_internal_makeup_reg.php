<?php
	session_start();
	require_once "../dbconnect.php";
	require_once "../funlib/login_functions.php";
	//require_once "../funlib/utilities_function.php";
	require_once "../funlib/marks_entry_functions.php";
	if (isset($_POST['exam_id']) && isset($_POST['sem']) && ( isLogin() != null)) 
	{
		$exam_id = $_POST['exam_id'];
		$sem = $_POST['sem'];
		$sesn_id = get_sesn_id();
		$dept = get_hod_department();
		//echo "<br/>";

		switch ($exam_id) {
			case '1':
				$query = "SELECT DISTINCT `course`.`id`,`course`.`course_code`,`course`.`course_name` FROM `course`,`student`,`exam_registration`,`th_mks_scheme` WHERE `exam_registration`.`sesn_id` = '$sesn_id' AND `exam_registration`.`stud_id` = `student`.`id` AND `exam_registration`.`course_id` = `course`.`id` AND `exam_registration`.`regular_flag` = '1' AND `exam_registration`.`conform_status` = '1' AND `student`.`department` = '$dept' AND `th_mks_scheme`.`sub_id` = `course`.`id` AND `th_mks_scheme`.`ise1` > 0";
				break;
			case '2':
				$query = "SELECT DISTINCT `course`.`id`,`course`.`course_code`,`course`.`course_name` FROM `course`,`student`,`exam_registration`,`th_mks_scheme` WHERE `exam_registration`.`sesn_id` = '$sesn_id' AND `exam_registration`.`stud_id` = `student`.`id` AND `exam_registration`.`course_id` = `course`.`id` AND `exam_registration`.`regular_flag` = '1' AND `exam_registration`.`conform_status` = '1' AND `student`.`department` = '$dept' AND `th_mks_scheme`.`sub_id` = `course`.`id` AND `th_mks_scheme`.`ise2` > 0";
				break;
			case '3':
				$query = "SELECT DISTINCT `course`.`id`,`course`.`course_code`,`course`.`course_name` FROM `course`,`student`,`exam_registration`,`th_mks_scheme` WHERE `exam_registration`.`sesn_id` = '$sesn_id' AND `exam_registration`.`stud_id` = `student`.`id` AND `exam_registration`.`course_id` = `course`.`id` AND `exam_registration`.`regular_flag` = '1' AND `exam_registration`.`conform_status` = '1' AND `student`.`department` = '$dept' AND `th_mks_scheme`.`sub_id` = `course`.`id` AND `th_mks_scheme`.`isa` > 0";
				break;
			case '4':
				$query = "SELECT DISTINCT `course`.`id`,`course`.`course_code`,`course`.`course_name` FROM `course`,`student`,`exam_registration`,`pr_mks_scheme` WHERE `exam_registration`.`sesn_id` = '$sesn_id' AND `exam_registration`.`stud_id` = `student`.`id` AND `exam_registration`.`course_id` = `course`.`id` AND `exam_registration`.`regular_flag` = '1' AND `exam_registration`.`conform_status` = '1' AND `student`.`department` = '$dept' AND `pr_mks_scheme`.`sub_id` = `course`.`id` AND `pr_mks_scheme`.`ica` > 0";
				break;
			
			default:
				echo "Invalid Results.!!";
				break;
		}
		//echo $query;
		if($res = mysqli_query($dbcon,$query))
		{
			if(mysqli_num_rows($res) > 0)
			{
?>
	<div class="row clearfix">
		<div class="col-sm-3">
			<div class="form-group">
				<div>
					<label>Course: </label> 
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<select id="course" name="course" onchange="show_list()" required>
					<option> -- SELECT Course -- </option>
<?php
				while ($row = mysqli_fetch_assoc($res)) 
				{
					$id = $row['id'];
					$code = $row['course_code'];
					$name = $row['course_name'];
					//$roman_sem = romanic_number($sem);
?>
					<option value="<?php echo $id; ?>"><?php echo $code." :".$name; ?></option>
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