<?php
	if (isset($_POST['assign_course_teacher'])) {
		$sem  = $_POST['sem'];
		$dept = $_POST['department'];
		$sub_id = $_POST['course'];
		$staff_id = $_POST['staff'];
		$assign = assign_course_teacher($sem,$dept,$sub_id,$staff_id);
		if ($assign == "success") {
			
			?>
			<script type="text/javascript">
				
				swal("Good Job!", "Successfully Registered", "success")
			</script>
			<?php
			unset($_POST);
			header( "refresh:1; url=assign_course_teacher.php" );
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
?>


<section class="content">
<div class="container-fluid">
	<div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
							Assign A Course Teacher
							</h2>
                            
                        </div>
                        <div class="body">
                            
								<form method = "POST" action = "assign_course_teacher.php">
                                <fieldset>
									<div class="row clearfix">
										<div class="col-sm-3">
											<div class="form-group">
												<div>
													<label>Select Semester : </label> 
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<select id="sem" name="sem" data-live-search="true" required>
												<option>--SELECT SEM--</option>
												<option value="1">I </option>
												<option value="2"> II </option>
												<option value="3"> III</option>
												<option value="4"> IV </option>
												<option value="4"> V </option>
												<option value="4"> VI </option>
												<option value="4"> VII </option>
												<option value="4"> VIII </option>
											</select>

										</div>
										
									</div>
                                    <div class="row clearfix">
									<div class="col-sm-3">
											<div class="form-group">
												<div>
													<label>Department: </label> 
												</div>
											</div>
										</div>
									<div class="col-sm-4">
											<div class="form-group">
												<div class="form-line">
													<select id="department" name="department" onchange = "assign()" data-live-search="true" required>
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
										</div>
										</div>
                                    <div class="row clearfix">
										<div class="col-sm-3">
											<div class="form-group">
												<div>
													<label>Course : </label> 
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<select id="course" name="course" data-live-search="true" required>
													<option> -- SELECT COURSE -- </option>
											<?php
											print_r($_POST);
												$course_query = "SELECT `course`.`id`,`course`.`course_code`,`course`.`course_name` FROM `course`";
												if ($res = mysqli_query($dbcon,$course_query)) {
													while ($row = mysqli_fetch_assoc($res)) {
											?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['course_code'].": ".$row['course_name']; ?></option>
											<?php
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
													<label>Teacher : </label> 
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<select id="staff" name="staff" data-live-search="true" required>
													<option> -- SELECT COURSE TEACHER -- </option>
											<?php
												$coordinator_query = "SELECT `staff`.`id`,`staff`.`name` FROM `staff`,`staff_role` WHERE `staff_role`.`staff_id` = `staff`.`id` AND `staff_role`.`staff_type_id` = '6'";
												if ($res = mysqli_query($dbcon,$coordinator_query)) {
													while ($row = mysqli_fetch_assoc($res)) {
											?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
											<?php
													}
												}
											?>
										</select>
										</div>
										
									</div>
									<div class="row clearfix">
										<div class="col-sm-6">
											<div class="form-group">
												<div>
														<input type="submit" class="btn btn-primary waves-effect" name="assign_course_teacher" value="Assign" />
												</div>
											</div>
										</div>
									</div>
								</fieldset>
								
							</form>
							</div>
							</div>
					</div>
		</div>
</div>
</section>
<script>
function assign()
{
		var department = document.getElementById('department').value;
		var sem = document.getElementById('sem').value;
		
		var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        	if (this.readyState == 4 && this.status == 200) {
        		document.getElementById('view_from_container').innerHTML = this.responseText; 
        	}
        };
        xhttp.open("POST", "../rights/main.inc/assign_course_teacher.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("department="+department+"&sem ="+sem);
}
</script>