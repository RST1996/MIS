
<section class="content">
<div class="container-fluid">
    
	
<?php
	$user_ref_id = $_SESSION['user_ref_id'];
	if(registration_stat($user_ref_id))
	{
	if(reval_registration_stat($user_ref_id) == "Not registered")
	{
		if(isset($_POST['rcourse_list']) || isset($_POST['bcourse_list']) ){
			//echo "      condition satisfied";
			
			if(isset($_POST['rcourse_list']))
			{
				$rcourse_list = $_POST['rcourse_list'];	
			}
			else
			{
				$rcourse_list = array();
			}
			//$rcourse_list = $_POST['rcourse_list'];
			if(isset($_POST['bcourse_list']))
			{
				$bcourse_list = $_POST['bcourse_list'];	
			}
			else
			{
				$bcourse_list = array();
			}
			
			
			$exam_reg = register_reeval($rcourse_list,$bcourse_list,$user_ref_id);
			if($exam_reg == "success"){
?>
	<script type="text/javascript">
		swal("Good Job!", "Successfully Registered", "success")
	</script>
<?php		
				header( "refresh:5; url=reeval_exam_reg.php" );		
			}
			else{
?>
	<script type="text/javascript">
		swal("Failed!", "<?php echo $exam_reg ?>", "error")
	</script>
<?php
			}
		}
?>
			<div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>RE-EVAL REGISTRATION</h2>
                           
                        </div>
                        <div class="body">
                            <form id="wizard_with_validation" method="POST" action="reeval_exam_reg.php" >
							<h3>WELCOME</h3>
                                <fieldset>
									 <h5>Please read carefully</h5>
									 <hr />
									
                                    <div class="row clearfix">
										<ul>
											<li>Please Read your Information Carefully</li>
										</ul>
									</div>
                                </fieldset>
<?php 
	

	if($user_type == 3)
	{
		$select_query = "SELECT `users`.`type_id` FROM `users` WHERE `id`= '$user_id' ";
		$result_select = mysqli_query($dbcon,$select_query);
		$row = mysqli_fetch_assoc($result_select);
		$user_type_id = $row['type_id'];
		$view_query = "SELECT `student`.`id`,`student`.`prn`,`student`.`name`,`student`.`current_semester`,`student`.`department`,`department`.`department_name` FROM `exam_registration`,`marks_th_ese`,`student` LEFT JOIN `department` ON `department`.`id` = `student`.`department`  WHERE `student`.`id`='$user_type_id' AND `marks_th_ese`.`stud_id` = '$user_type_id' AND `exam_registration`.`stud_id`='$user_type_id' ";
		$result_view= mysqli_query($dbcon,$view_query) or die(mysqli_error($dbcon));
		
		$row2 = mysqli_fetch_assoc($result_view);
		$student_id = $row2['id'];
		$name = $row2['name'];
		$prn = $row2['prn'];
		//$batch = $row2['admission_year'];
		$semester = $row2['current_semester'];
		$branch = $row2['department_name'];
		$department_id = $row2['department'];
		
	    
?>
                                <h3>Profile Information</h3>
                                <fieldset>
									 <h5>Check Your Information</h5>
									 <hr />
									<div class="row clearfix">
										<div class="col-sm-1">
											<div class="form-group">
												<div>
													<label>Name:</label> 
												</div>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<div class="form-line">
													<input type="text" class="form-control" name="name" value="<?php echo $name; ?>" readonly >
													
												</div>
											</div>
										</div>
										
									</div>
									<div class="row clearfix">
										<div class="col-sm-1">
											<div class="form-group">
												<div>
													<label>PRN :</label> 
												</div>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<div class="form-line">
													<input type="text" class="form-control" name="prn" value="<?php echo $prn; ?>" readonly >
													
												</div>
											</div>
										</div>
										<div class="col-sm-1">
											<div class="form-group">
												<div>
													<label>Branch</label> 
												</div>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<div class="form-line">
													<input type="text" class="form-control" name="branch" value="<?php echo $branch; ?>" readonly >
													
												</div>
											</div>
										</div>
										</div>
									<div class="row clearfix">
										<div class="col-sm-1">
											<div class="form-group">
												<div>
													<label>Semester</label> 
												</div>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<div class="form-line">
													<input type="text" class="form-control" name="semester" value="<?php echo $semester; ?>" readonly >
													
												</div>
											</div>
										</div>
										
									</div>
                                    <div class="row clearfix">
										
									</div>
                                </fieldset>
								  <h3>Courses Information</h3>
                                <fieldset>
									 <h5>Regular Courses</h5>
									 <hr />
										<table id="mainTable" class="table table-striped">
											<thead>
												<tr>
													<th>#</th>
												<!--	<th><input id="selectall" name="selectall" type="checkbox" required>
													<label for="selectall"></label></th> -->
													<th>Select</th>
													<th>Course Code</th>
													<th>Course Name</th>
													<th>Course Type</th>
													<th>Marks</th>
												
												</tr>
											</thead>
<?php
	
	$query = "SELECT
  `course`.`id`,
  `course`.`course_code`,
  `course`.`course_name`,
  `course`.`credits`,
  `course_type`.`name`,
  `marks_th_ese`.`marks`
FROM
  `marks_th_ese`,
  `student`,
  `course_assign`,
  `course`
LEFT JOIN
  `course_type` ON `course`.`course_type_id`= `course_type`.`id`
WHERE
  `course`.`id` = `course_assign`.`sub_id` AND `course_assign`.`sem` = `student`.`current_semester` AND `course_assign`.`branch` = `student`.`department` AND `student`.`id` = '$user_ref_id' AND `course_type`.`name` = 'Theory' AND `marks_th_ese`.`stud_id` = '$user_ref_id' AND `marks_th_ese`.`course_id` = `course`.`id`";
	if ($res = mysqli_query($dbcon,$query)) {
?>
											<tbody>
<?php
	$ct = 1;
	while ($row = mysqli_fetch_assoc($res)) {
?>
												<tr>
													<td><?php echo $ct++; ?></td>
													<td><input type="checkbox" id="<?php echo "c".$row['id'];?>" name="rcourse_list[]" class="chk-col-teal" value="<?php echo $row['id'];?>"  />
														<label for="<?php echo "c".$row['id'];?>"></label>
													</td>
													<td><?php echo "{$row['course_code']}";?></td>
													<td><?php echo "{$row['course_name']}";?></td>
													<td><?php echo "{$row['name']}";?></td>
													<td><?php echo "{$row['marks']}";?></td>
												</tr>
<?php
	}
?>
											</tbody>
<?php
	} else {
		echo "Failed to load resources!!.. Try again later or contact admin!! ".mysqli_error($dbcon);
	}	
?>
										</table>

									<h5>Backlog Courses</h5>
									<hr />
										<table id="mainTable" class="table table-striped">
											<thead>
												<tr>
													<th>#</th>
												<!--	<th><input id="selectall" name="selectall" type="checkbox" required>
													<label for="selectall"></label></th> -->
													<th>Select</th>
													<th>Course Code</th>
													<th>Course Name</th>
													<th>Course Type</th>
													<th>Marks</th>
												
												</tr>
											</thead>
<?php
	$sesn_id = get_sesn_id();
	$query = "SELECT 
  `exam_registration`.`course_id`,
  `course`.`course_code`,
  `course`.`course_name`,
  `course_type`.`name`,
  `course`.`credits`,
  `marks_th_ese`.`marks`
FROM
  `exam_registration`,
  `marks_th_ese`,
  `course`,
  `course_type`
WHERE
  `exam_registration`.`course_id` NOT IN(
  SELECT
    `exam_registration`.`course_id`
  FROM
    `exam_registration`
  WHERE
    `exam_registration`.`result_flag` = '1' 
     AND `exam_registration`.`stud_id` = '$user_ref_id')
      AND `exam_registration`.`stud_id` = '$user_ref_id' 
      AND `exam_registration`.`sesn_id` <> '$sesn_id' 
      AND `exam_registration`.`course_id` = `course`.`id`
      AND `course`.`course_type_id` = `course_type`.`id` 
      AND  `course_type`.`name` = 'Theory' 
      AND `marks_th_ese`.`stud_id` = '$user_ref_id' 
      AND `marks_th_ese`.`course_id` = `course`.`id`
      AND `marks_th_ese`.`sesn_id` = '$sesn_id'";
	if ($res = mysqli_query($dbcon,$query)) {
?>
											<tbody>
<?php
	$ct = 1;
	while ($row = mysqli_fetch_assoc($res)) {
?>
												<tr>
													<td><?php echo $ct++; ?></td>
													<td><input type="checkbox" id="<?php echo "c".$row['course_id'];?>" name="bcourse_list[]" class="chk-col-teal" value="<?php echo $row['course_id'];?>"  />
														<label for="<?php echo "c".$row['course_id'];?>"></label>
													</td>
													<td><?php echo "{$row['course_code']}";?></td>
													<td><?php echo "{$row['course_name']}";?></td>
													<td><?php echo "{$row['name']}";?></td>
													<td><?php echo "{$row['marks']}";?></td>
												</tr>
<?php
	}
?>
											</tbody>
<?php
	} else {
		echo "Failed to load resources!!.. Try again later or contact admin!! ".mysqli_error($dbcon);
	}	
?>
										</table>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


<?php
				
		}
	} else {
		?>
		
		<div class="row clearfix">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card">
					<div class="header">
						<h2>Registration is Successfully Completed</h2>
					</div>
					<div class="body">
						<form id="wizard_with_validation" method="POST">
						<ul>
							<!--li>ADD RULES HERE</li-->
						</ul>
							<fieldset>
								<div class="row clearfix">
								
									<div class="col-sm-offset-4 col-md-6">										
										<input type="submit" name="generate_slip" class="btn bg-teal waves-effect" value="Genarate Slip" >
									</div>
								</div>
							</fieldset>
						</form>
					</div>
				</div>	
			</div>
		</div>
<?php
	}
	}
?>

</div>
</section>