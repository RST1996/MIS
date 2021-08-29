<?php
	session_start();
	require_once "../dbconnect.php";
	require_once "../funlib/login_functions.php";
	require_once "../funlib/auth_functions.php";
	if(isset($_POST['sesn_id']) && isset($_POST['stud_id']) && isset($_POST['course_id']) && isset($_POST['exam_type']) && isLogin() != null)
	{
		$sesn_id = $_POST['sesn_id'];
		$stud_id = $_POST['stud_id'];
		$course_id = $_POST['course_id'];
		$exam_type = $_POST['exam_type'];
		$punish_load_query =  "SELECT `punish_id`, `punishment` FROM `punishment`";
		if( $res = mysqli_query($dbcon,$punish_load_query))
		{
			if(mysqli_num_rows($res) > 0)
			{
?>
	<input type='hidden' id='sesn_id_<?php echo $stud_id.$course_id; ?>' value='<?php echo $sesn_id; ?>'>
	<input type='hidden' id='course_id_<?php echo $stud_id.$course_id; ?>' value='<?php echo $course_id; ?>'>
	<input type='hidden' id='exam_type_<?php echo $stud_id.$course_id; ?>' value='<?php echo $exam_type; ?>'>
	<input type='hidden' id='stud_id_<?php echo $stud_id.$course_id; ?>' value='<?php echo $stud_id; ?>'>
	<select class="form-control show-tick" data-live-search="true" id="pid_<?php echo $stud_id.$course_id; ?>" >
		<option value="">--SELECT PUNISHMENT--</option>
<?php
				while($row=mysqli_fetch_assoc($res))
				{
					$pid = $row['punish_id'];
					$punishment = $row['punishment'];
?>
		<option value="<?php echo $pid ?>"><?php echo $punishment; ?></option>
<?php
				}
?>
	</select>
<?php
			}
			else
			{
				echo "No punishment found";
			}
		}
	}

?>