<?php
	$staff_id = $_SESSION['user_ref_id'];

	$query1 = "SELECT `class_teacher`.`branch`,`class_teacher`.`year`,`year2sem_relation`.`sem` FROM `class_teacher`,`year2sem_relation` WHERE `class_teacher_id`=$staff_id AND `class_teacher`.`year`=`year2sem_relation`.`year`";
	if ($res1 = mysqli_query($dbcon,$query1)) {
			
			if (mysqli_num_rows($res1) > 0) {
				
				while ($row1 = mysqli_fetch_assoc($res1)) {
					$department = $row1['branch'];
					$sem[] = $row1['sem'];
					
				}
			}
	}
	if (isset($_POST['save'])) {
		if(empty($_POST['student_list'])) 
		{
				?>
						<script type="text/javascript">
							swal("Failed!", "Nothing Selected", "error")
						</script>
				<?php
		}
		else
		{
			//print_r($_POST);
			$test= $_POST['student_list'];
			$N = count($test);
						
						for($i=0; $i < $N; $i++)
						{
							$id=$test[$i];
							$assign = conform_exam_reg($id);
							
						}
						if ($assign == "success") {
			
							?>
							<script type="text/javascript">
								
								swal("Good Job!", "Successfully Updated", "success")
							</script>
							<?php
							unset($_POST);
							header( "refresh:1; url=confirm_exam_reg.php" );
						}
						else 
						{
				?>
						<script type="text/javascript">
							swal("Failed!", "<?php echo $assign ?>", "error")
						</script>
				<?php
						}
		}
	}
?>

<section class="content">
<div class="container-fluid">
	<div class="row clearfix">	
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
							CONFIRM EXAM REGISTRATION
							</h2>
                            
                        </div>
                        <div class="body">
                            
								<form method = "POST" action = "confirm_exam_reg.php">
                                <fieldset>
									<?php
		
		$query = "SELECT `id`, `prn`, `name`,`department`, `current_semester`, `status` FROM `student`  WHERE `status` = 'ONGOING' AND `department`=$department AND (`current_semester` = $sem[0] OR `current_semester` = $sem[1]) ORDER BY `prn` ASC ";
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
									<!--	<th>EDIT</th> -->
										<th>CONFIRM</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
										<th>SR No</th>
										<th>PRN</th>
										<th>Name</th>
										<th>Courses</th>
										<!--<th>EDIT</th>-->
										<th>CONFIRM</th>
                                    </tr>
                                </tfoot>
                                <tbody>
<?php
				$i = 1;
				while ($row = mysqli_fetch_assoc($res)) {
					
					$check = exam_reg_conform_stat($row['id']);
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
								<!--<td><button class="btn bg-blue waves-effect" >EDIT</button></td>-->
								<td><input type="checkbox" id="<?php echo "sid".$row['id'];?>" value="<?php echo $row['id'];?>" name="student_list[]" class="chk-col-teal"  checked disabled />
											<label for="<?php echo "sid".$row['id'];?>"></label></td>
								<?php
							}
							elseif($check == 0)
							{
							?>
								<!--<td><button class="btn bg-blue waves-effect" >EDIT</button></td>-->
								<td><input type="checkbox" id="<?php echo "sid".$row['id'];?>" value="<?php echo $row['id'];?>" name="student_list[]" class="chk-col-teal"  />
											<label for="<?php echo "sid".$row['id'];?>"></label></td>
							<?php
							}
							else
							{
								?>
								<!--<td><button class="btn bg-blue waves-effect" disabled >EDIT</button></td>-->
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
				echo "No Students to display!!";
			}
		}
		
	
	
?>
                                
                                    									
								</fieldset>
								
							</form>
							</div>

<script>
function show()
{ 
      
}
</script>
							</div>
					</div>
		</div>
</div>
</section>