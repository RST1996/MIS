
<link href="../plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
<?php
	session_start();
	require_once "../dbconnect.php";
	require_once "../funlib/login_functions.php";
	if (isset($_POST['department']) && ( isLogin() != null)) {
		$depertment = $_POST['department'];
		$staff_sel_query = "SELECT `id`, `name` FROM `staff` WHERE `department` = '$depertment'";
		if ($res = mysqli_query($dbcon,$staff_sel_query)) {
			if (mysqli_num_rows($res) > 0 ) {
?>
                            
                                <fieldset>
                                    <div class="row clearfix">
										<div class="col-sm-2">
											<div class="form-group">
												<div>
													<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Staff:  </label>  
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<select id="staff" onchange="update_view()" name="staff" data-live-search="true" required>
																<option value="">--SELECT STAFF--</option>
										<?php
														while ($row = mysqli_fetch_assoc($res)) {
															$staff_id = $row['id'];
															$staff_name = $row['name'];
										?>
																<option value="<?php echo $staff_id; ?>"><?php echo $staff_name; ?></option>
										<?php
														}
										?>
										</select>

										</div>
										
									</div>
								</fieldset>
							</div>
							
	
</div>
<?php
			} else {
				echo "No staff has been added yet for this department!!";
			}
			
		} else {
			echo mysqli_error($dbcon);
		}
		
	}
	
?>
							</div>
					</div>
		</div>
</div>
</section>

<script src="../plugins/bootstrap-notify/bootstrap-notify.js"></script>