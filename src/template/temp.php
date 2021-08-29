<?php
	session_start();
	ob_start();
	require_once "../config/dbconnect.php";
	include "../config/funlib/login_functions.php";
	
	require_once "../config/funlib/role_mgmt_functions.php";
	$user_type = isLogin();
	if($user_type != null)
	{
			print_r($_SESSION);
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
<table>
<?php
	//$query = "SELECT * FROM `roles` ORDER BY `role_type`";
	/*
	$query = "SELECT 'role_type','role_name' = 
    STUFF (SELECT ', ' + 'role_name'
           FROM 'roles' b 
           WHERE b.'role_type' = a.'role_type'
          )
FROM 'roles' a
GROUP BY 'role_type'";
*/
echo $user_id;
echo $user_ref_id;
$query = "SELECT `roles`.*,`role_assign`.`user_type`,`staff_role`.`staff_type_id`,`staff_role`.`staff_id`
			FROM `roles`,`role_assign`,`staff_role`
			WHERE `role_assign`.`role_id` = `roles`.`id`
				AND `role_assign`.`user_type` = $user_id
			ORDER BY `roles`.`role_type`
			";

	//echo $query;
	//echo "\n";
	if ($res = mysqli_query($dbcon,$query)) {
		print_r($res);
		echo "\n";
		if (mysqli_num_rows($res) > 0)
		{
				echo "\n";
			print_r($res);
			while ($row = mysqli_fetch_assoc($res)) {
				$role_name = $row['role_name'];
				$path = $row['path'];
				$user = $row['user_type'];
				if($role_type = $row['role_type'])
				{
					?>
					<tr>
					<td><?php echo $role_name; ?></td>
					<td><?php echo $role_type; ?></td>
					<td><?php echo $path; ?></td>
					<td><?php echo $user; ?></td>
					
				</tr>
				<?php
				$role_type = $row['role_type'];
			}
				
			}
		}
	
	}else {
			return "Unable to add course ".mysqli_error($dbcon);
		}

?>
</table>