<?php
	session_start();
	require_once "../dbconnect.php";
	require_once "../funlib/login_functions.php";
	require_once "../funlib/auth_functions.php";
	if(isset($_POST['prn']) && isset($_POST['sesn_id']) && isLogin()!=null)
	{
		$prn = $_POST['prn'];
		$sesn_id = $_POST['sesn_id'];
		$stud_sel_query = "SELECT `student`.`id`,`student`.`name`,`department`.`department_name`,`student`.`current_semester` FROM `student`,`department` WHERE `student`.`prn` = '$prn' AND `student`.`status` = 'ONGOING' AND `student`.`department` = `department`.`id` AND `student`.`id` IN(SELECT DISTINCT `exam_registration`.`stud_id` FROM `exam_registration` WHERE `exam_registration`.`sesn_id` = '$sesn_id');";
		if($stud_sel_res = mysqli_query($dbcon,$stud_sel_query))
		{
			if(mysqli_num_rows($stud_sel_res) == 1)
			{
				$stud_sel_row = mysqli_fetch_assoc($stud_sel_res);
				$stud_id = $stud_sel_row['id'];
				$stud_name = $stud_sel_row['name'];
				$dep_name = $stud_sel_row['department_name'];
				$c_sem = $stud_sel_row['current_semester'];
				$course_sel_query = "SELECT `exam_registration`.`course_id`,`course`.`course_code`,`course`.`course_name` FROM `exam_registration`,`course` WHERE `exam_registration`.`sesn_id` = '$sesn_id' AND `stud_id` = '$stud_id' AND `exam_registration`.`course_id` = `course`.`id`";
				if($course_sel_res = mysqli_query($dbcon,$course_sel_query))
				{
					if(mysqli_num_rows($course_sel_res) > 0)
					{
?>
		<form method="POST" action="add_copy_case.php" onsubmit="return check_course_sel()">
			<fieldset>
				<input type="hidden" name="sesn_id" value="<?php echo $sesn_id; ?>">
				<input type="hidden" name="stud_id" value="<?php echo $stud_id ?>">
				<div class="row clearfix">
					<div class="col-sm-2">
						<div class="form-group">
                            <div>
                                <label>Name :</label> 
                            </div>
                        </div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
                            <div class="form-line">
                            	<input class="form-control" type="text" value="<?php echo $stud_name; ?>" readonly/>
                            </div>
                        </div>
					</div>
				</div>
				<div class="row clearfix">
				<div class="col-sm-2">
						<div class="form-group">
							<div>
								<label>Exam  :</label> 
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<div class="form-line">
								<select class="form-control show-tick" data-live-search="true" id="exam_name" name="exam_type" required>
								<option value="">---SELECT ---</option>
									<option value="1">In Semester Examination 1</option>
									<option value="2">In Semester Examination 2</option>
									<option value="5">End Semester Examination - Theory</option>
									<option value="6">End Semester Examination - Practical</option>
									<option value="7">MAKEUP END SEMESTER EXAMINATION THEORY</option>
									<option value="8">MAKEUP END SEMESTER EXAMINATION PRACTICAL</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="row clearfix">
					<div class="col-sm-2">
						<div class="form-group">
                            <div>
                                <label>Department :</label> 
                            </div>
                        </div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
                            <div class="form-line">
                            	<input class="form-control" type="text" value="<?php echo $dep_name; ?>" readonly/>
                            </div>
                        </div>
					</div>
				</div>
				<h2 class="card-inside-title">Check the course for which copycase is to be filed</h2>
<?php
						while($course_sel_row = mysqli_fetch_assoc($course_sel_res))
						{	
							$course_id = $course_sel_row['course_id'];
							$course_code = $course_sel_row['course_code'];
							$course_name = $course_sel_row['course_name'];
?>
				<div class=" row clearfix">
					<div class="col-sm-2 col-xs-1"></div>
					<div class="col-sm-6">
                        <input name="sublist[]" type="checkbox" class="filled-in" id="chk<?php echo $course_id ?>" value="<?php echo $course_id ?>" />
                        <label for="chk<?php echo $course_id ?>"><?php echo $course_code." : ".$course_name; ?></label>
	                </div>
	            </div>
<?php
						}
?>
				<div class="row clearfix">
					<div class="col-sm-2 col-xs-1"></div>
					<div class="col-sm-6">
						<input  class="btn btn-primary" type="submit" name="add_case" value="Add case">
					</div>
				</div>
			</fieldset>
		</form>
<?php
					}
					else
					{
						echo "No course Found for given prn in the select examination session";
					}
				}
			}
			elseif (mysqli_num_rows($stud_sel_res) > 1)
			{
				echo "Invalid conditions ! Contact Admin :( ";
			}
			else
			{
				echo "No student found for current examination";
			}
		}
	}
?>