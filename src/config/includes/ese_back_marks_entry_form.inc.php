<?php
	
	$department = $_POST['department'];
	switch ($exam) {
			case '5':
				$course_info = "SELECT `th_mks_scheme`.`ese` FROM `pr_mks_scheme` WHERE `pr_mks_scheme`.`sub_id` = '$course' ";
				if($info_res = mysqli_query($dbcon,$course_info))
				{
					if(mysqli_num_rows($info_res) == 0)
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
					if(mysqli_num_rows($info_res) == 0)
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
		$sesn_id = get_sesn_id();
	
		 $query = "SELECT DISTINCT  `student`.`id` ,  `student`.`prn` ,  `student`.`name` ,  `student`.`department` ,  `student`.`current_semester` ,  `exam_registration`.`grade` 
			FROM  `student` ,  `course_assign` ,  `exam_registration` 
			WHERE  `student`.`status` =  'ONGOING'
			AND  `course_assign`.`sub_id` =  '$course'
			AND  `exam_registration`.`stud_id` =  `student`.`id` 
			AND  `exam_registration`.`course_id` =  `course_assign`.`sub_id` 
			AND  `exam_registration`.`conform_status` =  '1'
			AND  `exam_registration`.`result_flag` =  '0'
			AND  `exam_registration`.`grade_flag` =  '1'
			AND  `exam_registration`.`grade` =  'F'
			AND  `student`.`department` = $department
			";
		if ($res = mysqli_query($dbcon,$query)) {
			
			if (mysqli_num_rows($res) > 0) {
?>
							<p>BACKLOGS STUDENTS</p>
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
							                   
<?php
			} else {
				echo "</br>No Backlog Students to display!!";
			}
			?>
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
			echo "ERROR... ".mysqli_error($dbcon);
		}
?>