<?php
	if (isset($_POST['assign_course_coordinator'])) {
		$course_id = $_POST['course'];
		$coordinator_id = $_POST['coordinator'];
		$assign = assign_course_coordinator($course_id,$coordinator_id);
		echo "$assign";
	}
?>


<section class="content">
<div class="container-fluid">
	<div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
							Assign A Course coordinator
							</h2>
                            
                        </div>
                        <div class="body">
                            
								<form method = "POST" action = "assign_course_coordinator.php">
                                <fieldset>
                                    <div class="row clearfix">
										<div class="col-sm-2">
											<div class="form-group">
												<div>
													<label>Course : </label> 
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<select id="course" name="course" data-live-search="true" required>
													<option> -- SELECT COURSE -- </option>
											<?php
												$course_query = "SELECT `course`.`id`,`course`.`course_code`,`course`.`course_name` FROM `course` WHERE `course`.`id` NOT IN (SELECT  `course_coordinator`.`course_id` FROM `course_coordinator` )";
												if ($res = mysqli_query($dbcon,$course_query)) {
													while ($row = mysqli_fetch_assoc($res)) {
											?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['course_code'].": ".$row['course_name']; ?></option>
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
													<label>Coordinator : </label> 
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<select id="coordinator" name="coordinator" data-live-search="true" required>
													<option> -- SELECT COURSE COORDINATOR -- </option>
											<?php
												$coordinator_query = "SELECT `staff`.`id`,`staff`.`name` FROM `staff`,`staff_role` WHERE `staff_role`.`staff_id` = `staff`.`id` AND `staff_role`.`staff_type_id` = '4'";
												if ($res = mysqli_query($dbcon,$coordinator_query)) {
													while ($row = mysqli_fetch_assoc($res)) {
											?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
											<?php
													}
												}
											?>
										</select>
										</div>
										
									</div>
									<div class="row clearfix">
										<div class="col-sm-6">
											<div class="form-group">
												<div>
														<input type="submit" class="btn btn-primary waves-effect" name="assign_course_coordinator" value="Assign" />
												</div>
											</div>
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
