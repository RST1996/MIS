
    <!-- JQuery DataTable Css -->
    <link href="../plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

    <section class="content">
        <div class="container-fluid">
            
            
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                               View Courses
                            </h2>
                           
                        </div>
                        <div class="body">
							<form method = "POST" action = "../config/ajax/view_course_details.php">
                                <fieldset>


								<div class="row clearfix">
									<div class="col-sm-3">
										<div class="form-group">
											<div>
												<label>Department : </label> 
											</div>
										</div>
									</div>
									<div class="col-md-6">
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
								<div class="row clearfix">
									<div class="col-sm-3">
											<div class="form-group">
												<div>
													<label>Semester: </label> 
												</div>
											</div>
										</div>
										<div class="col-md-6">
												<select  id="semester" name="semester" onchange="show_course()" required>
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
									 <div id="course_from_container">
											
									</div> 
									
									
								</fieldset>
								
							</form>
							</div>
                    </div>
                </div>
            </div>
            
            
        </div>
    </section>
<script type="text/javascript">
    $(document).ready(function() {
    	$('#course_table').DataTable({
    		responsive: true
    	});
	} );
</script>
<script type="text/javascript">
	function show_course()
	{
		var department = document.getElementById('department').value;
		var sem = document.getElementById('semester').value;
		var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        	if (this.readyState == 4 && this.status == 200) {
        		document.getElementById('course_from_container').innerHTML = this.responseText; 
        	}
        };
        xhttp.open("POST", "../config/ajax/view_course.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhttp.send("department="+department+"&sem="+sem);
	}
</script>
<script type="text/javascript">
	function show_details(course_code)
	{
		var department = document.getElementById('department').value;
		var sem = document.getElementById('semester').value;
		var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        	if (this.readyState == 4 && this.status == 200) {
        		document.getElementById('course_from_container').innerHTML = this.responseText; 
        	}
        };
        xhttp.open("POST", "../config/ajax/view_course_details.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhttp.send("department="+department+"&sem="+sem+"&course_code="+course_code);
	}
</script>

  