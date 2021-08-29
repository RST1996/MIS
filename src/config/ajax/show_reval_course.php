<?php
	session_start();
	require_once "../dbconnect.php";
	require_once "../funlib/login_functions.php";
	require_once "../funlib/marks_entry_functions.php";
	if (isset($_POST['dept']) && ( isLogin() != null)) 
	{
		$dept = $_POST['dept'];
		$query = "SELECT `course`.`id`,`course`.`course_code`,`course`.`course_name` FROM `course`,`course_assign`,`th_mks_scheme` WHERE `course_assign`.`sub_id` = `course`.`id`  AND `course_assign`.`branch` = '$dept' AND `course`.`id` = `th_mks_scheme`.`sub_id` AND `th_mks_scheme`.`ese` > 0";
		//$query = "SELECT DISTINCT `course`.`id`, `course`.`course_code`,`course`.`course_name` FROM `course`,`th_mks_scheme`,`exam_registration`,`ses_conf`,`course_assign` WHERE `course_assign`.`sub_id` = `course`.`id` AND `course_assign`.`branch` = '$dept' AND`course`.`course_type_id` = '1' AND `th_mks_scheme`.`sub_id` = `course`.`id` AND `th_mks_scheme`.`ese` > 0 AND `ses_conf`.`id` = '1' AND `ses_conf`.`current_session` = `exam_registration`.`sesn_id` AND `exam_registration`.`course_id` = `course`.`id`AND `exam_registration`.`regular_flag` = '1'";
		if($res = mysqli_query($dbcon,$query))
		{
			if(mysqli_num_rows($res) > 0)
			{
?>
		<div class="row clearfix">
	        <div class="col-sm-2">
	            <div class="form-group">
	                <div>
	                    <label>Course : </label> 
	                </div>
	            </div>
	        </div>
	        <div class="col-md-6">
	            <select id="course" data-live-search="true" name="course" onchange="show_stud_list()" required>
	            	<option value=""> -- SELECT COURSE -- </option>
<?php
				while($row = mysqli_fetch_assoc($res))
				{
?>
					<option value="<?php echo $row['id'] ?>"><?php echo $row['course_code']." : ".$row['course_name'];  ?></option>
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
				echo "No cources to show";
			}
		}

	}	
?>