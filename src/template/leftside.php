
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
				<?php
						$user_id = $_SESSION['user_uid'];
						$user_name = $_SESSION['username'];
						$user_type = $_SESSION['user_type'];
						$user_ref_id = $_SESSION['user_ref_id'];
				?>
				
                </div>
                <div class="info-container">
					<br />
					<br />
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $user_name;?></div>
					
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="../student/edit_profile.php"><i class="material-icons">person</i>Profile</a></li>
                            <li><a href="../student/edit_password.php"><i class="material-icons">mode_edit</i>Edit password</a></li>
                            <li><a href="../template/logout.php"><i class="material-icons">input</i>Sign Out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">MAIN NAVIGATION</li>
					  <li class="active">
                        <a href="../">
                            <i class="material-icons">home</i>
                            <span>Home</span>
                        </a>
					  </li>
					
					<?php
							
							if($user_type == 2)
							{ 
								$result = mysqli_query($dbcon,"SELECT `staff_type_id`,`staff_id` FROM `staff_role` WHERE `staff_id`='$user_ref_id'");
								$data = mysqli_fetch_assoc($result);
								$staff_type_id= $data['staff_type_id'];		
								//$query = "SELECT `role_id`,`user_type`,`staff_type` FROM `role_assign` WHERE  `staff_type` = '$staff_type_id'";
								$query = "SELECT `role_id`,`user_type`,`staff_type` FROM `role_assign` WHERE  `user_type` = '$user_type'";
				
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
										
										$query2 = "SELECT `path` FROM `roles` WHERE `role_name` = '$role_name'";
										if ($res2 = mysqli_query($dbcon,$query2)) {
											if (mysqli_num_rows($res2) > 0) {
												while ($row2 = mysqli_fetch_assoc($res2)) {
														$path = $row2['path'];
					?>
					<li>
						<a href="<?php echo "../".$path?>">
                            <i class="material-icons">layers</i>
                            <span><?php echo $role_name?></span>
                        </a>
					</li>
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
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; 2017 <a href="../">GCoE, Jalgaon - MIS</a>.
                </div>
                <div class="version">
                    <b></b> 
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
        