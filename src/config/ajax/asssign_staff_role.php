
<?php
	session_start();
	require_once "../dbconnect.php";
	require_once "../funlib/login_functions.php";
	if (isset($_POST['department']) && ( isLogin() != null)) {
		$depertment = $_POST['department'];
		$staff_sel_query = "SELECT `id`, `name` FROM `staff` WHERE `department` = '$depertment'";
		$contain_flag = false;
		if ($res = mysqli_query($dbcon,$staff_sel_query)) {
			if (mysqli_num_rows($res) > 0 ) {
?>
				<form action="assign_staff_roles.php" id="wizard_with_validation" method="POST">
							<div class="row clearfix">
										<div class="col-sm-2">
											<div class="form-group">
												<div>
													<label>Staff : </label> 
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<select id="staff" name="staff" data-live-search="true" required>
												<option value="">--SELECT STAFF--</option>
						<?php
										while ($row = mysqli_fetch_assoc($res)) {
											$staff_id = $row['id'];
											$staff_name = $row['name'];
						?>
												<option value="<?php echo $staff_id; ?>"><?php echo $staff_name; ?></option>
						<?php
										}
						?>
											</select>
										</div>
								</div>
							

							<div class="row clearfix">
										<div class="col-sm-2">
											<div class="form-group">
												<div>
													<label>Staff Role: </label> 
												</div>
											</div>
										</div>
										<div class="col-md-6">
											
												<select id="staff_type" name="staff_type" data-live-search="true" required>
													<option value="">--SELECT STAFF ROLE--</option>
							<?php
											$staff_type_sel_query="SELECT `id`, `staff_type_name` FROM `staff_type`";
											if ($staff_role_res = mysqli_query($dbcon,$staff_type_sel_query)) {
												if (mysqli_num_rows($staff_role_res) > 0) {
													while ($ro = mysqli_fetch_assoc($staff_role_res)) {
														$sid = $ro['id'];
														$sname = $ro['staff_type_name'];
							?>
													<option value="<?php echo $sid; ?>"><?php echo $sname; ?></option>
							<?php
													}
												} else {
							?>
													<option value="">NO STAFF TYPE FOUND</option>
							<?php						
												}
												
											} else {
							?>
													<option value="">ERROR...</option>
							<?php
											}
											
							?>
												</select>
										</div>
					</div>
									<div class="row clearfix">
										
										<div class="col-md-6" align="center">
											<div class="form-group">
												<input type="submit" name="assign_staff_role" value="Assign" class="btn btn-primary waves-effect" />
											</div>
										</div>
										
									</div>
					</form>
				
				
<?php
			} else {
				echo "No staff has been added yet for this department!!";
			}
			
		} else {
			echo mysqli_error($dbcon);
		}
		
	}
	
?>
