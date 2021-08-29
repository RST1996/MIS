<?php
	$page = "rights/view_activity.php";
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
	<!-- Bootstrap Material Datetime Picker Css -->
    <link href="../plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

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
	<!-- Moment Plugin Js -->
    <script src="../plugins/momentjs/moment.js"></script>

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="../plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

    