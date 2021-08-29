<link href="../plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
<?php
	
?>
<section class="content">
    <div class="container-fluid">
        
        
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Assigned Class Teacher
                        </h2>
                       
                    </div>
                    <div class="body" id="content_box">
                         <div class="row clearfix">
										<div class="col-sm-2">
											<div class="form-group">
												<div>
													<label>Department : </label> 
												</div>
											</div>
										</div>
										<div class="col-md-6">
												<select class="form-control show-tick" id="department" data-live-search="true" name="department" onchange="show_list()"required>
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
								<div id="view_from_container">
		
								</div>
                    </div>
					
								
                </div>
            </div>
        </div>        
    </div>
</section>
<script>
function show_list()
{
		var department = document.getElementById('department').value;
		var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        	if (this.readyState == 4 && this.status == 200) {
				
        		document.getElementById('view_from_container').innerHTML = this.responseText; 
				$('select').selectpicker();
        	}
        };
		
        xhttp.open("POST", "../config/ajax/view_class_teacher.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("department="+department);
		
		
}
</script>
<script type="text/javascript">
	function enable_edit(branch, year, ip_id, btn_id )
	{
		var xhttp = new XMLHttpRequest();
		var upd_btn =  "<input type=\"button\" class=\"btn btn-primary waves-effect\" onclick=\"save("+branch+","+year+",'"+ip_id+"select'"+")\"  value=\"Save\" />";
        xhttp.onreadystatechange = function() {
        	if (this.readyState == 4 && this.status == 200) {
        		document.getElementById(ip_id).innerHTML = this.responseText; 
        		document.getElementById(btn_id).innerHTML = upd_btn;
        	}
        };
        xhttp.open("POST", "../config/ajax/manage_class_teacher.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("department="+branch+"&year="+year+"&set_id="+ip_id+"select");
	}
</script>
<script type="text/javascript">
	function save(branch,year,source_id)
	{
		var teacher = document.getElementById(source_id).value;
		if (teacher) {
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
	        	if (this.readyState == 4 && this.status == 200) {
	        		document.getElementById('content_box').innerHTML = this.responseText; 
	        		
	        	}
	        };
	        xhttp.open("POST", "../config/ajax/manage_class_teacher2.php", true);
	        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	        xhttp.send("department="+branch+"&year="+year+"&teacher="+teacher);
		} else
		{
			alert("Plz select a staff !!");
		}
	}
</script>