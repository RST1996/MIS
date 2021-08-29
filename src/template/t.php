<!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
				
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
					$user_id = $_SESSION['user_uid'];
						$user_name = $_SESSION['username'];
						$user_type = $_SESSION['user_type'];
				
							if($user_type == 2)
							{
								$result = mysqli_query($dbcon,"SELECT `staff_type_id`,`staff_id` FROM `staff_role` WHERE `staff_id`='$user_id'");
								$data = mysqli_fetch_assoc($result);
								$staff_type_id= $data['staff_type_id'];		
								$query0 = "SELECT `role_id`,`user_type`,`staff_type` FROM `role_assign` WHERE  `staff_type` = '$staff_type_id'";
							}
							else
							{
								$query0 = "SELECT `role_id`,`user_type`,`staff_type` FROM `role_assign` WHERE  `user_type` = '$user_type'";
				
							}
								if ($res0 = mysqli_query($dbcon,$query0)) {
									
								if (mysqli_num_rows($res0) > 0) {
									while ($row0= mysqli_fetch_assoc($res0)) {
										$role_id=$row0['role_id'];
										$query = "SELECT  DISTINCT `role_type` FROM `roles` WHERE `id` = '$role_id' ";
										
										if ($res = mysqli_query($dbcon,$query)) {
											if (mysqli_num_rows($res) > 0) {
												while ($row = mysqli_fetch_assoc($res)) {
													$role_type = $row['role_type'];
													?>
													<li>
																	<a href="javascript:void(0);" class="menu-toggle">
																		<i class="material-icons">widgets</i>
																		<span><?php echo $role_type; ?></span>
																	</a>
																	<ul class="ml-menu">
													<?php
													
													$query2 = "SELECT `path`,`role_name` FROM `roles` WHERE `role_type` = '$role_type'";
													if ($res2 = mysqli_query($dbcon,$query2)) {
														if (mysqli_num_rows($res2) > 0) {
															while ($row2 = mysqli_fetch_assoc($res2)) {
																$role_name = $row2['role_name'];
																$path = $row2['path'];
																?>
																
																	
																		<li>
																					<a href="<?php echo "../".$path; ?>"><?php echo $role_name; ?></a>
																		</li>
																	
																
																<?php
															}
														}
													}
													else
													{
														echo mysqli_error($dbcon);echo "</br>";
													}
													?>
													</ul>
													</li>
													<?php
												}
											}
										}
									}
								}
								}
?>
 </ul>
            </div>
            <!-- #Menu -->

        </aside>
        <!-- #END# Left Sidebar -->
        