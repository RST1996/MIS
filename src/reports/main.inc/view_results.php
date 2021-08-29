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
                           View Results 
                        </h2>
                       
                    </div>
                    <div class="body">
                    	<div class="row clearfix">
							<div class="col-sm-2">
								<div class="form-group">
									<div>
										<label>Academic Session : </label> 
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<select class="form-control show-tick" data-live-search="true" id="sesn_id" name="sesn_id" onchange="show_dep()" required>
									<option value="">---SELECT SESSION---</option>
									<?php
										$session_sel_query = "SELECT `exam_session`.`session`, `academic_year`.`academic_year`,`sessions`.`sesn_id` FROM `exam_session`,`sessions`,`academic_year` WHERE `sessions`.`end_flag` = '1' AND `sessions`.`academic_yr` = `academic_year`.`ac_id` AND `sessions`.`exam_sesn` = `exam_session`.`id` ";
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
						<div id="dep_container"></div>
						<div id="sem_container"></div>
						<div id="list_container"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
	function show_dep()
	{
		var sesn_id = document.getElementById('sesn_id').value;
		document.getElementById('dep_container').innerHTML="";
		document.getElementById('sem_container').innerHTML="";
		document.getElementById('list_container').innerHTML="";
		$.blockUI({ message: '<img src="../assets/images/loader.gif" /> &nbsp;&nbsp;&nbsp; Just a moment...' });
		if(sesn_id)
		{
			var xhttp = new XMLHttpRequest();
		
	        xhttp.onreadystatechange = function() {
	        	if (this.readyState == 4 && this.status == 200) {
	        		document.getElementById('dep_container').innerHTML = this.responseText; 
					$('select').selectpicker();
					$.unblockUI();
				}
	        };
	        xhttp.open("POST", "../config/ajax/show_dep.php", true);
	        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send();
		}
		else
		{
			alert("SELECT A SESSION FIRST");
		}
	}
</script>
<script type="text/javascript">
	function show_sem()
	{
		var sesn_id = document.getElementById('sesn_id').value;
		var department = document.getElementById('department').value;
		document.getElementById('sem_container').innerHTML="";
		document.getElementById('list_container').innerHTML="";
		$.blockUI({ message: '<img src="../assets/images/loader.gif" /> &nbsp;&nbsp;&nbsp; Just a moment...' });
		if(sesn_id && department)
		{
			var xhttp = new XMLHttpRequest();
		    xhttp.onreadystatechange = function() {
		    	if (this.readyState == 4 && this.status == 200) {
		    		document.getElementById('sem_container').innerHTML = this.responseText; 
					$('select').selectpicker();
					$.unblockUI();
				}
		    };
		    xhttp.open("POST", "../config/ajax/show_semester.php", true);
		    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send();	
		}
	}
</script>
<script type="text/javascript">
	function show_list()
	{
		var sesn_id = document.getElementById('sesn_id').value;
		var department = document.getElementById('department').value;
		var sem = document.getElementById('sem').value;
		document.getElementById('list_container').innerHTML="";
		$.blockUI({ message: '<img src="../assets/images/loader.gif" /> &nbsp;&nbsp;&nbsp; Just a moment...' });
		if(sesn_id && department && sem)
		{
			var xhttp = new XMLHttpRequest();
	        xhttp.onreadystatechange = function() {
	        	if (this.readyState == 4 && this.status == 200) {
	        		document.getElementById('list_container').innerHTML = this.responseText;
					$.unblockUI();
	        	}
	        };
	        xhttp.open("POST", "../config/ajax/show_results.php", true);
	        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhttp.send("dept="+department+"&sem="+sem+"&sesn_id="+sesn_id);
		}
	}
</script>