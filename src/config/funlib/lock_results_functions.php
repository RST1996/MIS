<?php
	function lock_results($sesn_id,$sec_pass)
	{

		global $dbcon;
		//max_execution_time(600);
		$pass = base64_encode(md5($sec_pass));
		$uid = $_SESSION['user_uid'];
		$query = "SELECT  `username` FROM `users` WHERE `id` = '$uid'";
		if ($res = mysqli_query($dbcon,$query)) 
		{
			while ($row = mysqli_fetch_assoc($res)) 
			{
				$username = $row['username'];
				$check_query = "SELECT `id` FROM `users` WHERE `username` = '$username' AND `password` = '$pass'";
				if ($r = mysqli_query($dbcon,$check_query)) 
				{
					if( mysqli_num_rows($r) == 1 ) 
					{
						/*****************************************************************************
							CALCULATE GRADES FOR SUBJECTS AND UPDATE THE GRADES FOR RESP. STUDENTS
						*****************************************************************************/
						$sub_sel_query = "SELECT DISTINCT `course_id` FROM `exam_registration` WHERE `sesn_id` = '$sesn_id'";
						if($sub_res = mysqli_query($dbcon,$sub_sel_query))
						{
							if(mysqli_num_rows($sub_res) > 0)
							{
								while($sub_row = mysqli_fetch_assoc($sub_res))
								{
									$course_id = $sub_row['course_id'];
									/******************************
										CALCULATING GRADES LIMIT
									********************************/

									$max_marks = get_max_marks($course_id);
									$ese_max_marks = get_ese_max_marks($course_id);
									$query ="SELECT `student`.`id`,`exam_registration`.`regular_flag` FROM `student`,`exam_registration` WHERE `exam_registration`.`sesn_id` = '$sesn_id' AND `exam_registration`.`course_id` = '$course_id' AND `exam_registration`.`stud_id` = `student`.`id` AND `exam_registration`.`conform_status` = '1'";
									$marks = array();

									if($res = mysqli_query($dbcon,$query))
									{
										$num_of_students = mysqli_num_rows($res);
										if(mysqli_num_rows($res) > 0)
										{
											
											while ($row = mysqli_fetch_assoc($res)) {
												$stud_id = $row['id'];
												$regular_flag = $row['regular_flag'];
												if ($regular_flag == 1) {
													$marks[] = get_total_marks_obtained($stud_id,$course_id);
												} else {
													$marks[] = get_total_marks_obtained_back($stud_id,$course_id);
												}
												
												
											}
											//print_r($marks);
											
										}
									}
									if($num_of_students >= 15)
									{
										$limit =  get_limit($marks,sizeof($marks),$max_marks);
										$pass_limit = $max_marks * 0.4 ;
										$diff = ($limit - $pass_limit) / 5 ;
										$limit2 = $limit - $diff ;
										$limit3 = $limit2 - $diff;
										$limit4 = $limit3 - $diff;
										$limit5 = $limit4 - $diff;
									}
									else
									{
										$limit = $max_marks * 0.79;
										$pass_limit = $max_marks * 0.4;
										$limit2 = $max_marks * 0.71;
										$limit3 = $max_marks * 0.62;
										$limit4 = $max_marks * 0.54;
										$limit5 = $max_marks * 0.46;	
									}

									/***************************************
										END OF GRADES LIMIT CALCULATION
									****************************************/

									/***************************************
										UPDATE THE GRADES OF THIS SUBJECT
									****************************************/
									$student_sel_query  = "SELECT `stud_id`,`regular_flag` FROM `exam_registration` WHERE `sesn_id` = '$sesn_id' AND `course_id` = '$course_id' AND `conform_status` = '1'";
									if($student_res = mysqli_query($dbcon,$student_sel_query))
									{
										if(mysqli_num_rows($student_res) > 0)
										{
											while($student_row = mysqli_fetch_assoc($student_res))
											{
												$stud_id = $student_row['stud_id'];
												$regular_flag = $student_row['regular_flag'];

												$course_type = get_course_type($course_id);
												$mark = 0;
												if($course_type == 1)
												{

													if ($regular_flag == 1) 
													{
														$ise1_marks = get_ise1_marks($stud_id,$course_id,$sesn_id);
														if($ise1_marks == 0)
														{
															$check_query = "SELECT * FROM `marks_others` WHERE `sesn_id` = '$sesn_id' AND `stud_id` = '$stud_id' AND `course_id` = '$course_id' AND `exam_type` = '1' AND `marks` = '0'";
															if($check_res = mysqli_query($dbcon,$check_query))
															{
																if(mysqli_num_rows($check_res) == 1)
																{
																	$check_row = mysqli_fetch_assoc($check_res);
																	if($check_row['ne_flag'] == 1)
																	{
																		$ise1_marks = "N.E.";
																	}
																	elseif ($check_row['ab_flag'] == 1)
																	{
																		$ise1_marks = "AB";
																	}
																}
																else
																{
																	$ise1_marks = "N.F.";
																}
															}
														}
														else
														{
															$mark += $ise1_marks;
														}

														$ise2_marks = get_ise2_marks($stud_id,$course_id,$sesn_id);
														if($ise2_marks == 0)
														{
															$check_query = "SELECT * FROM `marks_others` WHERE `sesn_id` = '$sesn_id' AND `stud_id` = '$stud_id' AND `course_id` = '$course_id' AND `exam_type` = '2' AND `marks` = '0'";
															if($check_res = mysqli_query($dbcon,$check_query))
															{
																if(mysqli_num_rows($check_res) == 1)
																{
																	$check_row = mysqli_fetch_assoc($check_res);
																	if($check_row['ne_flag'] == 1)
																	{
																		$ise2_marks = "N.E.";
																	}
																	elseif ($check_row['ab_flag'] == 1)
																	{
																		$ise2_marks = "AB";
																	}
																}
																else
																{
																	$ise2_marks = "N.F.";
																}
															}
														}
														else
														{
															$mark += $ise2_marks;
														}

														$isa_marks = get_isa_marks($stud_id,$course_id,$sesn_id);
														if($isa_marks == 0)
														{
															$check_query = "SELECT * FROM `marks_others` WHERE `sesn_id` = '$sesn_id' AND `stud_id` = '$stud_id' AND `course_id` = '$course_id' AND `exam_type` = '3' AND `marks` = '0'";
															if($check_res = mysqli_query($dbcon,$check_query))
															{
																if(mysqli_num_rows($check_res) == 1)
																{
																	$check_row = mysqli_fetch_assoc($check_res);
																	if($check_row['ne_flag'] == 1)
																	{
																		$isa_marks = "N.E.";
																	}
																	elseif ($check_row['ab_flag'] == 1)
																	{
																		$isa_marks = "AB";
																	}
																}
																else
																{
																	$isa_marks = "N.F.";
																}
															}
														}
														else
														{
															$mark += $isa_marks;
														}
														//echo "Calculating ESE marks";
														$ese_marks = get_ese_th_marks($stud_id,$course_id,$sesn_id);


														if(copycase($sesn_id,$course_id,$stud_id,'5')))
														{
															$ese_marks = "CPS";
														}
														elseif($ese_marks == 0)
														{
															$check_query = "SELECT * FROM `marks_th_ese` WHERE`sesn_id` = '$sesn_id' AND `stud_id` = '$stud_id' AND `course_id` = '$course_id'";
															if($check_res = mysqli_query($dbcon,$check_query))
															{
																if(mysqli_num_rows($check_res) == 1)
																{
																	$check_row = mysqli_fetch_assoc($check_res);
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
														if(is_internal_cancel($sesn_id,$stud_id,$course_id))
														{
															$ese_marks = get_ese_th_marks($stud_id,$course_id,$sesn_id);
															$ise1_marks = $ise2_marks = $isa_marks = "N.A.";
															$mark = $ese_marks*($max_marks/$ese_max_marks);
														}
														else
														{
															$prev_sesnid = get_old_sesn_id($stud_id,$course_id);
															$ise1_marks = get_ise1_marks($stud_id,$course_id,$prev_sesnid);
															if($ise1_marks == 0)
															{
																$check_query = "SELECT * FROM `marks_others` WHERE `sesn_id` = '$prev_sesnid' AND `stud_id` = '$stud_id' AND `course_id` = '$course_id' AND `exam_type` = '1' AND `marks` = '0'";
																if($check_res = mysqli_query($dbcon,$check_query))
																{
																	if(mysqli_num_rows($check_res) == 1)
																	{
																		$check_row = mysqli_fetch_assoc($check_res);
																		if($check_row['ne_flag'] == 1)
																		{
																			$ise1_marks = "N.E.";
																		}
																		elseif ($check_row['ab_flag'] == 1)
																		{
																			$ise1_marks = "AB";
																		}
																	}
																	else
																	{
																		$ise1_marks = "N.F.";
																	}
																}
															}
															else
															{
																$mark += $ise1_marks;
															}
															$ise2_marks = get_ise2_marks($stud_id,$course_id,$prev_sesnid);
															if($ise2_marks == 0)
															{
																$check_query = "SELECT * FROM `marks_others` WHERE `sesn_id` = '$prev_sesnid' AND `stud_id` = '$stud_id' AND `course_id` = '$course_id' AND `exam_type` = '2' AND `marks` = '0'";
																if($check_res = mysqli_query($dbcon,$check_query))
																{
																	if(mysqli_num_rows($check_res) == 1)
																	{
																		$check_row = mysqli_fetch_assoc($check_res);
																		if($check_row['ne_flag'] == 1)
																		{
																			$ise2_marks = "N.E.";
																		}
																		elseif ($check_row['ab_flag'] == 1)
																		{
																			$ise2_marks = "AB";
																		}
																	}
																	else
																	{
																		$ise2_marks = "N.F.";
																	}
																}
															}
															else
															{
																$mark += $ise2_marks;
															}
															$isa_marks = get_isa_marks($stud_id,$course_id,$prev_sesnid);
															if($isa_marks == 0)
															{
																$check_query = "SELECT * FROM `marks_others` WHERE `sesn_id` = '$prev_sesnid' AND `stud_id` = '$stud_id' AND `course_id` = '$course_id' AND `exam_type` = '3' AND `marks` = '0'";
																if($check_res = mysqli_query($dbcon,$check_query))
																{
																	if(mysqli_num_rows($check_res) == 1)
																	{
																		$check_row = mysqli_fetch_assoc($check_res);
																		if($check_row['ne_flag'] == 1)
																		{
																			$isa_marks = "N.E.";
																		}
																		elseif ($check_row['ab_flag'] == 1)
																		{
																			$isa_marks = "AB";
																		}
																	}
																	else
																	{
																		$isa_marks = "N.F.";
																	}
																}
															}
															else
															{
																$mark += $isa_marks;
															}

															$ese_marks = get_ese_th_marks($stud_id,$course_id,$sesn_id);
															if(copycase($sesn_id,$course_id,$stud_id,'5')))
															{
																$ese_marks = "CPS";
															}
															elseif($ese_marks == 0)
															{
																$check_query = "SELECT * FROM `marks_th_ese` WHERE`sesn_id` = '$sesn_id' AND `stud_id` = '$stud_id' AND `course_id` = '$course_id'";
																if($check_res = mysqli_query($dbcon,$check_query))
																{
																	if(mysqli_num_rows($check_res) == 1)
																	{
																		$check_row = mysqli_fetch_assoc($check_res);
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
													}

													
													//$mark = get_total_marks_obtained($stud_id,$course_id);
													if(is_numeric($ese_marks))
													{
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
														if($mark >= $pass_limit &&  $ese_marks >= $ese_max_marks/3 )
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
														if($ese_marks == "N.E.")
														{
															$grade = "Z";
														}
														elseif ($ese_marks == "AB") {
															$grade = "F";
														}
														else
															$grade = "F";
														$status = "FAIL";
													}

												}
												elseif($course_type == 2)
												{
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


													if ($regular_flag == 1) 
													{
														
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
															if(copycase($sesn_id,$course_id,$stud_id,'6')))
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
																if(copycase($sesn_id,$course_id,$stud_id,'6')))
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
															$grade = "F";
														}
														else
															$grade = "F";
														$status = "FAIL";
													}

												}
												else
												{
													return "Unknown Course type found";
												}
												if($status == "FAIL")
													$rf = 0;
												else
													$rf = 1;
												$update_sub_res = "UPDATE `exam_registration` SET `result_flag`='$rf',`grade_flag`='1',`grade`='$grade' WHERE `sesn_id` = '$sesn_id' AND `stud_id` = '$stud_id' AND `course_id` = '$course_id' AND `conform_status` = '1'";
												if($update_res = mysqli_query($dbcon,$update_sub_res))
												{

												} 
												else
												{
													return "Failed ".mysqli_error($dbcon);
												}
											}
										}
									}
									else
									{
										return  "Failed ".mysqli_error($dbcon);
									}
									/*****************************************
										GRADES UPDATED OF THIS SUBJET
									******************************************/
								
								}
							}
						}	
						else
						{
							return "Failed ".mysqli_error($dbcon);
						}
						/************************************************************************
							ALL SUBJECTS GRADES CALCULATED AND UPDATED FOR RESP. STUDENT
						*************************************************************************/

						/**********************************************************
							UPDATE THE STUDENT STATUS IN THE STUDENT TABLE 
						***********************************************************/

						/****************************************
							STUDENT DATA UPDATE
						*****************************************/

						$exam_get_query = "SELECT `sessions`.`exam_sesn` FROM `sessions` WHERE `sessions`.`sesn_id` = '$sesn_id'";
						if($exam_get_res = mysqli_query($dbcon,$exam_get_query))
						{
							if(mysqli_num_rows($exam_get_res) == 1)
							{
								$exam_data = mysqli_fetch_assoc($exam_get_res);
								$exam_session = $exam_data['exam_sesn'];
							}
							else
							{
								return "Failed  to identify the examination session";
							}
						}
						else
						{
							return "Failed to get the examination session ";
						}

						if($exam_session == 1)
						{
							//update all student data;
							$student_query = "SELECT DISTINCT `stud_id` FROM `exam_registration` WHERE `sesn_id` = '$sesn_id' AND `conform_status` = '1'";
							if($student_sel_res = mysqli_query($dbcon,$student_query))
							{
								if(mysqli_num_rows($student_sel_res) > 0)
								{
									while($student_record = mysqli_fetch_assoc($student_sel_res))
									{
										$stud_id = $student_record['stud_id'];
										$status_update_query = "UPDATE `student` SET `current_semester`=`current_semester` + 1 WHERE `id` = '$stud_id'";
										if($status_update_res = mysqli_query($dbcon,$status_update_query))
										{

										} 
										else
										{
											return "Failed to update student status ...";
										}
										
									}
								}
								else
								{
									return "No students found";
								}
							}
							else
							{
								return "Failed to update the student status.. ".mysqli_error($dbcon);
							}

						}
						elseif($exam_session == 2)
						{
								//do nothing 
						}
						elseif($exam_session == 3)
						{
							//update the students status based on the complete performance;

							//get the previous sesn_id
							$prev_sesn_query = "SELECT  p.sesn_id FROM sessions as c, sessions as p WHERE c.academic_yr = p.academic_yr AND c.sesn_id = '$sesn_id' AND c.exam_sesn = '3' AND p.exam_sesn = '2';";
							if($pvg_res = mysqli_query($dbcon,$prev_sesn_query))
							{
								if(mysqli_num_rows($pvg_res) == 1)
								{
									$result_set = mysqli_fetch_assoc($pvg_res);
									$summer_sesnid = $result_set['sesn_id'];
								}
								else
								{
									return "Invalid sesn id";
								}
							}
							else
							{
								return "Failed to get the session identifier..";
							}

							$student_query = "SELECT DISTINCT `stud_id` FROM `exam_registration` WHERE (`sesn_id` = '$sesn_id' OR `sesn_id` = '$summer_sesnid') AND `conform_status` = '1'";
							if($student_sel_res = mysqli_query($dbcon,$student_query))
							{
								if(mysqli_num_rows($student_sel_res) > 0)
								{
									while($student_record = mysqli_fetch_assoc($student_sel_res))
									{
										$stud_id = $student_record['stud_id'];
										//get the list of subject in which the student is fail and the respective semester of the sbject 
										$sub_assoc_array = array();
										$sem_sub_query = "SELECT `exam_registration`.`sesn_id`,`course_assign`.`sem`, `exam_registration`.`course_id` FROM `exam_registration`,`course_assign`,`student`,`sessions` WHERE `exam_registration`.`stud_id` = '400' AND `exam_registration`.`conform_status` = '1' AND `exam_registration`.`result_flag` = '0' AND `exam_registration`.`regular_flag` = '1' AND `exam_registration`.`sesn_id` = `sessions`.`sesn_id` AND `course_assign`.`ac_yr` = `sessions`.`academic_yr` AND `course_assign`.`sub_id` = `exam_registration`.`course_id` AND `course_assign`.`branch` = `student`.`department` AND `student`.`id` = `exam_registration`.`stud_id` ORDER BY `exam_registration`.`sesn_id` ASC;"; 
										if($sem_res = mysqli_query($dbcon,$sem_sub_query))
										{
											if(mysqli_num_rows($sem_res) > 0)
											{
												$sub_assoc_array = array();
												while($sub_row = mysqli_fetch_assoc($sem_res))
												{
													$course_id = $sub_row['course_id'];
													$sem = $sub_row['sem'];
													$sub_assoc_array[$course_id] = $sem;
												}
											}
											else
											{
												$status_update_query = "UPDATE `student` SET `current_semester`=`current_semester` + 1 WHERE `id` = '$stud_id'";
												if($status_update_res = mysqli_query($dbcon,$status_update_query))
												{
													continue;
												} 
												else
												{
													return "Failed to update student status ...";
												}
											}
										}
										/**** GET THE CURRENT SEM OF STUDENT ****/
										$csem_get_query = "SELECT `current_semester` FROM `student` WHERE `id` = '$stud_id' "; 
										if($csem_res = mysqli_query($dbcon,$csem_get_query))
										{
											if(mysqli_num_rows($csem_res) == 1)
											{
												$csem_row = mysqli_fetch_assoc($csem_res);
												$current_semester = $csem_row['current_semester'];

											}
											else
												return "Failed to get the semester of student";
										}
										else
											return "Failed to get the semester of student";

										/*Checking for subject of previous years*/
										$flag = 0;
										foreach ($sub_assoc_array as $course => $s) 
										{
											if( abs($current_semester - $s) >= 2 )
											{
												$flag = 1;
												break;
											}		
										}
										if($flag == 1)
										{
											//set this student status to Y.D.;
										}
										else
										{
											$rem_credit = 0;
											foreach ($sub_assoc_array as $course => $s)
											{
												$rem_credit += get_course_credit($course);
											}
										}
										/*
										Get the sum of the total crditsof all the subjects o this year
										*/
										if($rem_credit == 0)
										{
											$status_update_query = "UPDATE `student` SET `current_semester`=`current_semester` + 1 WHERE `id` = '$stud_id'";
											if($status_update_res = mysqli_query($dbcon,$status_update_query))
											{

											} 
											else
											{
												return "Failed to update student status ...";
											}
										}
										else
										{
											/*get the total credits alloted to this ac year cources*/
											foreach ($sub_assoc_array as $course => $s) {
												$any_course = $course;
												break;
											}
											$total_credit_query  = "SELECT SUM(`course`.`credits`) as total_credits FROM `course`,`course_assign`,`student` WHERE `course_assign`.`ac_yr` = (SELECT `sessions`.`academic_yr` FROM `sessions` WHERE `sessions`.`sesn_id` = (SELECT `exam_registration`.`sesn_id` FROM `exam_registration` WHERE `exam_registration`.`stud_id` = '$stud_id' AND `exam_registration`.`course_id`= '$any_course' AND `exam_registration`.`regular_flag` = '1' AND `exam_registration`.`conform_status` = '1' ORDER BY `exam_registration`.`sesn_id` DESC LIMIT 1 )) AND (`course_assign`.`sem`= '$current_semester' OR `course_assign`.`sem` = '$current_semester - 1' ) AND `course_assign`.`branch` = `student`.`department` AND `student`.`id` = '$stud_id' AND `course_assign`.`sub_id` = `course`.`id` ";
											if($tc_res = mysqli_query($dbcon,$total_credit_query))
											{
												$tc_row = mysqli_fetch_assoc($tc_res);
												$total_credits = $tc_row['total_credits'];
											}
											else
											{
												return "Failed to get the credit information";
											}
											$secured_credits = $total_credits - $rem_credit;
											$required_credits = floor($total_credits * 0.75);
											if($secured_credits >= $required_credits)
											{
												$status_update_query = "UPDATE `student` SET `current_semester`=`current_semester` + 1 WHERE `id` = '$stud_id'";
												if($status_update_res = mysqli_query($dbcon,$status_update_query))
												{

												} 
												else
												{
													return "Failed to update student status ...";
												}
											}
											else
											{
												//student is Y.D.
											}
										}
									
									}
								}
								else
								{
									return "No students found";
								}
							}
							else
							{
								return "Failed to update the student status.. ".mysqli_error($dbcon);
							}
						}
						else
						{
							return "Invalid examination session";
						}


						/****************************************
							STUDENT DATA UPDATE
						*****************************************/

						/**********************************************************
							STUDENT STATUS UPDATED IN THE STUDENT TABLE 
						***********************************************************/

						/***************************************
							END THE CURRENT SESN
						*****************************************/
						$sesn_end_query = "UPDATE `sessions` SET `end_flag` = '1' WHERE `sesn_id` = '$sesn_id'";
						if($sesn_end_res = mysqli_query($dbcon,$sesn_end_query))
						{
							return "success";
						}
						else
						{
							return "Failed to update the session";
						}
						/************************************
							SESSION ENDED
						************************************/
					}
					else
					{
						return "Invalid Security Code..!!";
					}

				} 
				else 
				{
					return "Failed: ".mysqli_error($dbcon);
				}
			}
		}
		else 
		{
			return "Failed: ".mysqli_error($dbcon);
		}
	}
?>