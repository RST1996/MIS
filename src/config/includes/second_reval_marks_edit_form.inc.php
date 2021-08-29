<?php
		
		$query = "SELECT `student`.`id`,`student`.`prn`,`student`.`name`,`marks_th_ese`.`sec_reval_marks` FROM `student`,`reval_registration`,`marks_th_ese` WHERE `reval_registration`.`sesn_id`='$sesn_id' AND `reval_registration`.`sesn_id` = `marks_th_ese`.`sesn_id` AND `reval_registration`.`stud_id` = `student`.`id` AND `marks_th_ese`.`stud_id` = `reval_registration`.`stud_id` AND `reval_registration`.`course_id` = `marks_th_ese`.`course_id` AND `reval_registration`.`course_id` = '$course' AND `reval_registration`.`exam_type` = '$exam_id' AND `reval_registration`.`conf_flag` = '1' AND `student`.`department` = '$dept' AND `marks_th_ese`.`reval_flag` = '1' AND `marks_th_ese`.`reval_marks` <> '-1' AND ABS(`marks_th_ese`.`marks` - `marks_th_ese`.`reval_marks`) >= $recheck_limit";

		if ($res = mysqli_query($dbcon,$query)) {
			
			if (mysqli_num_rows($res) > 0) {
?>
    						<input type="hidden" id="max_marks" value="<?php echo $max_marks; ?>" />
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

					<td id="marks.<?php echo $stud_id; ?>">
						<label><?php echo $row['sec_reval_marks'] ?></label>
					</td>
					<td id="act.<?php echo $stud_id; ?>">
						<input class="btn bg-teal waves-effect" type="button" onclick="edit_marks('marks.<?php echo $stud_id; ?>','act.<?php echo $stud_id; ?>','<?php echo $stud_id; ?>')" value="EDIT" />
                    </td>
				
				</tr>
<?php
					
				
				$i++;
				}
?>
                                </tbody>
                            </table>
							<div class="row clearfix">
										<div class="col-sm-4">
											<!--input type="submit" name="marks_list" value="SAVE" class="btn bg-teal waves-effect"/ --> 
										</div>
										<div class="col-sm-4">
											<input type="button" onclick="finalize()" name="finalize_marks" value="FINALIZE" class="btn bg-teal waves-effect"/> 
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