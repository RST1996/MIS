<?php
	session_start();
	require_once "../dbconnect.php";
	require_once "../funlib/login_functions.php";
	require_once "../funlib/role_mgmt_functions.php";
	if (isset($_POST['staff_id']) && isset($_POST['staff_role_id']) && ( isLogin() != null) ) {
		$staff_id = $_POST['staff_id'];
		$staff_type_id = $_POST['staff_role_id'];
		$del_res = remove_staff_role($staff_id,$staff_type_id);
		if ($del_res == "success") {
			$msg = "Remove action successfully performed!";
		} else {
			$msg = $del_res;
		}
?>
	<script type="text/javascript">
		alert("<?php echo $msg; ?>");
	</script>
<?php
		require_once "../includes/view_staff_roles.inc.php";
		
	}
?>
