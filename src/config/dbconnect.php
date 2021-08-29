<?php
	$dbcon = mysqli_connect('localhost','gcoej_mis','BSU7TUJ9') or die("Unable to connect to the database");
	$dbsel = mysqli_select_db($dbcon,'gcoej_mis') or die(mysqli_error($dbcon));
	date_default_timezone_set('Asia/Kolkata');
?>