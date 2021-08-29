<?php
	
	$stud_id = $_SESSION['user_ref_id'];
	if(!exam_registration_comformation($stud_id))
	{
		if (isset($_POST['proceed'])) {
			if(exam_registration_stat($stud_id) == "Not registered")
			{
				header('Location:../exam_registration/exam_reg.php');
			}
			
				
			
		}
?>
<section class="content">
	<div class="container-fluid">
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2>Exam Registration</h2>
					</div>
					<div class="body">
						<form id="wizard_with_validation" method="POST">
						<ul>
							<li>ADD RULES HERE</li>
						</ul>
							<fieldset>
								<div class="row clearfix">
								
									<div class="col-sm-offset-4 col-md-6">										
										<input type="submit" name="proceed" class="btn btn-primary waves-effect" value="Proceed Registartion" >
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
<?php
}
else 
		{
			?>
<section class="content">
	<div class="container-fluid">
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2>Exam Registration</h2>
					</div>
					<div class="body">
						<form id="wizard_with_validation" method="POST">
						<ul>
							<li>ADD RULES HERE</li>
						</ul>
							<fieldset>
								<div class="row clearfix">
								
									<div class="col-sm-offset-4 col-md-6">										
										<input type="submit" name="add_acyr" class="btn btn-primary waves-effect" value="Genarate Slip" >
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
<?php

		}
		?>