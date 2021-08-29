<?php
	$query = "SELECT `student`.`id` ,`student`.`prn`,`student`.`name`,`exam_registration`.`regular_flag` FROM `student`,`exam_registration` WHERE `exam_registration`.`sesn_id` = '$sesn_id' AND `exam_registration`.`stud_id` = `student`.`id` AND `exam_registration`.`course_id` = '$course_id' AND `exam_registration`.`conform_status` = '1' AND `student`.`department` = '$dept'";
		if($res = mysqli_query($dbcon,$query))
		{
			if(mysqli_num_rows($res) > 0)
			{
?>
							<table id="student_table" class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
										<th>PRN</th>
										<th>Name</th>
										<th>ICA</th>
										<th>ESE</th>
										<th>Total</th>
										<th>Result</th>
										<th>Grade</th>

                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
										<th>PRN</th>
										<th>Name</th>
										<th>ICA</th>
										<th>ESE</th>
										<th>Total</th>
										<th>Result</th>
										<th>Grade</th>
                                    </tr>
                                </tfoot>
                                <tbody>
<?php
				while ($row = mysqli_fetch_assoc($res))
				{
					$stud_id = $row['id'];
					$prn = $row['prn'];
					$name = $row['name'];
					$mark = 0;
					$sesn_id = get_sesn_id();
					$regular_flag = $row['regular_flag'];
					/****************************************************/
					//Get the marking scheme of the subject
					$mk_sch_query = "SELECT * FROM `pr_mks_scheme` WHERE `sub_id` = '$course_id';";
					if($mk_sch_res = mysqli_query($dbcon,$mk_sch_query))
					{
						if(mysqli_num_rows($mk_sch_res) == 1)
						{
							$mk_sch = mysqli_fetch_assoc($mk_sch_res);
							$ese_max_marks = $mk_sch['ese'];
							$ica_max_marks = $mk_sch['ica'];
						}
						else
						{
							die("Failed to identify the subjects");	
						}
					}
					else
					{
						die("Failed to get the marking scheme ".mysqli_error);
					}

					/****************************************************/
					if ($regular_flag == 1) 
					{
						// echo "regular cource";
						// echo "<br/>";
						if($ica_max_marks > 0)
						{
							$ica_marks = get_ica_marks($stud_id,$course_id,$sesn_id);
							if($ica_marks == 0)
							{
								$check_query = "SELECT * FROM `marks_others` WHERE `sesn_id` = '$sesn_id' AND `stud_id` = '$stud_id' AND `course_id` = '$course_id' AND `exam_type` = '4' AND `marks` = '0'";
								if($check_res = mysqli_query($dbcon,$check_query))
								{
									if(mysqli_num_rows($check_res) == 1)
									{
										$check_row = mysqli_fetch_assoc($check_res);
										if($check_row['ne_flag'] == 1)
										{
											$ica_marks = "N.E.";
										}
										elseif ($check_row['ab_flag'] == 1)
										{
											$ica_marks = "AB";
										}
									}
									else
									{
										$ica_marks = "N.F.";
									}
								}
							}
							else
							{
								$mark += $ica_marks;
							}
						}
						if($ese_max_marks > 0)
						{
							// echo "In ese calculation";
							$ese_marks = get_ese_pr_marks($stud_id,$course_id,$sesn_id);
							if(copycase($sesn_id,$course_id,$stud_id,'6'))
							{
								$ese_marks = "CPS";
							}
							elseif($ese_marks == 0)
							{
								$check_query = "SELECT * FROM `marks_pr_ese` WHERE`sesn_id` = '$sesn_id' AND `stud_id` = '$stud_id' AND `course_id` = '$course_id'";
								if($check_res = mysqli_query($dbcon,$check_query))
								{
									if(mysqli_num_rows($check_res) == 1)
									{
										$check_row = mysqli_fetch_assoc($check_res);
										//print_r($check_row);
										//echo PHP_EOL;
										if($check_row['ne_flag'] == 1)
										{
											$ese_marks = "N.E.";
										}
										elseif ($check_row['ab_flag'] == 1)
										{
											$ese_marks = "AB";
										}
									}
									else
									{

										$ese_marks = "N.F.";
									}
								}
							}
							else
							{
								$mark += $ese_marks;
							}
						}
						else
						{
							$ese_marks = "--";
						}
						// echo "<br/>";
						// echo $ese_marks;
						// echo "<br/>";
					}
					else
					{
						if($ica_max_marks > 0)
						{
							$prev_ica_marks_query = "SELECT `marks_others`.`marks` FROM `marks_others` WHERE `marks_others`.`sesn_id` = ( SELECT  `exam_registration`.`sesn_id` FROM `exam_registration` WHERE `exam_registration`.`course_id` = '$course_id' AND `exam_registration`.`stud_id` = '$stud_id' AND  `exam_registration`.`sesn_id` <> '$sesn_id' ORDER BY `exam_registration`.`sesn_id` LIMIT 1 ) AND `marks_others`.`stud_id` = '$stud_id' AND `marks_others`.`course_id` = '$course_id' AND `marks_others`.`exam_type` = '4'";
							if($prev_ica_marks_res = mysqli_query($dbcon,$prev_ica_marks_query))
							{
								if(mysqli_num_rows($prev_ica_marks_res) == 1)
								{
									$prev_ica_marks_row = mysqli_fetch_assoc($prev_ica_marks_res);
									$prev_ica_marks = $prev_ica_marks_row['marks'];

								}
								else
								{
									//NO previous record found, get the new marks and set the result
									$prev_ica_marks = 0;//so as it will now get the marks entered in the current session
								}
							}
							else
							{
								echo "FAiled to get the previous record ".mysqli_error($dbcon);
							}

							if($prev_ica_marks < ($ica_max_marks * 0.4))
							{
								$ica_marks = get_ica_marks($stud_id,$course_id,$sesn_id);
								if($ica_marks == 0)
								{
									$check_query = "SELECT * FROM `marks_others` WHERE `sesn_id` = '$sesn_id' AND `stud_id` = '$stud_id' AND `course_id` = '$course_id' AND `exam_type` = '4' AND `marks` = '0'";
									if($check_res = mysqli_query($dbcon,$check_query))
									{
										if(mysqli_num_rows($check_res) == 1)
										{
											$check_row = mysqli_fetch_assoc($check_res);
											if($check_row['ne_flag'] == 1)
											{
												$ica_marks = "N.E.";
											}
											elseif ($check_row['ab_flag'] == 1)
											{
												$ica_marks = "AB";
											}
										}
										else
										{
											$ica_marks = "N.F.";
										}
									}
								}
								else
								{
									$mark += $ica_marks;
								} 
							}
							else
							{
								$ica_marks = $prev_ica_marks;
								$mark += $ica_marks;
							}
						}

						if($ese_max_marks > 0)
						{	
							$prev_ese_marks_query = "SELECT `marks_pr_ese`.`marks` FROM `marks_pr_ese` WHERE `marks_pr_ese`.`sesn_id` = ( SELECT  `exam_registration`.`sesn_id` FROM `exam_registration` WHERE `exam_registration`.`course_id` = '$course_id' AND `exam_registration`.`stud_id` = '$stud_id' AND  `exam_registration`.`sesn_id` <> '$sesn_id' ORDER BY `exam_registration`.`sesn_id` LIMIT 1 ) AND `marks_pr_ese`.`stud_id` = '$stud_id' AND `marks_pr_ese`.`course_id` = '$course_id' AND `marks_pr_ese`.`exam_type` = '6'";
							if($prev_ese_marks_res = mysqli_query($dbcon,$prev_ese_marks_query))
							{
								if(mysqli_num_rows($prev_ese_marks_res) == 1)
								{
									$prev_ese_marks_row = mysqli_fetch_assoc($prev_ese_marks_res);
									$prev_ese_marks = $prev_ese_marks_row['marks'];

								}
								else
								{
									//NO previous record found, get the new marks and set the result
									$prev_ese_marks = 0;//so as it will now get the marks entered in the current session
								}
							}
							else
							{
								echo "FAiled to get the previous record ".mysqli_error($dbcon);
							}

							if($prev_ese_marks < ($ese_max_marks * 0.4))
							{
								$ese_marks = get_ese_pr_marks($stud_id,$course_id,$sesn_id);
								if(copycase($sesn_id,$course_id,$stud_id,'6'))
								{
									$ese_marks = "CPS";
								}
								elseif($ese_marks == 0)
								{
									$check_query = "SELECT * FROM `marks_pr_ese` WHERE`sesn_id` = '$sesn_id' AND `stud_id` = '$stud_id' AND `course_id` = '$course_id'";
									if($check_res = mysqli_query($dbcon,$check_query))
									{
										if(mysqli_num_rows($check_res) == 1)
										{
											$check_row = mysqli_fetch_assoc($check_res);
											//print_r($check_row);
											//echo PHP_EOL;
											if($check_row['ne_flag'] == 1)
											{
												$ese_marks = "N.E.";
											}
											elseif ($check_row['ab_flag'] == 1)
											{
												$ese_marks = "AB";
											}
										}
										else
										{

											$ese_marks = "N.F.";
										}
									}
								}
								else
								{
									$mark += $ese_marks;
								} 
							}
							else
							{
								$ese_marks = $prev_ese_marks;
								$mark += $ese_marks;
							}
						}
						else
						{
							$ese_marks = "--";
						}
						/* RE-code this section many changes has to be made as per the rules and the marks storage techniques*/
						// if(is_internal_cancel($sesn_id,$stud_id,$course_id))
						// {
						// 	$ese_marks = get_ese_pr_marks($stud_id,$course_id,$sesn_id);
						// 	$ica_marks = "N.A.";
						// }
						// else
						// {
						// 	$prev_sesnid = get_old_sesn_id($stud_id,$course_id);
						// 	$ica_marks = get_ica_marks($stud_id,$course_id,$prev_sesnid);
						// 	if($ica_marks == 0)
						// 	{
						// 		$check_query = "SELECT * FROM `marks_others` WHERE `sesn_id` = '$sesn_id' AND `stud_id` = '$stud_id' AND `course_id` = '$course_id' AND `exam_type` = '4' AND `marks` = '0'";
						// 		if($check_res = mysqli_query($dbcon,$check_query))
						// 		{
						// 			if(mysqli_num_rows($check_res) == 1)
						// 			{
						// 				$check_row = mysqli_fetch_assoc($check_res);
						// 				if($check_row['ne_flag'] == 1)
						// 				{
						// 					$ica_marks = "N.E.";
						// 				}
						// 				elseif ($check_row['ab_flag'] == 1)
						// 				{
						// 					$ica_marks = "AB";
						// 				}
						// 			}
						// 			else
						// 			{
						// 				$ica_marks = "N.F.";
						// 			}
						// 		}
						// 	}
						// 	else
						// 	{
						// 		$marks += $ica_marks;
						// 	}

						// 	$ese_marks = get_ese_pr_marks($stud_id,$course_id,$sesn_id);
						// }
					}
					//echo is_numeric($ese_marks);
					if( is_numeric($ese_marks) || $ese_max_marks == 0 )
					{
						//echo "in correct block";
						if($mark > $limit)
						{
							$grade = "A+";
						}
						elseif ($mark >= $limit2 && $mark <=$limit) {
							$grade = "A";
						}
						elseif ($mark >= $limit3 && $mark <$limit2) {
							$grade = "B+";
						}
						elseif ($mark >= $limit4 && $mark <$limit3) {
							$grade = "B";
						}
						elseif ($mark >= $limit5 && $mark <$limit4) {
							$grade = "C+";
						}
						elseif ($mark >= $pass_limit && $mark <$limit5) {
							$grade = "C";
						}
						elseif ($mark < $pass_limit) {
							$grade = "F";
						}
						if($mark >= $pass_limit)
						{
							if($ese_max_marks > 0 && $ica_max_marks > 0)
							{
								if( $ese_marks >= $ese_max_marks*0.4 && $ica_marks >= $ica_max_marks*0.4 )
								{
									$status = "PASS";
								}
								else
								{
									$status = "FAIL";
									$grade = "F";
								}
							}
							else
							{
								$status = "PASS";
							}
						}
						else
						{
							$status = "FAIL";
							$grade = "F";
						}
					}
					else
					{
						if($ese_marks == "N.E.")
						{
							$grade = "Z";
						}
						elseif ($ese_marks == "AB") {
							$grade = "I";
						}
						else
							$grade = "F";
						$status = "Fail";
					}
?>
									<tr>
										<td><?php echo $prn; ?></td>
										<td><?php echo $name; ?></td>
										<td><?php echo $ica_marks; ?></td>
										<td><?php echo $ese_marks; ?></td>
										<td><?php echo $mark; ?></td>
										<td><?php echo $status; ?></td>
										<td><?php echo $grade; ?></td>
									</tr>
<?php
				}
?>
                                </tbody>
                            </table>
<?php
			}
			else
			{
				echo "No students found..!!";
			}
		}
		else
		{
			echo "Something went wrong.. ".mysqli_error($dbcon);
		}
?>