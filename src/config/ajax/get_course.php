<?php
	session_start();
	$user_ref_id = $_SESSION['user_ref_id'];
	require_once "../dbconnect.php";
	require_once "../funlib/login_functions.php";
	require_once "../funlib/not_elligible_functions.php";

	if ( (isset($_POST['exam_id']) && isset($_POST['department'])) && ( isLogin() != null)) {
		
		$department = $_POST['department'];
		$exam_id = $_POST['exam_id'];
		
?>	
	
	<div class="row clearfix">
		<div class="col-sm-3">
			<div class="form-group">
				<div>
					<label>Course : </label> 
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<select id="course" name="course" onchange="show_list()" data-live-search="true" required>
					<option> -- SELECT COURSE -- </option>
			<?php
				switch ($exam_id) {
					
					case '5':
						$course_query = "SELECT DISTINCT `course`.`id`,`course`.`course_code`,`course`.`course_name` FROM `course`,`th_mks_scheme`,`exam_registration`,`ses_conf`,`course_assign` WHERE `course_assign`.`sub_id` = `course`.`id` AND `course_assign`.`branch` = '$department' AND`course`.`course_type_id` = '1' AND `th_mks_scheme`.`sub_id` = `course`.`id` AND `th_mks_scheme`.`ese` > 0 AND `ses_conf`.`id` = '1'  AND `exam_registration`.`course_id` = `course`.`id`AND `exam_registration`.`regular_flag` = '1'";
						break;
					case '6':
						$course_query = "SELECT DISTINCT `course`.`id`, `course`.`course_code`,`course`.`course_name` FROM `course`,`pr_mks_scheme`,`exam_registration`,`ses_conf`,`course_assign` WHERE `course_assign`.`sub_id` = `course`.`id` AND `course_assign`.`branch` = '$department' AND `course`.`course_type_id` = '2' AND `pr_mks_scheme`.`sub_id` = `course`.`id` AND `pr_mks_scheme`.`ese` > 0 AND `ses_conf`.`id` = '1' AND `exam_registration`.`course_id` = `course`.`id`AND `exam_registration`.`regular_flag` = '1'";
						
						break;
					default:
						//echo "Invalid Value";
						die("Invalid conditions found!! Plzz contact Admin!");
						break;
				}	
				if ($res = mysqli_query($dbcon,$course_query)) {
					while ($row = mysqli_fetch_assoc($res)) {
			?>
					<option value="<?php echo $row['id']; ?>"><?php echo $row['course_code'].": ".$row['course_name']; ?></option>
			<?php
					}
				}
			?>
			</select>

		</div>
		
	</div>



<?php
	}
?>