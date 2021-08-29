<?php

	echo "Hello im in the included page";
?>
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
						echo "regular cource";
						echo "<br/>";
						if($ica_max_marks > 0)
						{
							ehco $ica_marks = get_ica_marks($stud_id,$course_id,$sesn_id);
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
								$marks += $ica_marks;
							}
						}
						if($ese_max_marks > 0)
						{
							echo "In ese calculation";
							$ese_marks = get_ese_pr_marks($stud_id,$course_id,$sesn_id);
							if(copycase())
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
								$marks += $ese_marks;
							}
						}
						else
						{
							$ese_marks = "--";
						}
						echo "<br/>";
						echo $ese_marks;
						echo "<br/>";
					}
					else
					{
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

					if( is_numeric($ese_marks) || $ese_max_marks == 0 )
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
						if($mark >= $pass_limit &&  $ese_marks >= $ese_max_marks/3 && $ica_marks >= $ica_max_marks )
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