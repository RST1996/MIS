
<?php 
	if (isset($_POST['assign'])) {
		
		$role_id = $_POST['role'];
		$activity_id = $_POST['activity'];
		$assign_res = assign_role_to_activity($activity_id,$role_id);
		if ($assign_res == "success") {
			?>
			<script type="text/javascript">
				
				swal("Good Job!", "Successfully Assigned!", "success")
			</script>
			<?php
			unset($_POST);
			header( "refresh:1; url=assign_role_to_activity.php" );
		}
		else
		{
?>
		<script type="text/javascript">
			swal("Failed!", "<?php echo $assign_res; ?>", "error")
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
                            <h2>Assign Role to Activity</h2>
                            
                        </div>
                        <div class="body">
                            <form id="wizard_with_validation" action="assign_role_to_activity.php" method="POST">
                                <fieldset>
                                    <div class="row clearfix">
										<div class="col-sm-2">
											<div class="form-group">
												<div>
													<label>Activity : </label> 
												</div>
											</div>
										</div>
										<div class="col-md-6">
												<select class="form-control show-tick" data-live-search="true" id="activity" name="activity" required>
													<option value="">---SELECT ---</option>
													<?php 
															$sel_user_query = "SELECT * FROM `activities`";
															if ($sel_res = mysqli_query($dbcon,$sel_user_query)) {
																	if(mysqli_num_rows($sel_res) > 0)
																	{
																		while ($row = mysqli_fetch_assoc($sel_res)) {
																		?>
																		<option value="<?php echo $row['id'] ?>"><?php echo $row['name'] ?></option>
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
										
										
										<input type="submit" name="assign" class="btn btn-primary waves-effect" value="Assign" >
										
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