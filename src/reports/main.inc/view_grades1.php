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
                           View Grades 
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
								<select class="form-control show-tick" data-live-search="true" id="department" name="department" onchange="show_sem()" required>
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
						<div id="sem_container"></div>
						<div id="course_container"></div>
						<div id="list_container"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
	function show_sem()
	{
		var xhttp = new XMLHttpRequest();
		
        xhttp.onreadystatechange = function() {
        	if (this.readyState == 4 && this.status == 200) {
        		document.getElementById('sem_container').innerHTML = this.responseText; 
				$('select').selectpicker();
			}
        };
        xhttp.open("POST", "../config/ajax/show_sem.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send();
	}
</script>
<script type="text/javascript">
	function show_course()
	{
		var department = document.getElementById('department').value;
		var sem = document.getElementById('sem').value;
		var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        	if (this.readyState == 4 && this.status == 200) {
        		document.getElementById('course_container').innerHTML = this.responseText;
				$('select').selectpicker();
        	}
        };
        xhttp.open("POST", "../config/ajax/show_course_list.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("dept="+department+"&sem="+sem);
	}
</script>
<script type="text/javascript">
	function show_list()
	{
		var department = document.getElementById('department').value;
		var sem = document.getElementById('sem').value;
		var course = document.getElementById('course').value;
		var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        	if (this.readyState == 4 && this.status == 200) {
        		document.getElementById('list_container').innerHTML = this.responseText;
				
        	}
        };
        xhttp.open("POST", "../config/ajax/show_grades_list1.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.send("dept="+department+"&sem="+sem+"&course="+course);
	}
</script>