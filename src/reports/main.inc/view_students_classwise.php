
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
                               View Students 
                            </h2>
                           
                        </div>
                        <div class="body">
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
								<div class="row clearfix">
										<div class="col-sm-2">
											<div class="form-group">
												<div>
													<label>Year : </label> 
												</div>
											</div>
										</div>
										<div class="col-md-6">
												<select class="form-control show-tick" id="year" name="year" onchange="show_list()"required>
													<option value="">---SELECT YEAR---</option>
													<option value="1">FIRST YEAR</option>
													<option value="2">SECOND YEAR</option>
													<option value="3">THIRD YEAR</option>
													<option value="4">FINAL YEAR</option>
													
												</select>

										</div>
								</div>
								<div id="table_container">
		
								</div>
                            
                        </div>
                    </div>
                </div>
            </div>
            
            
        </div>
    </section>
<script type="text/javascript">
	function show_list()
	{
		var department = document.getElementById('department').value;
		var year = document.getElementById('year').value;
		var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        	if (this.readyState == 4 && this.status == 200) {
        		document.getElementById('table_container').innerHTML = this.responseText; 
        	}
        };
        xhttp.open("POST", "../config/ajax/view_students_classwise.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("department="+department+"&year="+year);
		 
		
	}
</script>

<script type="text/javascript">
	function delete_student(id)
	{
		var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        	if (this.readyState == 4 && this.status == 200) {
        		document.getElementById('student_container').innerHTML = this.responseText; 
        	}
        };
        xhttp.open("POST", "../config/ajax/delete_student.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("del_id="+id);
	}
</script>
    <!-- Waves Effect Plugin Js -->
    <script src="../plugins/node-waves/waves.js"></script>

    <script src="../plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="../plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="../plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script src="../plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="../plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="../plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="../plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="../plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
    <script src="../plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>

    <!-- Custom Js -->
    <script src="../js/pages/tables/jquery-datatable.js"></script>