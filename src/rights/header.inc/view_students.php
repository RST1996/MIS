
<?php
	$page = "rights/view_students.php";
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