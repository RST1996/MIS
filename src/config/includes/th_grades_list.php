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
										<th>ISE 1</th>
										<th>ISE 2</th>
										<th>ISA</th>
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
										<th>ISE 1</th>
										<th>ISE 2</th>
										<th>ISA</th>
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
					$sesn_id = get_sesn_id();
					$regular_flag = $row['regular_flag'];
					$mark = 0;

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


						if(copycase($sesn_id,$course_id,$stud_id,'5'))
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
						//echo "<br/>".$regular_flag." irrejsvd<br/>";
						if(is_internal_cancel($sesn_id,$stud_id,$course_id))
						{
							$ese_marks = get_ese_th_marks($stud_id,$course_id,$sesn_id);
							$ise1_marks = $ise2_marks = $isa_marks = "N.A.";
							$mark = round($ese_marks*($max_marks/$ese_max_marks));
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
										$ise2_marks = "N.F";
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
							if(copycase($sesn_id,$course_id,$stud_id,'5'))
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
										<td><?php echo $ise1_marks; ?></td>
										<td><?php echo $ise2_marks; ?></td>
										<td><?php echo $isa_marks; ?></td>
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