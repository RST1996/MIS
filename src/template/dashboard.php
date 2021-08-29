<?php
	session_start();
	ob_start();
	require_once "../config/dbconnect.php";
	include "../config/funlib/login_functions.php";
	
	require_once "../config/funlib/role_mgmt_functions.php";
	$user_type = isLogin();
	if($user_type != null)
	{
		$user_id = $_SESSION['user_uid'];
		$user_ref_id = $_SESSION['user_ref_id'];
		$_SESSION["user_type"] = $user_type;
	}
	else
	{
		header('Location:../template/login.php');
		die("Access Denied :( ");
	}
	ob_end_flush();
	
?>
<!DOCTYPE html>
<html>

<?php
	include("head.php");
	$_SESSION["theme"] = "theme-deep-purple" ;
?>

<body class="<?php echo $_SESSION["theme"];?> ">
   <?php
		include("loader.php");
   ?>
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    
    <?php
		include("navbar.php");
   ?>
    <section>
         
    <?php
		include("leftside.php");
		
		include("rightside.php");
		
   ?>
        
    </section>
	<?php
		include("jquery.php");
		if($user_type == 1)
			include("admin_dashboard.php");
		
   ?>
   




