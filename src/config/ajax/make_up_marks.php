<?php
	session_start();
	require_once "../dbconnect.php";
	require_once "../funlib/login_functions.php";
	//require_once "../funlib/not_elligible_functions.php";
	require_once "../funlib/marks_entry_functions.php";
	
	if (isset($_POST['course']) && isset($_POST['exam']) && ( isLogin() != null)) {
		$course = $_POST['course'];
		$exam = $_POST['exam'];
		$sesn_id = get_sesn_id();

		switch ($exam) {
			case '1':
				$course_info = "SELECT `th_mks_scheme`.`ise1` FROM `th_mks_scheme` WHERE `th_mks_scheme`.`sub_id` = '$course' ";
				if($info_res = mysqli_query($dbcon,$course_info))
				{
					if(mysqli_num_rows($info_res) == 1)
					{
						$r = mysqli_fetch_assoc($info_res);
						$max_marks = $r['ise1'];
					}
				}
				break;
			case '2':
				$course_info = "SELECT `th_mks_scheme`.`ise2` FROM `th_mks_scheme` WHERE `th_mks_scheme`.`sub_id` = '$course' ";
				if($info_res = mysqli_query($dbcon,$course_info))
				{
					if(mysqli_num_rows($info_res) == 1)
					{
						$r = mysqli_fetch_assoc($info_res);
						$max_marks = $r['ise2'];
					}
				}
				break;
			case '3':
				$course_info = "SELECT `th_mks_scheme`.`isa` FROM `th_mks_scheme` WHERE `th_mks_scheme`.`sub_id` = '$course' ";
				if($info_res = mysqli_query($dbcon,$course_info))
				{
					if(mysqli_num_rows($info_res) == 1)
					{
						$r = mysqli_fetch_assoc($info_res);
						$max_marks = $r['isa'];
					}
				}
				break;
			case '4':
				$course_info = "SELECT `pr_mks_scheme`.`ica` FROM `pr_mks_scheme` WHERE `pr_mks_scheme`.`sub_id` = '$course' ";
				if($info_res = mysqli_query($dbcon,$course_info))
				{
					if(mysqli_num_rows($info_res) == 0)
					{
						$r = mysqli_fetch_assoc($info_res);
						$max_marks = $r['ica'];
					}
				}
				break;			
			default:
				//echo "Invalid Exam type";
				die("Invalid Exam Request ... Plz contact Admin..!!");
				break;
		}

		if(/*locked check function */ false)
		{
			echo "Marks has been locked !!";
		}
		else
		{
			$student_query = "SELECT DISTINCT `student`.`id`, `student`.`prn`,`student`.`name`,`marks_others`.`marks` FROM `student`,`exam_registration`,`marks_others`,`makeup_registration` WHERE `student`.`id` = `exam_registration`.`stud_id` AND `student`.`id` = `marks_others`.`stud_id` AND `exam_registration`.`sesn_id` = `marks_others`.`sesn_id` AND `marks_others`.`sesn_id` = '$sesn_id' AND `exam_registration`.`course_id`  = `marks_others`.`course_id` AND `marks_others`.`course_id` = '$course' AND `exam_registration`.`conform_status` = '1'  AND `marks_others`.`exam_type` = '$exam' AND `marks_others`.`ab_flag` = '1' AND `makeup_registration`.`sesn_id` = `marks_others`.`sesn_id` AND `makeup_registration`.`stud_id` = `marks_others`.`stud_id` AND `makeup_registration`.`course_id` = `marks_others`.`course_id` AND `makeup_registration`.`exam_type` = `marks_others`.`exam_type` AND `makeup_registration`.`conf_flag` = '1'";
			if($res = mysqli_query($dbcon,$student_query))
			{
				if (mysqli_num_rows($res) > 0) {
?>
							<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
										<th>PRN</th>
										<th>Name</th>
										<th>Marks</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
										<th>PRN</th>
										<th>Name</th>
										<th>Marks</th>
                                    </tr>
                                </tfoot>
                                <tbody>
<?php
						while($row = mysqli_fetch_assoc($res))
						{
							$stud_id = $row['id'];
?>
									<tr>
										<td><?php echo $row['prn']; ?><input type="hidden" value="<?php echo $stud_id; ?>" name="stud_ids[]" /></td>
										<td><?php echo $row['name']; ?></td>
										<td><input type="number" min="0" max="<?php echo $max_marks; ?>" name="marks[<?php echo $stud_id; ?>]" value="<?php echo $row['marks'] ?>" required /></td>
									</tr>
<?php
						}
?>
                                </tbody>
                            </table>
                            <div class="row clearfix">
										<div class="col-sm-4">
											<input type="submit" name="marks_list" value="SAVE" class="btn bg-teal waves-effect"/> 
										</div>
										<div class="col-sm-4">
											<input type="button" onclick="finalize()" name="finalize_marks" value="FINALIZE" class="btn bg-teal waves-effect"/> 
										</div>
							</div>                   
<?php
				} else {
					echo "No Students for makeup marks entry!!";
				}
				
			}
			else
			{
				die("failed to access resources.. contact admin..!");
			}
		}	
	}
?>

