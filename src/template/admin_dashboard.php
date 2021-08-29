    <section class="content">
	<div class="container-fluid">
            <div class="block-header">
                <h2>DASHBOARD</h2>
            </div>

            <!-- Widgets -->
            <div class="row clearfix">
                
				<?php
								$select_all_query = "SELECT count(`id`) as `total` FROM `student` WHERE 1";
								if ($res = mysqli_query($dbcon,$select_all_query)) {
										if (mysqli_num_rows($res) > 0) {
											$row = mysqli_fetch_assoc($res);
											
										}
								}
							?>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-indigo hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">people</i>
                        </div>
                        <div class="content">
                            <div class="text">Total Students</div>
							
                            <div class="number count-to" data-from="0" data-to="<?php echo $row['total'];?>" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
					<?php
								$select_pass_query = "SELECT count(`id`) as `total_pass` FROM `student` WHERE `status` = 'PASS'";
								if ($res = mysqli_query($dbcon,$select_pass_query)) {
										if (mysqli_num_rows($res) > 0) {
											$row = mysqli_fetch_assoc($res);
											
										}
								}
							?>
				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-purple hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">school</i>
                        </div>
                        <div class="content">
                            <div class="text">Total Students (Pass-out) </div>
                            <div class="number count-to" data-from="0" data-to="<?php echo $row['total_pass'];?>" data-speed="15" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
				<?php
								$select_fail_query = "SELECT count(`id`) as `current` FROM `student` WHERE `status` = 'ONGOING'";
								if ($res = mysqli_query($dbcon,$select_fail_query)) {
										if (mysqli_num_rows($res) > 0) {
											$row = mysqli_fetch_assoc($res);
											
										}
								}
							?>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-deep-purple hover-expand-effect">
                        <div class="icon">
                           <i class="material-icons">local_library</i>
                        </div>
                        <div class="content">
                            <div class="text">Total Students (Current) </div>
                            <div class="number count-to" data-from="0" data-to="<?php echo $row['current'];?>" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
                <?php
								$select_query = "SELECT count(`id`) as `total_staff` FROM `staff`";
								if ($res = mysqli_query($dbcon,$select_query)) {
										if (mysqli_num_rows($res) > 0) {
											$row = mysqli_fetch_assoc($res);
											
										}
								}
							?>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-blue hover-expand-effect">
                        <div class="icon">
                           <i class="material-icons">people</i>
                        </div>
                        <div class="content">
                            <div class="text">Total Staff </div>
                            <div class="number count-to" data-from="0" data-to="<?php echo $row['total_staff'];?>" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
				
            </div>
            <!-- #END# Widgets -->
           
           

            <div class="row clearfix">
                <!-- Task Info -->
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <div class="card">
                        <div class="header">
                            <h2>ACTIVITY INFOS</h2>
                            
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-hover dashboard-task-infos">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Activity</th>
											<th>Exam</th>
                                            <th>Status</th>
                                            <th>Progress</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
											$i = 1;
											$select_query = "SELECT `activities`.`name`,`exam_table`.`exam_name`,`activity_manager`.`start_time`,`activity_manager`.`stop_time` FROM `activity_manager`,`activities`,`exam_table` WHERE `activity_manager`.`act_id` = `activities`.`id`  AND `activities`.`exam_id` = `exam_table`.`id`";
											if ($res = mysqli_query($dbcon,$select_query)) {
													if (mysqli_num_rows($res) > 0) {
														while($row = mysqli_fetch_assoc($res))
														{
															$start = new DateTime($row['start_time']);
															$stop = new DateTime($row['stop_time']);
															$now = new DateTime(gmdate('Y-m-d h:i:s \G\M\T'));
															$diff = $stop->diff($start);

															$total_hours = $diff->h;
														 	$total_hours = $total_hours + ($diff->days*24);
															$current_diff = $stop->diff($now);
															if($stop > $now)
															{
																$current_hours = $current_diff->h;
																$current_hours = $current_hours + ($current_diff->days*24);
																
																$value_old = number_format( ($current_hours/$total_hours)*100 , 0 );
																$value_now = 100 - $value_old;
															}
															else
															{
																$value_now = 100;
															}
															if($value_now < 100)
															{
																															
														?>
														<tr>
															<td><?php echo $i;?></td>
															<td><?php echo $row['name'];?></td>
															<td><?php echo $row['exam_name'];?></td>
															<td><span class="label bg-blue">Running</span></td>
															<td>
																<div class="progress">
																	<div class="progress-bar bg-blue" role="progressbar" aria-valuenow="<?php echo $value_now;?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $value_now."%";?>"><?php echo $value_now."%";?></div>
																	

																</div>
															</td>
														</tr>
													   <?php
														}
														else 
														{
																		?>
													<tr>
														<td><?php echo $i;?></td>
														<td><?php echo $row['name'];?></td>
														<td><?php echo $row['exam_name'];?></td>
														<td><span class="label bg-green">END</span></td>
														<td>
															<div class="progress">
																<div class="progress-bar bg-green" role="progressbar" aria-valuenow="<?php echo $value_now;?>" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $value_now."%";?>"><?php echo $value_now."%";?></div>
																	

															</div>
														</td>
													</tr>
												   <?php
														}
														
															$i++;
														}
														
									   		
													}
											}
									   ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- #END# Task Info -->
               
            </div>
        </div>
		</section>
		<script src="../plugins/jquery-countto/jquery.countTo.js"></script>
    <script src="../js/pages/widgets/infobox/infobox-2.js"></script>