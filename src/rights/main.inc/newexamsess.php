<?php
	if (isset($_POST['add_new_exam_sesn'])) {
		print_r($_POST);
		$exam_sesn = $_POST['exam_sesn'];
		$sec_pass = $_POST['sec_pass'];
		$add_new_exam_sesn  = add_new_exam_sesn($exam_sesn,$sec_pass);
		if ($add_new_exam_sesn == "success") {
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
<link href="../plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
<section class="content">
	<div class="container-fluid">
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2>New Examination Year</h2>
					</div>
					<div class="body">
						<form id="wizard_with_validation" action="newexamsess.php" method="POST">
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
									<div class="col-md-6">
										<select class="form-control show-tick" id="exam_sesn" name="exam_sesn" required>
											<option value="">---SELECT EXAMINATION SESSION---</option>
											<?php
												$dep_sel_query = "SELECT `id`, `session` FROM `exam_session`";
												if ($res = mysqli_query($dbcon,$dep_sel_query)) {
													if (mysqli_num_rows($res) > 0) {
														while ($row = mysqli_fetch_assoc($res)) {
											?>
											<option value="<?php echo $row['id']; ?>"><?php echo $row['session'];  ?></option>
											<?php				
														}
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
										<input type="submit" name="add_new_exam_sesn" class="btn btn-primary waves-effect" value="Start Examination Session" >
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
