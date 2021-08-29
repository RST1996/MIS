<?php 
	if (isset($_POST['add_activity'])) 
	{	
		$activity_id = $_POST['activity'];
		$start = $_POST['start'];
		$end = $_POST['end'];
		$assign_res = add_activity($activity_id,$start,$end);
		if ($assign_res == "success") 
		{
			?>
			<script type="text/javascript">
				
				swal("Good Job!", "Successfully Assigned!", "success")
			</script>
			<?php
			unset($_POST);
			header( "refresh:1; url=manage_activity.php" );
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
                            <h2>Start New Activity</h2>    
                        </div>
                        <div class="body">
                            <form id="wizard_with_validation" action="manage_activity.php" method="POST">
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
												<select class="form-control show-tick" id="activity" data-live-search="true" name="activity" required>
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
													<label>Start Time: </label> 
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
		                                        <div class="form-line">
		                                            <input type="text" name="start" id="start" class="datetimepicker form-control" placeholder="Please choose date & time...">
		                                        </div>
		                                    </div>	
										</div>
									</div>
									<div class="row clearfix">
										<div class="col-sm-2">
											<div class="form-group">
												<div>
													<label>Stop Time: </label> 
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
		                                        <div class="form-line">
		                                            <input type="text" name="end" id="end" class="datetimepicker form-control" placeholder="Please choose date & time...">
		                                        </div>
		                                    </div>	
										</div>
									</div>			
									<div class="col-md-6">
										<br /><br />
										
										
										<input type="submit" name="add_activity" class="btn btn-primary waves-effect" value="Assign" >
										
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
    <script type="text/javascript">
		$('.datetimepicker').bootstrapMaterialDatePicker({
	        format: 'YYYY-MM-DD HH:mm:ss',
	        clearButton: true,
	        weekStart: 1
	    });
    </script>