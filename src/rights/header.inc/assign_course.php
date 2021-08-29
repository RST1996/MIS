
<?php
	$page = "rights/assign_course.php";
	$eligibility = is_eligible($page,$user_ref_id,$user_type);
	if($eligibility == true)
	{
		
	}
	else
	{
		header("Location:../");
		die("You are not authorized to view this page!!!");
	}

?>
<!-- Sweet Alert Css -->
    <link href="../plugins/sweetalert/sweetalert.css" rel="stylesheet" />
	<script src="../js/select.js"></script>

	<script src="../js/pages/forms/form-wizard.js"></script>


    <!-- Jquery Validation Plugin Css -->
    <script src="../plugins/jquery-validation/jquery.validate.js"></script>

    <!-- JQuery Steps Plugin Js -->
    <script src="../plugins/jquery-steps/jquery.steps.js"></script>

    <!-- Sweet Alert Plugin Js -->
    <script src="../plugins/sweetalert/sweetalert.min.js"></script>
	<link href="../plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
