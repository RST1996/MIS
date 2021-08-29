<?php
	session_start();
	require_once "../dbconnect.php";
	require_once "../funlib/login_functions.php";
	require_once "../funlib/grades_eval_functions.php";
	if (isset($_POST['dept']) && isset($_POST['sem']) && ( isLogin() != null)) {
		//print_r($_POST);
		$dept = $_POST['dept'];
		$sem = $_POST['sem'];
		$query = "SELECT `course`.`id`,`course`.`course_code`,`course`.`course_name` FROM `course`,`course_assign` WHERE `course_assign`.`sub_id` = `course`.`id` AND `course_assign`.`sem` = '$sem' AND `course_assign`.`branch` = '$dept'";
		if($res = mysqli_query($dbcon,$query))
		{
			if(mysqli_num_rows($res) > 0)
			{
?>
									<div class="row clearfix">
										<div class="col-sm-2">
											<div class="form-group">
												<div>
													<label>COURSE : </label> 
												</div>
											</div>
										</div>
										<div class="col-md-6">
												<select class="form-control show-tick"  data-live-search="true" id="course" name="course" onchange="show_list()"  required>
													<option value="">---SELECT COURSE---</option>
<?php
				while($row = mysqli_fetch_assoc($res))
				{
?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['course_code']." : ".$row['course_name'];  ?></option>
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
				echo "No cources are assigned !!";
			}
		}
		else
		{

		}
	}
?>