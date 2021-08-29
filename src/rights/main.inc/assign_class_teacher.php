

<link href="../plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
<?php
	if (isset($_POST['assign_class_teacher'])) {
		$year = $_POST['year'];
		$department = $_POST['department'];
		$teacher = $_POST['teacher'];
		$assign_class_teacher = assign_class_teacher($year,$department,$teacher);
		
	}
?>


<section class="content">
<div class="container-fluid">
	<div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
							Assign A Class Teacher
							</h2>
                            
                        </div>
                        <div class="body">
                            
							<form method="POST" action="assign_class_teacher.php">
                                <fieldset>
                                    <div class="row clearfix">
										<div class="col-sm-2">
											<div class="form-group">
												<div>
													<label>Select Year : </label> 
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<select id="year" name="year" onchange="set_year()"  required>
												<option>--SELECT YEAR--</option>
												<option value="1"> 1st Year </option>
												<option value="2"> 2nd Year </option>
												<option value="3"> 3rd Year </option>
												<option value="4"> 4th Year </option>
											</select>

										</div>
										
									</div>
								</fieldset>
								
							
								<div id="form_container">
			
								</div>
							
							</form>
							</div>
							</div>
					</div>
		</div>
</div>
</section>


<script type="text/javascript">
	function set_year()
	{
		var year = document.getElementById('year').value;
		var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        	if (this.readyState == 4 && this.status == 200) {
        		document.getElementById('form_container').innerHTML = this.responseText; 
				$('select').selectpicker();
        	}
        };
        xhttp.open("POST", "../config/ajax/assign_class_teacher.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("year="+year);
	}
	
</script>
<script type="text/javascript">
	function get_staff()
	{
		var department = document.getElementById('department').value;
		
		var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        	if (this.readyState == 4 && this.status == 200) {
        		document.getElementById('inner_form_container').innerHTML = this.responseText; 
				$('select').selectpicker();
        	}
        };
        xhttp.open("POST", "../config/ajax/assign_class_teacher2.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("department="+department);

	}
</script>
<script src="../plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

<script src="../plugins/autosize/autosize.js"></script>

<script src="../plugins/momentjs/moment.js"></script>
	
<script src="../js/pages/forms/basic-form-elements.js"></script>