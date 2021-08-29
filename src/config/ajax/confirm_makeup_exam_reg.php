<?php
	session_start();
	require_once "../dbconnect.php";
	require_once "../funlib/login_functions.php";
	//require_once "../funlib/not_elligible_functions.php";
	require_once "../funlib/makeup_exam_reg_functions.php";
	
	
	$department = $_POST['department'];
	$sem  = $_POST['sem'];
	
	
		
		$query = "SELECT `id`, `prn`, `name`,`department`, `current_semester`, `status` FROM `student`, `makeup_registration`  WHERE `status` = 'ONGOING' AND `department`=$department  AND `current_semester` = $sem AND  `makeup_registration`.`stud_id` = `id` ORDER BY `prn` ASC ";
		$sesn_id = get_cur_sesn_id();
		
		if ($res = mysqli_query($dbcon,$query)) {
			
			if (mysqli_num_rows($res) > 0) {
?>
                            <table class="table table-bordered table-striped table-hover ">
                                <thead>
                                    <tr>
										<th>SR No</th>
										<th>PRN</th>
										<th>Name</th>
										<th>Courses</th>
									
										<th>CONFORM</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
										<th>SR No</th>
										<th>PRN</th>
										<th>Name</th>
										<th>Courses</th>
										
										<th>CONFORM</th>
                                    </tr>
                                </tfoot>
                                <tbody>
<?php
				$i = 1;
				while ($row = mysqli_fetch_assoc($res)) {
					
					$check = makeup_exam_reg_conform_stat($row['id']);
					$courses = get_courses($row['id']);
					
?>					
				
				<tr>
							<td><?php echo $i;?></td>
							<td><?php echo $row['prn'];?></td>
							<td><?php echo $row['name'];?></td>
							<td style="word-break:break-all;" ><?php echo $courses;?></td>
					
							<?php
							if($check == 1)
							{
								?>
							<!--	<td><button class="btn bg-blue waves-effect" >EDIT</button></td> -->
								<td><input type="checkbox" id="<?php echo "sid".$row['id'];?>" value="<?php echo $row['id'];?>" name="student_list[]" class="chk-col-teal"  checked disabled />
											<label for="<?php echo "sid".$row['id'];?>"></label></td>
								<?php
							}
							elseif($check == 0)
							{
							?>
							<!--	<td><button class="btn bg-blue waves-effect" >EDIT</button></td> -->
								<td><input type="checkbox" id="<?php echo "sid".$row['id'];?>" value="<?php echo $row['id'];?>" name="student_list[]" class="chk-col-teal"  />
											<label for="<?php echo "sid".$row['id'];?>"></label></td>
							<?php
							}
							else
							{
								?>
							<!--	<td><button class="btn bg-blue waves-effect" disabled >EDIT</button></td> -->
								<td><input type="checkbox" id="<?php echo "sid".$row['id'];?>" value="<?php echo $row['id'];?>" name="student_list[]" class="chk-col-teal" disabled  />
											<label for="<?php echo "sid".$row['id'];?>"></label></td>
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
										<div class="col-sm-4" align="center">
											<input type="submit" name="save" value="SAVE" class="btn bg-teal waves-effect"/> 
										</div>
										
							</div>
							
                        
<?php
			
			} else {
				echo "No Students applied for Makeup Exam !!";
			}
		}
		
	