<?php
	session_start();
	require_once "../config/dbconnect.php";
	include "../config/funlib/login_functions.php";
	logout();
/*	session_destroy();
	header("Location:index.php");*/
?>