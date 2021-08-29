<?php
/*
Objecives:
1. To update the grades, result status fields in the exam_registration table of each student registered in this sesn
2. To Update the status f the student and set the current semester to the appropriate value
3. To end the sesn.

Note:- Its a crucial activity and it changes the complte state of the system

Steps: 
1. SELECT ALL THE SUBJECTS IN WHICH THE STUDENTS HAS REGISTERED
2. FOR EACH SUBJECTS CALCULATE THE GRADE LIMITS AND UPDATE THE RESPECTIVE FIELD IN THE EXAM REGISTRTION AND STUDENT TABLE
3. END THE SESSION

*/


print_r($_POST);
if(isset($_POST['lock_results']))
{
	$start = microtime(true);
	$sesn_id = $_POST['sesn_id'];
	$sec_pass = $_POST['sec_pass'];
	echo $lock = lock_results($sesn_id,$sec_pass);
	if($lock == "success")
	{
?>
	<script type="text/javascript">
		
		swal("Good Job!", "Successfully Registered", "success")
	</script>
<?php
		unset($_POST);
		//header( "refresh:1; url=lock_grades.php" );
	}
	else
	{
?>
		<script type="text/javascript">
			swal("Failed!", "<?php echo $lock; ?>", "error")
		</script>
<?php
	}
	$time_elapsed_secs = microtime(true) - $start;
	echo "Time to run script : ".$time_elapsed_secs;
}
?>
<script type="text/javascript">
	alert("Time taken by script to run : <?php echo $time_elapsed_secs ?>");
</script>

<!-- JQuery DataTable Css -->
<link href="../plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
<link href="../plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
<section class="content">
    <div class="container-fluid">							
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                           Lock Grades Grades 
                        </h2>
                    </div>
                    <div class="body">
                    	<form method="POST" action="lock_grades.php">
                    		<fieldset>
		                    	<div class="row clearfix">
									<div class="col-sm-2">
										<div class="form-group">
											<div>
												<label>Academic Session : </label> 
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<select class="form-control show-tick" data-live-search="true" id="sesn_id" name="sesn_id" required>
											<option value="">---SELECT SESSION---</option>
											<?php
												$session_sel_query = "SELECT `exam_session`.`session`, `academic_year`.`academic_year`,`sessions`.`sesn_id` FROM `exam_session`,`sessions`,`academic_year` WHERE `sessions`.`end_flag` = '0' AND `sessions`.`academic_yr` = `academic_year`.`ac_id` AND `sessions`.`exam_sesn` = `exam_session`.`id` ";
												if ($res = mysqli_query($dbcon,$session_sel_query)) {
													if (mysqli_num_rows($res) > 0) {
														while ($row = mysqli_fetch_assoc($res)) {
											?>
											<option value="<?php echo $row['sesn_id']; ?>"><?php echo $row['session']." : ".$row['academic_year'];  ?></option>
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
										<input type="submit" name="lock_results" class="btn btn-primary waves-effect" value="Lock Results" >
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