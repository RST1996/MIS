<?php
	
	switch ($exam) {	
			case '5':
				
				$course_info = "SELECT `th_mks_scheme`.`ese` FROM `th_mks_scheme` WHERE `th_mks_scheme`.`sub_id` = '$course' ";
				if($info_res = mysqli_query($dbcon,$course_info))
				{
					if(mysqli_num_rows($info_res) > 0)
					{
						$r = mysqli_fetch_assoc($info_res);
						$max_marks = $r['ese'];
						
					}
				}
				break;
			case '6':
				$course_info = "SELECT `pr_mks_scheme`.`ese` FROM `pr_mks_scheme` WHERE `pr_mks_scheme`.`sub_id` = '$course' ";
				if($info_res = mysqli_query($dbcon,$course_info))
				{
					if(mysqli_num_rows($info_res) > 0)
					{
						$r = mysqli_fetch_assoc($info_res);
						$max_marks = $r['ese'];
					}
				}
				break;	
			default:
				//echo "Invalid Exam type";
				die("Invalid Exam Request ... Plz contact Admin..!!");
				break;
		}
		if($exam == 5)
		
			$query = "SELECT `student`.`id`,`student`.`prn`,`student`.`name`,`student`.`department`,`student`.`current_semester`,`marks_th_ese`.`marks`,`marks_th_ese`.`ne_flag`,`marks_th_ese`.`ab_flag` FROM `student`,`course_assign`,`exam_registration`,`ses_conf`,`marks_th_ese` WHERE `student`.`status` = 'ONGOING' AND `course_assign`.`sub_id` = '$course' AND `course_assign`.`sem` = `student`.`current_semester` AND `course_assign`.`branch` = `student`.`department` AND exam_registration.stud_id = `student`.`id` AND `exam_registration`.`course_id` = `course_assign`.`sub_id` AND `exam_registration`.`sesn_id` = `ses_conf`.`current_session` AND `exam_registration`.`conform_status` = '1' AND `ses_conf`.`id` = '1' AND `marks_th_ese`.`sesn_id` = `ses_conf`.`current_session` AND `student`.`id` = `marks_th_ese`.`stud_id` AND `marks_th_ese`.`course_id` = '$course' AND `marks_th_ese`.`exam_type` = '$exam' AND `student`.`department` = '$department'";
		else if($exam == 6)
			$query = "SELECT `student`.`id`,`student`.`prn`,`student`.`name`,`student`.`department`,`student`.`current_semester`,`marks_pr_ese`.`marks`,`marks_pr_ese`.`ne_flag`,`marks_pr_ese`.`ab_flag` FROM `student`,`course_assign`,`exam_registration`,`ses_conf`,`marks_pr_ese` WHERE `student`.`status` = 'ONGOING' AND `course_assign`.`sub_id` = '$course' AND `course_assign`.`sem` = `student`.`current_semester` AND `course_assign`.`branch` = `student`.`department` AND exam_registration.stud_id = `student`.`id` AND `exam_registration`.`course_id` = `course_assign`.`sub_id` AND `exam_registration`.`sesn_id` = `ses_conf`.`current_session` AND `exam_registration`.`conform_status` = '1' AND `ses_conf`.`id` = '1' AND `marks_pr_ese`.`sesn_id` = `ses_conf`.`current_session` AND `student`.`id` = `marks_pr_ese`.`stud_id` AND `marks_pr_ese`.`course_id` = '$course' AND `marks_pr_ese`.`exam_type` = '$exam' AND `student`.`department` = '$department'";
		if ($res = mysqli_query($dbcon,$query)) {
			
			if (mysqli_num_rows($res) > 0) {
?>
    						<input type="hidden" id="max_marks" value="<?php echo $max_marks; ?>" />
							<p>REGULAR STUDENTS</p>
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
										<th>SR No</th>
										<th>PRN</th>
										<th>Name</th>
										<th>Marks</th>
										<th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
										<th>SR No</th>
										<th>PRN</th>
										<th>Name</th>
										<th>Marks</th>
										<th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
<?php
				$i = 1;
				while ($row = mysqli_fetch_assoc($res)) {
					$stud_id = $row['id'];
					$prn = $row['prn'];
					$stud_name = $row['name'];
?>
				<tr>
					<td><?php echo $i;?>
					<td><?php echo $row['prn'];?></td>
					<td><?php echo $row['name'];?></td>
<?php
					if($row['ne_flag'] == 1)
					{
?>
					<td>
						<label>Not Elligible</label>
					</td>
					<td>---</td>
<?php
					}
					else if($row['ab_flag'] == 1)
					{
?>
					<td id="marks.<?php echo $stud_id; ?>">
						<label>AB</label>
					</td>
					<td id="act.<?php echo $stud_id; ?>">
						<input type="button" class="btn bg-teal waves-effect" onclick="edit_marks('marks.<?php echo $stud_id; ?>','act.<?php echo $stud_id; ?>','<?php echo $stud_id; ?>')" value="EDIT" />
                    </td>
<?php
					}
					else
					{
?>
					<td id="marks.<?php echo $stud_id; ?>">
						<label><?php echo $row['marks'] ?></label>
					</td>
					<td id="act.<?php echo $stud_id; ?>">
						<input class="btn bg-teal waves-effect" type="button" onclick="edit_marks('marks.<?php echo $stud_id; ?>','act.<?php echo $stud_id; ?>','<?php echo $stud_id; ?>')" value="EDIT" />
                    </td>
<?php						
					}
					
?>					
				</tr>
<?php
					
				
				$i++;
				}
?>
                                </tbody>
                            </table>
							<div class="row clearfix">
							<!--
										<div class="col-sm-4">
											<!--input type="submit" name="marks_list" value="SAVE" class="btn bg-teal waves-effect"/ > 
										</div>
										<div class="col-sm-4">
											<input type="button" onclick="finalize()" name="finalize_marks" value="FINALIZE" class="btn bg-teal waves-effect"/> 
										</div>
										-->
							</div>                     
<?php
			} else {
				echo "No Regular Students to display!!";
			}
			
		} else {
			echo "ERROR... ".mysqli_error($dbcon);
		}
?>