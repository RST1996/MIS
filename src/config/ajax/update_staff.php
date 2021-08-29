<?php
	session_start();
	require_once "../dbconnect.php";
	require_once "../funlib/login_functions.php";
	require_once "../funlib/user_mgmt_functions.php";
	if (isset($_POST['up_id']) && isset($_POST['up_id']) && isset($_POST['up_id']) && ( isLogin() != null) ) {
		$up_id = $_POST['up_id'];
		$name = $_POST['name'];
		$designation = $_POST['designation'];
		$department = $_POST['department'];
		echo $name,$designation,$department;
		$up_res = update_staff($up_id,$name,$designation,$department);
		if ($up_res == "success") {
		
?>
	<script type="text/javascript">
				
				swal("Good Job!", "Successfully Registered", "success")
			</script>
<?php
		} else {
			?>
	<script type="text/javascript">
			
			swal("Failed!", "<?php echo $up_res; ?>", "error")
		</script>
<?php
		}
		require_once "../includes/view_staff.inc.php";
		
	}
?>
