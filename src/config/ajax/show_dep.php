<?php
	session_start();
	$user_ref_id = $_SESSION['user_ref_id'];
	require_once "../dbconnect.php";
	require_once "../funlib/login_functions.php";
	if ( isLogin() != null) 
	{		
?>	
	<div class="row clearfix">
		<div class="col-sm-2">
			<div class="form-group">
				<div>
					<label>Department : </label> 
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<select id="department" name="department" data-live-search="true" onchange="show_sem()" required>
					<option value="">---SELECT DEPARTMENT---</option>
					<?php
							echo $dep_sel_query = "SELECT `id`, `department_name` FROM `department` WHERE `student_flag` = '1'";
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
<?php
	}
?>