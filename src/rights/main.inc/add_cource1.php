<?php
	//include("../template/index.php");
?>
	
    <!-- Sweet Alert Css -->
    <link href="../plugins/sweetalert/sweetalert.css" rel="stylesheet" />
	<script src="../js/select.js"></script>

	<script src="../js/pages/forms/form-wizard.js"></script>


    <!-- Jquery Validation Plugin Css -->
    <script src="../plugins/jquery-validation/jquery.validate.js"></script>

    <!-- JQuery Steps Plugin Js -->
    <script src="../plugins/jquery-steps/jquery.steps.js"></script>

    <!-- Sweet Alert Plugin Js -->
    <script src="../plugins/sweetalert/sweetalert.min.js"></script>

<section class="content">
<div class="container-fluid">
    
	<div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>COURSE REGISTRATION</h2>
                           
                        </div>
                        <div class="body">
                            <form id="wizard_with_validation" method="POST">
                                <h3>Profile Information</h3>
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
												<select class="form-control show-tick" id="department" name="department" required>
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
                                </fieldset>

                                <h3>Courses Information</h3>
                                <fieldset>
										<table id="mainTable" class="table table-striped">
											<thead>
												<tr>
													<th>#</th>
													<th><input id="selectall" name="selectall" type="checkbox" required>
                                    <label for="selectall"></label></th>
													<th>Course Code</th>
													<th>Course Name</th>
													<th>Course Type</th>
												
												</tr>
											</thead>
											<tbody>
												<tr>
														<td></td>
														<td> <input  id="subject" name="subject" type="checkbox" required>
                                    <label for="subject"></label></td>
														<td></td>
														<td></td>
														<td></td>
												</tr>
												
											</tbody>
										</table>
                                </fieldset>

                                <!--h3>Complete your Registration</h3>
                                <fieldset>
									<h6>Courses selected are :</h6>
                                    <input id="acceptTerms-2" name="acceptTerms" type="checkbox" required>
                                    <label for="acceptTerms-2">I agree.</label>
                                </fieldset-->
                            </form>
                        </div>
                    </div>
                </div>
            </div>

</div>
</section>