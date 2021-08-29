<?php
	if (isset($_POST['save'])) {
		if(empty($_POST['student_list'])) 
		{
			echo "empty";
		}
		else
		{
			//print_r($_POST);
			$test= $_POST['student_list'];
			$N = count($test);
						
						for($i=0; $i < $N; $i++)
						{
							$id=$test[$i];
							$assign = conform_exam_makeup_reg($id);
							
						}
						if ($assign == "success") {
			
							?>
							<script type="text/javascript">
								
								swal("Good Job!", "Successfully Updated", "success")
							</script>
							<?php
							unset($_POST);
							header( "refresh:10; url=confirm_makeup_exam_reg.php" );
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
							CONFORM MAKE-UP EXAM REGISTRATION
							</h2>
                            
                        </div>
                        <div class="body">
                            
								<form method = "POST" action = "confirm_makeup_exam_reg.php">
                                <fieldset>
								
								<div class="row clearfix">
									<div class="col-sm-3">
										<div class="form-group">
											<div>
												<label>Department : </label> 
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<select id="department" name="department" data-live-search="true" required>
												<option value="">---SELECT DEPARTMENT---</option>
												<?php
														$dep_sel_query = "SELECT `id`, `department_name` FROM `department`";
														if ($res = mysqli_query($dbcon,$dep_sel_query)) {
														if (mysqli_num_rows($res) > 0) {
																while ($row = mysqli_fetch_assoc($res)) {
												?>
												<option value="<?php echo $row['id']; ?>"><?php echo $row['department_name'];  ?></option>
												<?php				
																}
														}
														}				
												?>
										</select>

									</div>
								</div>
								<div class="row clearfix">
									<div class="col-sm-3">
											<div class="form-group">
												<div>
													<label>Semester: </label> 
												</div>
											</div>
										</div>
										<div class="col-md-6">
												<select  id="semester" name="semester" onchange="show_list()" required>
													<option value="">--SELECT--</option>
													<option value="1">I</option>
													<option value="2">II</option>
													<option value="3">III</option>
													<option value="4">IV</option>
													<option value="5">V</option>
													<option value="6">VI</option>
													<option value="7">VII</option>
													<option value="8">VIII</option>
												</select>
										</div>
									</div>
									 <div id="students_from_container">
											
									</div> 
									
								
								</fieldset>
								
							</form>
							</div>

		<script type="text/javascript">
				function show_list()
				{
					//$.blockUI({ message: '<img src="../assets/images/loader.gif" /> &nbsp;&nbsp;&nbsp; Just a moment...' });
					
					var department = document.getElementById('department').value;
					var sem = document.getElementById('semester').value;
					var xhttp = new XMLHttpRequest();
					xhttp.onreadystatechange = function() {
						if (this.readyState == 4 && this.status == 200) {
							document.getElementById('students_from_container').innerHTML = this.responseText; 
							$.unblockUI();
						}
					};
					xhttp.open("POST", "../config/ajax/confirm_makeup_exam_reg.php", true);
					xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
					xhttp.send("department="+department+"&sem="+sem);
				}
			</script>
			
							</div>
					</div>
		</div>
</div>
</section>