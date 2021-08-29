<?php
	session_start();
	require_once "../dbconnect.php";
	require_once "../funlib/login_functions.php";

	if (isset($_POST['department']) && ( isLogin() != null)) {
			$department = $_POST['department'];
	}
?>
								
								<div class="row clearfix">
										<div class="col-sm-2">
											<div class="form-group">
												<div>
													<label>COURSE : </label> 
												</div>
											</div>
										</div>
										<div class="col-md-6">
												<select class="form-control show-tick"  data-live-search="true" id="course" name="course" onchange="show_list()"  required>
													<option value="">---SELECT COURSE---</option>
													<?php
														$sel_query = "SELECT `course`.`id`,`course`.`course_code`,`course`.`course_name` FROM `course`";
														if ($res1 = mysqli_query($dbcon,$sel_query)) {
															if (mysqli_num_rows($res1) > 0) {
																while ($row1 = mysqli_fetch_assoc($res1)) {
													?>
													<option value="<?php echo $row1['id']; ?>"><?php echo $row1['course_name'];  ?></option>
													<?php				
																}
															}
														}			
													?>
												</select>

										</div>
								</div>