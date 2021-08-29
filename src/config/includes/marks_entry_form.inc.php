<?php
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
		
		$query = "SELECT `student`.`id`,`student`.`prn`,`student`.`name`,`student`.`department`,`student`.`current_semester` FROM `student`,`course_assign`,`exam_registration`,`ses_conf` WHERE `student`.`status` = 'ONGOING' AND `course_assign`.`sub_id` = '$course' AND `course_assign`.`sem` = `student`.`current_semester` AND `course_assign`.`branch` = `student`.`department` AND exam_registration.stud_id = `student`.`id` AND `exam_registration`.`course_id` = `course_assign`.`sub_id` AND `exam_registration`.`sesn_id` = `ses_conf`.`current_session` AND `ses_conf`.`id` = '1' AND `exam_registration`.`conform_status` = '1' ";
		if ($res = mysqli_query($dbcon,$query)) {
			
			if (mysqli_num_rows($res) > 0) {
?>
    
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
										<th>SR No</th>
										<th>PRN</th>
										<th>Name</th>
										<th>Marks</th>
										<th>Absent</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
										<th>SR No</th>
										<th>PRN</th>
										<th>Name</th>
										<th>Marks</th>
										<th>Absent</th>
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
					<td><?php echo $i;?><input type="hidden" value="<?php echo $stud_id; ?>" name="stud_ids[]" />	</td>
					<td><?php echo $row['prn'];?></td>
					<td><?php echo $row['name'];?></td>
<?php
					if(check_ne($stud_id,$course,$exam))
					{
?>
					<td>
						<label>Not Elligible</label>
						<input type="hidden" name="ne_stud[]" value="<?php echo $stud_id; ?>">
					</td>
					<td>---</td>
<?php
					}
					else
					{
?>
					<td>
						<input type="number" min="0" max="<?php echo $max_marks; ?>" id="<?php echo "cid".$stud_id;?>" name="marks['<?php echo $stud_id; ?>']" required />
					</td>
					<td>
						<input type="checkbox" name="absent[]" id="<?php echo "status".$stud_id;?>" value="<?php echo $stud_id;?>"  class="chk-col-teal" onchange="change(this.id,'<?php echo "cid".$stud_id;?>')" />
                        <label for="<?php echo "status".$stud_id;?>"></label>
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
										
										<!--div class="col-sm-4">
											<input type="button" onclick="finalize()" name="finalize_marks" value="FINALIZE" class="btn bg-teal waves-effect"/> 
										</div-->
										<div class="col-sm-4">
											<input type="submit" name="marks_list" value="SAVE" class="btn bg-teal waves-effect"/> 
										</div>
							</div>                     
<?php
			} else {
				echo "No Students to display!!";
			}
			
		} else {
			echo "ERROR... ".mysqli_error($dbcon);
		}
?>