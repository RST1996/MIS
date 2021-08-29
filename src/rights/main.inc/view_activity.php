
<section class="content">
<div class="container-fluid">
	<div class="row clearfix">
             
                            <form id="wizard_with_validation" action="view_activity.php" method="POST">
                                <fieldset>
                                    
                <!-- Task Info -->
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2>ACTIVITY INFORMATION</h2>
                            
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
                                            <th>End Date</th>
                                          
											
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php
											$i = 1;
											$select_query = "SELECT `activity_manager`.`act_id`,`activities`.`name`,`exam_table`.`exam_name`,`activity_manager`.`start_time`,`activity_manager`.`stop_time` FROM `activity_manager`,`activities`,`exam_table` WHERE `activity_manager`.`act_id` = `activities`.`id`  AND `activities`.`exam_id` = `exam_table`.`id`";
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
											<td><?php echo date_format($stop, 'd-m-Y');?></td>
											
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
                                                    <div class="progress-bar bg-green" role="progressbar" aria-valuenow="<?php echo $value_now;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $value_now."%";?>"><?php echo $value_now."%";?></div>
													

                                                </div>
                                            </td>
											<td><?php echo date_format($stop, 'd-m-Y');?></td>
											
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
									
                                </fieldset>
                            </form>
                       
            </div>

</div>
</section>


    <script src="../plugins/bootstrap-notify/bootstrap-notify.js"></script>
    <script type="text/javascript">
		$('.datetimepicker').bootstrapMaterialDatePicker({
	        format: 'YYYY-MM-DD HH:mm:ss',
	        clearButton: true,
	        weekStart: 1
	    });
    </script>
	