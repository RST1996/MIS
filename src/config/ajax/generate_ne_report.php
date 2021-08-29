<?php
	require_once "../dbconnect.php";
	require_once "../funlib/login_functions.php";
	$course = $_POST['course'];
	$exam = $_POST['exam'];
?>	

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
							$dep_sel_query = "SELECT `id`, `department_name` FROM `department` WHERE `id` <> '7' AND `id` <> '8'";
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
	
	<div class="row clearfix" align="center">
				<div class="col-sm-4">
					
					<input type="button"  name="generate_marks" value="Generate Report" onclick="get_print('<?php $no = rand(1000,2000); $_SESSION['sec_access_code'] = $no; echo base64_encode($no); ?>')" class="btn bg-deep-purple waves-effect"/> 
				</div>
			</div> 
