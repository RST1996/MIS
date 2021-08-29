<?php
	session_start();
	require_once "../dbconnect.php";
	require_once "../funlib/login_functions.php";
	if (isset($_POST['ctype']) && ( isLogin() != null)) {
		$ctype = $_POST['ctype'];
		switch ($ctype) {
			case 1:
				require_once "pract_scheme.php";
				break;
			case 2:
				require_once "th_scheme.php";
				break;
			default:
				
				break;
		}
	}
?>