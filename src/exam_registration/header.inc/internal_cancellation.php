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
<?php
	$page = "exam_registration/internal_cancellation.php";
	$eligibility = is_eligible($page,$user_ref_id,$user_type);
	if($eligibility == true)
	{
		$activity = check_activity($page);
       
        if(is_string($activity))
        {

			header("Location:../template/500.php");
        }
	}
	else
	{
		header("Location:../");
		die("You are not authorized to view this page!!!");
	}

?>	
   