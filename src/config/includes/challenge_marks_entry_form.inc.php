<?php
	$course_info = "SELECT `th_mks_scheme`.`ese` FROM `th_mks_scheme` WHERE `th_mks_scheme`.`sub_id` = '$course' ";
	if($info_res = mysqli_query($dbcon,$course_info))
	{
		if(mysqli_num_rows($info_res) == 1)
		{
			$r = mysqli_fetch_assoc($info_res);
			$max_marks = $r['ese'];
		}
	}
		
		$query = "SELECT `student`.`id`,`student`.`prn`,`student`.`name` FROM `student`,`reval_registration`,`marks_th_ese` WHERE `reval_registration`.`sesn_id`='$sesn_id' AND `reval_registration`.`sesn_id` = `marks_th_ese`.`sesn_id` AND `reval_registration`.`stud_id` = `student`.`id` AND `marks_th_ese`.`stud_id` = `reval_registration`.`stud_id` AND `reval_registration`.`course_id` = `marks_th_ese`.`course_id` AND `reval_registration`.`course_id` = '$course' AND `reval_registration`.`exam_type` = '$exam_id' AND `reval_registration`.`conf_flag` = '1' AND `student`.`department` = '$dept' AND `reval_registration`.`challenge_flag` = '1' AND `reval_registration`.`challenge_conf_flag` = '1' ";
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
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
										<th>SR No</th>
										<th>PRN</th>
										<th>Name</th>
										<th>Marks</th>
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

					<td>
						<input type="number" min="0" max="<?php echo $max_marks; ?>" id="<?php echo "cid".$stud_id;?>" name="marks[<?php echo $stud_id; ?>]" required />
					</td>
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