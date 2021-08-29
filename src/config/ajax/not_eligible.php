
<?php
	session_start();
	require_once "../dbconnect.php";
	require_once "../funlib/login_functions.php";
	require_once "../funlib/not_elligible_functions.php";
	require_once "../funlib/lock_management_function.php";
	
	if (isset($_POST['course']) && isset($_POST['exam']) && ( isLogin() != null)) {
		$course = $_POST['course'];
		$exam = $_POST['exam'];
		$sesn_id = get_sesn_id();
		//$lock = check_lock($course,$exam);
		if(check_ne_lock($sesn_id,$course,$exam))
		{
			echo "<h4>Not Elligible List is Locked.</h4>";
			require_once "generate_ne_report.php";
			
			
		}
		else
		{	
			$query = "SELECT `student`.`id`,`student`.`prn`,`student`.`name`,`student`.`department`,`student`.`current_semester` FROM `student`,`course_assign`,`exam_registration`,`ses_conf` WHERE `student`.`status` = 'ONGOING' AND `course_assign`.`sub_id` = '$course' AND `course_assign`.`sem` = `student`.`current_semester` AND `course_assign`.`branch` = `student`.`department` AND  exam_registration.stud_id = `student`.`id` AND `exam_registration`.`course_id` = `course_assign`.`sub_id` AND `exam_registration`.`sesn_id` = `ses_conf`.`current_session` AND `ses_conf`.`id` = '1' AND `exam_registration`.`conform_status` = '1'";
			if ($res = mysqli_query($dbcon,$query)) {
				
				if (mysqli_num_rows($res) > 0) {
?>
    
                            <table class="table table-bordered table-striped table-hover ">
                                <thead>
                                    <tr>
										<th>SR No</th>
										<th>PRN</th>
										<th>Name</th>
										<th>Not Elligible</th>
										<th>Remark</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
										<th>SR No</th>
										<th>PRN</th>
										<th>Name</th>
										<th>Not Elligible</th>
										<th>Remark</th>
                                    </tr>
                                </tfoot>
                                <tbody>
<?php
				$i = 1;
				while ($row = mysqli_fetch_assoc($res)) {
					
				if(check($row['id'],$course,$exam))
				{
					$id = $row['id'];
					$sesn_id = get_sesn_id();
					$get_data = mysqli_query($dbcon,"SELECT `reason` FROM `ne_list` WHERE `sesn_id` = '$sesn_id' AND `stud_id` = '$id' AND `course_id` = '$course' AND `exam_id` = '$exam'");
					while ($data = mysqli_fetch_assoc($get_data)) {
					
					?>
				<tr>
					<td><?php echo $i;?></td>
					<td><?php echo $row['prn'];?></td>
					<td><?php echo $row['name'];?></td>
					<td><input type="checkbox" id="<?php echo "cid".$row['id'];?>" value="<?php echo $row['id'];?>" name="student_list[]" class="chk-col-teal" onchange="change(this.id,'<?php echo "rid".$row['id'];?>')" checked />
                                <label for="<?php echo "cid".$row['id'];?>"></label></td>
					<td><input id="<?php echo "rid".$row['id'];?>" value="<?php echo $data['reason'];?>"type="textbox" name="reason[]" required disabled/>
					
				</tr>
<?php
					}
				}else{
?>

				<tr>
					<td><?php echo $i;?></td>
					<td><?php echo $row['prn'];?></td>
					<td><?php echo $row['name'];?></td>
					<td><input type="checkbox" id="<?php echo "cid".$row['id'];?>" value="<?php echo $row['id'];?>" name="student_list[]" class="chk-col-blue" onchange="change(this.id,'<?php echo "rid".$row['id'];?>')" />
                                <label for="<?php echo "cid".$row['id'];?>"></label></td>
					<td><input id="<?php echo "rid".$row['id'];?>" type="textbox" name="reason[]" required disabled /></td>
				</tr>
<?php
					
				}
				$i++;
				}
?>
                                </tbody>
                            </table>
							<div class="row clearfix">
										<div class="col-sm-4">
											<input type="submit" name="not_eligible" value="SAVE" class="btn bg-teal waves-effect"/> 
										</div>
										<div class="col-sm-4">
											<input type="button" id="conf_btn" name="conform_not_eligible" onclick="finalize()" value="FINALIZE" class="btn bg-teal waves-effect"/> 
										</div>
							</div>
							
							
                        
<?php
			} else {
				echo "No Students to display!!";
			}
			
		} else {
			echo "ERROR... ".mysqli_error($dbcon);
		}

	}
	}
	
?>
