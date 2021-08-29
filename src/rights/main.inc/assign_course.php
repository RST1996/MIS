<?php
	//print_r($_SESSION);
	$cur_acc_yr  = get_current_acyr();
	$query = "SELECT `academic_year` FROM `academic_year` WHERE `ac_id` = '$cur_acc_yr'";
	if ($res = mysqli_query($dbcon,$query)) {
			if (mysqli_num_rows($res) == 1) {
				$row = mysqli_fetch_assoc($res);
				$acc_yr_name = $row['academic_year'];
			}
	}
	
	if (isset($_POST['assign_course'])) {
		$sub_id = clean_ip($_POST["sub"]);
		$sem = clean_ip($_POST["sem"]);
		$branch = clean_ip($_POST["branch"]);
		$assign_course  = assign_course($sub_id,$sem,$branch,$cur_acc_yr);
		
		if ($assign_course == "success") {
			?>
			<script type="text/javascript">
				
				swal("Good Job!", "Successfully Registered", "success")
			</script>
			<?php
			unset($_POST);
			header( "refresh:1; url=assign_course.php" );
		}
		else
		{
?>
		<script type="text/javascript">
			swal("Failed!", "<?php echo $assign_course ?>", "error")
		</script>
<?php
		}
	}
?>

<section class="content">
<div class="container-fluid">
	<div class="row clearfix"></div>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
        	<div class="header">
				<h2>Assign Course</h2>
			</div>
			<div class="body">
				<form id="wizard_with_validation" action="assign_course.php" method="POST">
					<fieldset>
						<div class="row clearfix">
										<div class="col-sm-2">
											<div class="form-group">
												<div>
													<label for="sub">Subject :</label> 
												</div>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<div class="form-line">
													<select id="sub" name="sub" class="form-control show-tick" data-live-search="true" required>
														<option value="">---SELECT SUBJECT---</option>
														<?php
															$dep_sel_query = "SELECT `id`, `course_code`, `course_name` FROM `course`";
															if ($res = mysqli_query($dbcon,$dep_sel_query)) {
																if (mysqli_num_rows($res) > 0) {
																	while ($row = mysqli_fetch_assoc($res)) {
														?>
														<option value="<?php echo $row['id']; ?>"><?php echo $row['course_code']." : ".$row['course_name'];  ?></option>
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
										<div class="col-sm-2">
											<div class="form-group">
												<div>
													<label for="sub">Academic year :</label> 
												</div>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<div class="form-line">
													<input type="text" name="name" value="<?php echo $acc_yr_name;  ?>" class="form-control" readonly>
												</div>
											</div>
										</div>
										
						</div>
						
						<div class="row clearfix">
										<div class="col-sm-2">
											<div class="form-group">
												<div>
													<label for="sem">Semester :</label> 
												</div>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<div class="form-line">
														<select id="sem" name="sem" class="form-control show-tick" data-live-search="true" required>
															<option value="">---SELECT SEMESTER---</option>
															<option value="1">SEM I</option>
															<option value="2">SEM II</option>
															<option value="3">SEM III</option>
															<option value="4">SEM IV</option>
															<option value="5">SEM V</option>
															<option value="6">SEM VI</option>
															<option value="7">SEM VII</option>
															<option value="8">SEM VIII</option>
														</select>
												</div>
											</div>
										</div>
										
						</div>
						<div class="row clearfix">
										<div class="col-sm-2">
											<div class="form-group">
												<div>
													<label for="branch">Department :</label> 
												</div>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<div class="form-line">
														<select id="branch" name="branch" class="form-control show-tick" data-live-search="true" required>
																<option value="">---SELECT DEPARTMENT---</option>
																<?php
																	$dep_sel_query = "SELECT `id`, `department_name` FROM `department` WHERE 1";
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
						<input type="submit" name="assign_course" class="btn btn-primary waves-effect" value="Assign Course">
					</fieldset>
				</form>
			</div>
		</div>
	</div>
</div>
</section>
<script type="text/javascript">
	function showform()
	{
		var ctype = document.getElementById('course_type').value;
		var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        	if (this.readyState == 4 && this.status == 200) {
        		document.getElementById('mks_form').innerHTML = this.responseText; 
        	}
        };
        xhttp.open("POST", "../config/ajax/add_course.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("ctype="+ctype);

	}
</script>