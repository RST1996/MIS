<?php
	session_start();
	$user_ref_id = $_SESSION['user_ref_id'];
	require_once "../dbconnect.php";
	require_once "../funlib/login_functions.php";
	require_once "../funlib/not_elligible_functions.php";

	if ( isset($_POST['exam_id']) && ( isLogin() != null)) {
		
		
		$exam_id = $_POST['exam_id'];
		
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
			<select id="department" name="department" data-live-search="true" onchange="show_course()" required>
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
<?php
	}
?>