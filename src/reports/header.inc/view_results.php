
<?php
	$page = "reports/view_results.php";
	$eligibility = is_eligible($page,$user_ref_id,$user_type);
	if($eligibility == true)
	{
		
	}
	else
	{
		header("Location:../template/404.php");
		die("You are not authorized to view this page!!!");
	}

?>
<script src="../plugins/BlockUI/jquery.blockUI.js"></script>