<?php
	session_start();
	ob_start();
	require_once "../config/dbconnect.php";
	include "../config/funlib/role_mgmt_functions.php";
?>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
				<?php
						print_r($_SESSION);
						$user_id = $_SESSION['user_uid'];
						$user_name = $_SESSION['username'];
						$user_type = $_SESSION['user_type'];
				?>
				
                </div>
               
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">MAIN NAVIGATION</li>
					  <li class="active">
                        <a href="../template/index.php">
                            <i class="material-icons">home</i>
                            <span>Home</span>
                        </a>
					  </li>
					
					<?php
							if($user_type == 2)
							{
								$result = mysqli_query($dbcon,"SELECT `staff_type_id`,`staff_id` FROM `staff_role` WHERE `staff_id`='$user_id'");
								$data = mysqli_fetch_assoc($result);
								$staff_type_id= $data['staff_type_id'];		
								$query = "SELECT `role_id`,`user_type`,`staff_type` FROM `role_assign` WHERE  `staff_type` = '$staff_type_id'";
							}
							else
							{
								$query = "SELECT `role_id`,`user_type`,`staff_type` FROM `role_assign` WHERE  `user_type` = '$user_type'";
				
							}
								if ($res = mysqli_query($dbcon,$query)) {
									
								if (mysqli_num_rows($res) > 0) {
									while ($row = mysqli_fetch_assoc($res)) {
										$role_id = $row['role_id'];
										$user_type = $row['user_type'];
										$staff_type = $row['staff_type'];
										$role_name = get_role_name($role_id);
										$user_type_name = get_user_type_name($user_type);
										if($user_type == 2)
										{
											$staff_type_name = get_staff_type_name($staff_type);
											
											
										}
										else
										{
											$staff_type_name = "NOT A STAFF..";
											
										}
										
										$query2 = "SELECT `role_type` FROM `roles` WHERE `roles`.`role_name`=$role_name";
										if ($res2 = mysqli_query($dbcon,$query2)) {
											if (mysqli_num_rows($res2) > 0) {
												while ($row2 = mysqli_fetch_assoc($res2)) {
													
														$role_type = $row2['role_type'];
														echo $role_type."</br>";
					?>
				<!--	
					<li>
                        <a href="javascript:void(0);" class="menu-toggle">
                            <i class="material-icons">widgets</i>
                            <span><?php echo $role_type; ?></span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                        <a href=""><?php echo $role_name; ?></a>
                            </li>
                        </ul>
                    </li>
					-->
								<?php
												}
											}
										}
										
									}
								}
								}
							//}
									?>
                   <!--   
				   <li>
                        <a href="../course_Registration/course.php">
                            <i class="material-icons">text_fields</i>
                            <span>Course Registration</span>
                        </a>
                    </li>
					
					-->
					
                </ul>
            </div>
            <!-- #Menu -->

        </aside>
        <!-- #END# Left Sidebar -->
        