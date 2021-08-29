<?php
	if (isset($_POST['add_acyr'])) {
		
		$name = $_POST['name'];
		$sec_pass = $_POST['sec_pass'];
		$add_academic_year  = add_academic_year($name,$sec_pass);
		if ($add_academic_year == "success") {
			
			?>
			<script type="text/javascript">
				
				swal("Good Job!", "Successfully Registered", "success")
			</script>
			<?php
			unset($_POST);
			
			header( "refresh:1; url=add_academic_year.php" );
		}
		else
		{
?>
		<script type="text/javascript">
			swal("Failed!", "<?php echo $add_course ?>", "error")
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
						<h2>Add Academic Year</h2>
					</div>
					<div class="body">
						<form id="wizard_with_validation" action="add_academic_year.php" method="POST">
<?php
	$ac_name = "Academic Year ".date('Y')."-".date('Y',strtotime('+1 year'));
?>							
							<fieldset>
								<!--div class="alert warning">Be careful while  adding a new academic year. It effect s the working of the whole system  AND It Cannot be undone!!</div-->
								<div class="row clearfix">
									<div class="col-sm-2">
										<div class="form-group">
											<div>
												<label for="name">New Academic Session Name :</label> 
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<div class="form-line">
												<input type="text" name="name" value="<?php echo $ac_name; ?>" class="form-control" readonly>
											</div>
										</div>
									</div>									
								</div>
								<div class="row clearfix">
									<div class="col-sm-2">
										<div class="form-group">
											<div>
												<label for="sec_pass">Security Code :</label> 
											</div>
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<div class="form-line">
												<input type="password" id="sec_pass" class="form-control" name="sec_pass" required  />		
											</div>
										</div>
									</div>
									<div class="col-sm-offset-2 col-md-6">										
										<input type="submit" name="add_acyr" class="btn btn-primary waves-effect" value="Add Academic Year" >
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
