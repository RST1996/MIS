<section class="content">
<div class="container-fluid">
<?php
	if (isset($_POST['add_staff'])) {
		
		$name = clean_ip($_POST['name']);
		$designation = clean_ip($_POST['designation']);
		$department = clean_ip($_POST['department']);
		$username = clean_ip($_POST['username']);
		$add_staff  = add_staff($name,$designation,$department,$username);
		if ($add_staff == "success") {
			
			?>
			<script type="text/javascript">
				
				swal("Good Job!", "Successfully Registered", "success")
			</script>
			<?php
			unset($_POST);
			header( "refresh:1; url=add_staff.php" );
		}
		else
		{
?>
		<script type="text/javascript">
			
			swal("Failed!", "<?php echo $add_staff ?>", "error")
		</script>
<?php
		}
	}
?>

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>Add New Staff</h2>
                            
                        </div>
                        <div class="body">
                            <form id="wizard_with_validation" action="add_staff.php" method="POST">
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
													<label>Designation :</label> 
												</div>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<div class="form-line">
													<input type="text" class="form-control" name="designation" required >
													
												</div>
											</div>
										</div>
										
									</div>
									<div class="row clearfix">
										<div class="col-sm-2">
											<div class="form-group">
												<div>
													<label>Username : </label> 
												</div>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<div class="form-line">
													<input type="text" class="form-control" name="username" required >
													
												</div>
											</div>
										</div>
										</div>
                                    <div class="row clearfix">
										<div class="col-sm-2">
											<div class="form-group">
												<div>
													<label>Department : </label> 
												</div>
											</div>
										</div>
										<div class="col-md-6">
												<select class="form-control show-tick" id="department" data-live-search="true" name="department" required>
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
										<div class="col-md-6">
										<br /><br />
										<input type="submit" name="add_staff" class="btn btn-primary waves-effect" value="Add Staff" >
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