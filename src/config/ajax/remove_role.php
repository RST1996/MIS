<?php
	session_start();
	require_once "../dbconnect.php";
	require_once "../funlib/login_functions.php";
	require_once "../funlib/role_mgmt_functions.php";
	if (isset($_POST['role_id']) && isset($_POST['user_type']) && isset($_POST['staff_type']) && ( isLogin() != null) ) {
		$role_id = $_POST['role_id'];
		$user_type = $_POST['user_type'];
		$staff_type = $_POST['staff_type'];
		$del_res = delete_staff_role($role_id,$user_type,$staff_type);
		if ($del_res == "success") {
			$msg = "Delete action successfully performed!";
		} else {
			$msg = $del_res;
		}
?>
	<script type="text/javascript">
		alert("<?php echo $msg; ?>");
	</script>
<?php
		require_once "../includes/view_roles.inc.php";
		
	}
?>
