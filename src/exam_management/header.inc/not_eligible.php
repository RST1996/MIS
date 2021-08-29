<?php
	$page = "exam_management/not_eligible.php";
	$eligibility = is_eligible($page,$user_ref_id,$user_type);
	if($eligibility == true)
	{
		$activity = check_activity($page);
		//var_dump($activity);
		if(is_string($activity))
		{
?>
		<script type="text/javascript">
			swal("Not Allowed",<?php echo $activity; ?>,"warning");
			
		</script>
<?php
		header( "refresh:1; url=../" );
		die("Activity nott started contact admin ");
		}
		
	}
	else
	{
		header("Location:../");
		die("You are not authorized to view this page!!!");
	}

?>	
    <!-- JQuery DataTable Css -->
    <link href="../plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
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
    <script src="../plugins/BlockUI/jquery.blockUI.js"></script>
	<link href="../plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

	<!-- Jquery DataTable Plugin Js -->
    <script src="../plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="../plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="../plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script src="../plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="../plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="../plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="../plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="../plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
    <script src="../plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>

