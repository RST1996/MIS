<?php
	session_start();
	require_once "../dbconnect.php";
	require_once "../funlib/login_functions.php";
	require_once "../funlib/user_mgmt_functions.php";
	if (isset($_POST['del_id']) && ( isLogin() != null) ) {
		$del_id = $_POST['del_id'];
		$del_res = delete_staff($del_id);
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
		require_once "../includes/view_staff.inc.php";
		
	}
?>
