
<?php 
	if (isset($_POST['assign_role'])) {
		
		$role_id = $_POST['role'];
		$user_type = $_POST['user_type'];
		$staff_type = $_POST['staff_type'];
		$assign_res = assign_role($role_id,$user_type,$staff_type);
		if ($assign_res == "success") {
			?>
			<script type="text/javascript">
				
				swal("Good Job!", "Successfully Registered", "success")
			</script>
			<?php
			unset($_POST);
			header( "refresh:1; url=assign_roles.php" );
		}
		else
		{
?>
		<script type="text/javascript">
			swal("Failed!", "<?php echo $assign_res ?>", "error")
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
                            <h2>Assign A Role</h2>
                            
                        </div>
                        <div class="body">
                            <form id="wizard_with_validation" action="assign_roles.php" method="POST">
                                <fieldset>
                                    <div class="row clearfix">
										<div class="col-sm-2">
											<div class="form-group">
												<div>
													<label>User Type : </label> 
												</div>
											</div>
										</div>
										<div class="col-md-6">
												<select class="form-control show-tick" id="user_type" name="user_type" required>
													<option value="">---SELECT ---</option>
													<?php 
															$sel_user_query = "SELECT `id`, `type_name` FROM `user_type`";
															if ($sel_res = mysqli_query($dbcon,$sel_user_query)) {
																	if(mysqli_num_rows($sel_res) > 0)
																	{
																		while ($row = mysqli_fetch_assoc($sel_res)) {
																		?>
																		<option value="<?php echo $row['id'] ?>"><?php echo $row['type_name'] ?></option>
																		<?php
																		}
																	}
																	else
																	{
																		?>
																		<option value="">No User Type Found</option>
																		<?php
																	}
																}
														?>
														</select>
										</div>
										</div>
                                    <div class="row clearfix">
										<div class="col-sm-2">
											<div class="form-group">
												<div>
													<label>Staff Type<br /> (If the user is staff *) </label> 
												</div>
											</div>
										</div>
										<div class="col-md-6">
												<select class="form-control show-tick" id="staff_type" name="staff_type" data-live-search="true" required>
													<option value="">---SELECT ---</option>
													<option value="0">***If Not staff***</option>
														<?php 
															$sel_user_query = "SELECT `id`, `staff_type_name` FROM `staff_type`";
															if ($sel_res = mysqli_query($dbcon,$sel_user_query)) {
																	if(mysqli_num_rows($sel_res) > 0)
																	{
																		while ($row = mysqli_fetch_assoc($sel_res)) {
																		?>
																		<option value="<?php echo $row['id'] ?>"><?php echo $row['staff_type_name'] ?></option>
																		<?php
																		}
																	}
																	else
																	{
																		?>
																		<option value="">No Staff Type Found</option>
																		<?php
																	}
																}
														?>
												</select>
											</div>
										</div>
										<div class="row clearfix">
										<div class="col-sm-2">
											<div class="form-group">
												<div>
													<label>Select Role </label> 
												</div>
											</div>
										</div>
										<div class="col-md-6">
												<select class="form-control show-tick" data-live-search="true" id="role" name="role" required>
													<option value="">---SELECT ---</option>
													<?php 
														$sel_user_query = "SELECT `id`, `role_name` FROM `roles`";
														if ($sel_res = mysqli_query($dbcon,$sel_user_query)) {
																if(mysqli_num_rows($sel_res) > 0)
																{
																	while ($row = mysqli_fetch_assoc($sel_res)) {
																	?>
																	<option value="<?php echo $row['id'] ?>"><?php echo $row['role_name'] ?></option>
																	<?php
																	}
																}
																else
																{
																	?>
																	<option value="">No Role Found</option>
																	<?php
																}
															}
													?>
												</select>
											</div>
										</div>			
										<div class="col-md-6">
										<br /><br />
										
										
										<input type="submit" name="assign_role" class="btn btn-primary waves-effect" value="Assign Role" >
										
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


    <script src="../plugins/bootstrap-notify/bootstrap-notify.js"></script>