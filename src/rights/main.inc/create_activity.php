<section class="content">
<div class="container-fluid">
<?php
	if (isset($_POST['create_activity']) && isset($_POST['exam_name'])) {
		
		$name = clean_ip($_POST['name']);
		$exam_id = clean_ip($_POST['exam_name']);
		$create_act  = create_act($name,$exam_id);
		
		if ($create_act == "success") {
			
			?>
			<script type="text/javascript">
				
				swal("Good Job!", "Activity Created Successfully! Assign Roles to it!!", "success")
			</script>
			<?php
			unset($_POST);
			header( "refresh:2; url=assign_role_to_activity.php" );
		}
		else
		{
?>
		<script type="text/javascript">
			
			swal("Failed!", "<?php echo $create_act ?>", "error")
		</script>
<?php
		}
	}
?>

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>Create New Activity</h2>
                            
                        </div>
                        <div class="body">
                            <form id="wizard_with_validation" action="create_activity.php" method="POST">
                                <fieldset>
									<div class="row clearfix">
										<div class="col-sm-2">
											<div class="form-group">
												<div>
													<label>Name :</label> 
												</div>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<div class="form-line">
													<input type="text" class="form-control" name="name" required autofocus>
													
												</div>
											</div>
										</div>
										
									</div>
									<div class="row clearfix">
										<div class="col-sm-2">
											<div class="form-group">
												<div>
													<label>Exam  :</label> 
												</div>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<div class="form-line">
													<select class="form-control show-tick" data-live-search="true" id="exam_name" name="exam_name" required>
													<option value="">---SELECT ---</option>
													<?php 
															$sel_user_query = "SELECT * FROM `exam_table`";
															if ($sel_res = mysqli_query($dbcon,$sel_user_query)) {
																	if(mysqli_num_rows($sel_res) > 0)
																	{
																		while ($row = mysqli_fetch_assoc($sel_res)) {
																		?>
																		<option value="<?php echo $row['id'] ?>"><?php echo $row['exam_name'] ?></option>
																		<?php
																		}
																	}
																	else
																	{
																		?>
																		<option value="">No Exam Found</option>
																		<?php
																	}
																}
														?>
														</select>
													
												</div>
											</div>
										</div>
										
									</div>
									<div>
										<div class="col-md-6" align= "center">
										<br /><br />
										<input type="submit" name="create_activity" class="btn btn-primary waves-effect" value="Create Avtivity" >
										</div>
									</div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            <!--/div-->
</div>
</section>