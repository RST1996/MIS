
<?php
	if (isset($_POST['assign_staff_role'])) {
		$staff = $_POST['staff'];
		$staff_type = $_POST['staff_type'];
		$assignRes = assign_staff_roles($staff,$staff_type);
		if ($assignRes == "success") {
			?>
			<script type="text/javascript">
				
				swal("Good Job!", "Successfully Registered", "success")
			</script>
			<?php
			unset($_POST);
			
			header( "refresh:1; url=assign_staff_roles.php" );
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
                            <h2>
							View Staff Roles of Staffs
							</h2>
                            
                        </div>
                        <div class="body">
                            
                                <fieldset>
                                    <div class="row clearfix">
										<div class="col-sm-2">
											<div class="form-group">
												<div>
													<label>Select Department : </label> 
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<select id="department" name="department" data-live-search="true" onchange="update_list()">
												<option value=""> --SELECT A DEPARTMENT --</option>
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
							</div>
							
	<div id="view_from_container">
		
	</div>
	<div id="table_container">
		
	</div>
</div>
<script type="text/javascript">
	function remove_staff_role(staff_id,staff_role_id)
	{
		var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        	if (this.readyState == 4 && this.status == 200) {
        		document.getElementById('table_container').innerHTML = this.responseText; 
				$('select').selectpicker();
        	}
        };
        xhttp.open("POST", "../config/ajax/remove_staff_role.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("staff_id="+staff_id+"&staff_role_id="+staff_role_id);
	}
</script>
<script type="text/javascript">
	function update_list()
	{
		var department = document.getElementById('department').value;
		document.getElementById('table_container').innerHTML="";
		var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        	if (this.readyState == 4 && this.status == 200) {
        		document.getElementById('view_from_container').innerHTML = this.responseText; 
				$('select').selectpicker();
        	}
        };
        xhttp.open("POST", "../config/ajax/view_staff_role.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("department="+department);
	}
</script>
<script type="text/javascript">
	function update_view()
	{
		var staff = document.getElementById('staff').value;
		var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        	if (this.readyState == 4 && this.status == 200) {
        		document.getElementById('table_container').innerHTML = this.responseText; 
        	}
        };
        xhttp.open("POST", "../config/ajax/view_staff_role2.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("staff="+staff);
	}
</script>
							</div>
					</div>
		</div>
</div>
</section>

<script src="../plugins/bootstrap-notify/bootstrap-notify.js"></script>