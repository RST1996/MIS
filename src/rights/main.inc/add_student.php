

<?php
	if (isset($_POST['add_stud'])) {
		$prn = clean_ip($_POST['prn']);
		$name = clean_ip($_POST['name']);
		$father_name = clean_ip($_POST['father_name']);
		$date = clean_ip($_POST['date']);
		$gender = clean_ip($_POST['gender']);
		$caste = clean_ip($_POST['caste']);
		$category = clean_ip($_POST['category']);
		$religion = clean_ip($_POST['religion']);
		$nationality = clean_ip($_POST['nationality']);
		$ph_type = clean_ip($_POST['ph_type']);
		$email = clean_ip($_POST['email']);
		$landline_no = clean_ip($_POST['landline_no']);
		$mobile_no = clean_ip($_POST['mobile_no']);
		$city = clean_ip($_POST['city']);
		$local_address = clean_ip($_POST['local_address']);
		$permanent_address = clean_ip($_POST['permanent_address']);
		$department = clean_ip($_POST['department']);
		$current_semester = clean_ip($_POST['current_semester']);
		$admission_year = clean_ip($_POST['admission_year']);
		echo $gender;
		echo $ph_type;
		$add_stud  = add_student($prn,$name,$father_name,$date,$caste,$category,$religion,$nationality,$ph_type,$email,$landline_no,$mobile_no,$city,$local_address,$permanent_address,$department,$current_semester,$gender);
		echo $add_stud;
		if ($add_stud == "success") {
			
			?>
			<script type="text/javascript">
				
				swal("Good Job!", "Successfully Registered", "success")
			</script>
			<?php
			unset($_POST);
			header( "refresh:1; url=add_student.php" );
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
                            <h2>Add New Students</h2>
                        </div>
                        <div class="body">
                            <form id="wizard_with_validation" action="add_student.php" method="POST">
                                <fieldset>
									<div class="row clearfix">
										<div class="col-sm-2">
											<div class="form-group">
												<div>
													<label>PRN :</label> 
												</div>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<div class="form-line">
													<input type="text" class="form-control" name="prn" placeholder="PRN" required autofocus>
													
												</div>
											</div>
										</div>
										
									</div>
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
													<input type="text" class="form-control" name="name" placeholder="Full Name" required autofocus>
													
												</div>
											</div>
										</div>
										
									</div>
									<div class="row clearfix">
										<div class="col-sm-2">
											<div class="form-group">
												<div>
													<label>Father Name :</label> 
												</div>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<div class="form-line">
													<input type="text" class="form-control" name="father_name" placeholder="Father Name" required >
													
												</div>
											</div>
										</div>
										
									</div>
									<div class="row clearfix">
										<div class="col-sm-2">
											<div class="form-group">
												<div>
													<label>Date of Birth :</label> 
												</div>
											</div>
										</div>
										 <div class="col-sm-4">
											<div class="form-group">
												<div class="form-line">
													<input type="date" class="datepicker form-control" name="date" placeholder="Please choose a date" required />
												</div>
											</div>
										</div>
										<div class="col-sm-2">
											<div class="form-group">
												<div>
													<label>Gender : </label> 
												</div>
											</div>
										</div>
										<div class="col-sm-3">
											<div class="form-group">
													 <select  id="gender" name="gender" required>
														<option value="">--SELECT--</option>
														<option value="MALE">MALE</option>
														<option value="FEMALE">FEMALE</option>
													</select>
												</div>
										</div>
									</div>
									<div class="row clearfix">
										<div class="col-sm-2">
											<div class="form-group">
												<div>
													<label>Caste : </label> 
												</div>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<div class="form-line">
													<input type="text" class="form-control" name="caste" required >
													
												</div>
											</div>
										</div>
										<div class="col-sm-2">
											<div class="form-group">
												<div>
													<label>Category : </label> 
												</div>
											</div>
										</div>
										<div class="col-md-3">
												<select class="form-control show-tick" id="category" data-live-search="true" name="category" required>
													<option value="">--SELECT--</option>
													<option value="OPEN">OPEN</option>
													<option value="OBC">OBC</option>
													<option value="SC">SC</option>
													<option value="ST">ST</option>
													<option value="NT">NT</option>
													<option value="VJ">VJ</option>
												</select>
										</div>
									</div>
									
									
										<div class="row clearfix">
											<div class="col-sm-2">
												<div class="form-group">
													<div>
														<label>Nationality : </label> 
													</div>
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													<div class="form-line">
														<input type="text" class="form-control" name="nationality" required >
														
													</div>
												</div>
											</div>
										<div class="col-sm-2">
											<div class="form-group">
												<div>
													<label>Religion : </label> 
												</div>
											</div>
										</div>
										<div class="col-sm-3">
											<div class="form-group">
												<div class="form-line">
													<input type="text" class="form-control" name="religion" required >
													
												</div>
											</div>
										</div>
									</div>
									
									
									<div class="row clearfix">
										<div class="col-sm-2">
											<div class="form-group">
												<div>
													<label>Department: </label> 
												</div>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<div class="form-line">
													<select id="department" name="department" data-live-search="true" required>
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
											</div>
										</div>
										<div class="col-sm-2">
											<div class="form-group">
												<div>
													<label>Current Semester: </label> 
												</div>
											</div>
										</div>
										<div class="col-md-1">
												<select  id="current_semester" name="current_semester" data-live-search="true" required>
													<option value="">--SELECT--</option>
													<option value="1">I</option>
													<option value="2">II</option>
													<option value="3">III</option>
													<option value="4">IV</option>
													<option value="5">V</option>
													<option value="6">VI</option>
													<option value="7">VII</option>
													<option value="8">VIII</option>
												</select>
										</div>
									</div>
									
									
									<div class="row clearfix">
											<div class="col-sm-2">
												<div class="form-group">
													<div>
														<label>PH Candidate : </label> 
													</div>
												</div>
											</div>
											<div class="col-sm-4">
												<div class="form-group">
													 <select  id="ph_type" name="ph_type" required>
														<option value="">--SELECT--</option>
														<option value="YES">YES</option>
														<option value="NO">NO</option>
													</select>
												</div>
											</div>
											<div class="col-sm-2">
												<div class="form-group">
													
														<label>Admission Year : </label> 
													
												</div>
											</div>
											<div class="col-sm-2">
												<div class="form-group">
													<div class="form-line">
													 <input type="text" class="form-control" name="admission_year" required >
													 </div>
														
												</div>
											</div>
										</div>
										<div class="row clearfix">
										<div class="col-sm-2">
											<div class="form-group">
												<div>
													<label>E-mail : </label> 
												</div>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<div class="form-line">
													<input type="email" class="form-control" name="email" required >
													
												</div>
											</div>
										</div>
									</div>
									<div class="row clearfix">
										<div class="col-sm-2">
											<div class="form-group">
												<div>
													<label>Landline No : </label> 
												</div>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<div class="form-line">
													<input type="text" class="form-control" name="landline_no" required >
													
												</div>
											</div>
										</div>
										<div class="col-sm-2">
											<div class="form-group">
												<div>
													<label>Mobile No : </label> 
												</div>
											</div>
										</div>
										<div class="col-sm-3">
											<div class="form-group">
												<div class="form-line">
													<input type="text" class="form-control" name="mobile_no" required >
													
												</div>
											</div>
										</div>
									</div>
									</div>
									<div class="row clearfix">
												<div class="col-sm-2">
													<div class="form-group">
														<div>
															<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;City : </label> 
														</div>
													</div>
												</div>
												<div class="col-sm-4">
													<div class="form-group">
														<div class="form-line">
														 <input type="text" class="form-control" name="city" required >
														 </div>
															
													</div>
												</div>
											</div>
											
									<div class="row clearfix">
										<div class="col-sm-2">
											<div class="form-group">
												<div>
													<label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Local Address </label> 
												</div>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<div class="form-line">
													<textarea type="text" class="form-control" name="local_address" required ></textarea>
													
												</div>
											</div>
										</div>
									
										<div class="col-sm-2">
											<div class="form-group">
												<div>
													<label>Permanent</label>
													<label>Address</label>													
												</div>
											</div>
										</div>
										<div class="col-sm-3">
											<div class="form-group">
												<div class="form-line">
													<textarea type="text" class="form-control" name="permanent_address" required ></textarea>
													
												</div>
											</div>
										</div>
									</div>
									
									<div class="row clearfix">
										
										<div class="col-md-6" align="center">
											<div class="form-group">
												<input type="submit" class="btn btn-primary waves-effect" name="add_stud" value="Submit" />
											</div>
										</div>
										<div class="col-md-6" align="center">
											<div class="form-group">
												<input type="submit" class="btn btn-primary waves-effect" value="Clear" />
											</div>
										</div>
									</div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>			
	
<script src="../plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

<script src="../plugins/autosize/autosize.js"></script>

<script src="../plugins/momentjs/moment.js"></script>
	
<script src="../js/pages/forms/basic-form-elements.js"></script>