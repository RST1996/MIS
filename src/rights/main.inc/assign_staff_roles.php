
<link href="../plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
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
                            <h2>Assign Staff Roles to Staff</h2>
                            
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
									<div id="assign_from_container">
								
									</div>

								</fieldset>
							</div>
							
							
<script type="text/javascript">
	function update_list()
	{
		var department = document.getElementById('department').value;
		var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        	if (this.readyState == 4 && this.status == 200) {
        		document.getElementById('assign_from_container').innerHTML = this.responseText; 
				$('select').selectpicker();
        	}
        };
        xhttp.open("POST", "../config/ajax/asssign_staff_role.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("department="+department);
		
	}
</script>
					</div>
				</div>
		
</div>
</section>

