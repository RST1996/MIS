<?php
	$user_ref_id = $_SESSION['user_ref_id'];
	if (isset($_POST['lock_ne'])) {
		$course = $_POST['course'];
		$exam_id = $_POST['exam_id'];
		$sesn_id = get_sesn_id();
		//$lock = lock($exam_id,$course);
		$lock = lock_ne_list($sesn_id,$course,$exam_id);
		if ($lock == "success") {
?>
	<script type="text/javascript">
		swal("Good Job", "Locked Successfully","success");
		
	</script>
<?php
			header( "refresh:1; url=not_eligible.php" );
		}
	}
	if (isset($_POST['not_eligible'])) {		
				if(empty($_POST['student_list'])) 
					{
						
						?>
						<script type="text/javascript">
								
								swal("Good Job!", "No Not Elligible Student", "success")
						</script>
						<?php
					} 
					else 
					{
						//print_r($_POST);
						$reason_list = $_POST['reason'];
						$test= $_POST['student_list'];
						$course = $_POST['course'];
						$exam_id = $_POST['exam_id'];
						$N = count($test);
						$assign = "";
						for($i=0; $i < $N; $i++)
						{
							$id=$test[$i];
							$reason = $reason_list[$i];

							if(check($id,$course,$exam_id))
							{
								$assign = "success";
								continue;
							}
							$assign = "success";
							$assign = not_eligible($id,$course,$user,$exam_id,$reason);
							
						}
						
						if ($assign == "success") {
			
							?>
							<script type="text/javascript">
								
								swal("Good Job!", "Successfully Updated", "success")
							</script>
							<?php
							unset($_POST);
							header( "refresh:1; url=not_eligible.php" );
						}
						else 
						{
				?>
						<script type="text/javascript">
							swal("Failed!", "<?php echo $assign ?>", "error")
						</script>
				<?php
						}
						
					}
		}
		
?>
<section class="content">
	<div class="container-fluid">
		<div class="row clearfix">	
	        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	            <div class="card">
	                <div class="header">
	                    <h2>
						Not Elligible Students list
						</h2>
	                </div>
	                <div class="body">
	                	<form method = "POST" action = "not_eligible.php">
	                		<fieldset>
<?php
	//var_dump($activity);
	if (sizeof($activity) > 1) {
?>
	<div class="row clearfix">
		<div class="col-sm-3">
			<div class="form-group">
				<div>
					<label>Activity : </label> 
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<select id="exam_id" name="exam_id" onchange="show_course()" required>
					<option> -- SELECT ACTIVITY -- </option>
			<?php
				for ($i=0; $i < sizeof($activity) ; $i++) { 
					$query = "SELECT `name`, `exam_id` FROM `activities` WHERE `id`='$activity[$i]'";
					if ($res = mysqli_query($dbcon,$query)) {
						while ($row = mysqli_fetch_assoc($res)) {
				?>
						<option value="<?php echo $row['exam_id']; ?>"><?php echo $row['name']; ?></option>
				<?php
						}
					}
				}
			?>
			</select>
			
		</div>		
	</div>
	<div id="course_from_container">
	</div>
<?php
	}
	else
	{
		$query = "SELECT `name`, `exam_id` FROM `activities` WHERE `id`='$activity[0]'";
		if ($res = mysqli_query($dbcon,$query)) {
			$row = mysqli_fetch_assoc($res);
			$exam_id = $row['exam_id'];
			$act_name = $row['name'];
		}
?>
	<div class="row clearfix">
		<div class="col-sm-3">
			<div class="form-group">
				<div>
					<label>Activity : </label> 
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<select id="exam_id" name="exam_id" required readonly>
					<option value="<?php echo $exam_id; ?>"><?php echo $act_name; ?></option>
			</select>
			<div id="course_from_container">
			</div>
		</div>		
	</div>
	<div class="row clearfix">
		<div class="col-sm-3">
			<div class="form-group">
				<div>
					<label>Course : </label> 
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<select id="course" name="course" onchange="show_list()" required>
					<option> -- SELECT COURSE -- </option>
			<?php
				switch ($exam_id) {
					case '1':
						$course_query = "SELECT DISTINCT `course`.`id`, `course`.`course_code`,`course`.`course_name` FROM `course`,`th_mks_scheme`,`course_teacher`,`exam_registration`,`ses_conf` WHERE `course_teacher`.`sub_id` = `course`.`id` AND `course_teacher`.`staff_id` = '$user_ref_id' AND `course`.`course_type_id` = '1' AND `th_mks_scheme`.`sub_id` = `course`.`id` AND `th_mks_scheme`.`ise1` > 0 AND `ses_conf`.`id` = '1' AND `ses_conf`.`current_session` = `exam_registration`.`sesn_id` AND `exam_registration`.`course_id` = `course`.`id`AND `exam_registration`.`regular_flag` = '1'";
						break;
					case '2':
						$course_query = "SELECT DISTINCT `course`.`id`, `course`.`course_code`,`course`.`course_name` FROM `course`,`th_mks_scheme`,`course_teacher`,`exam_registration`,`ses_conf` WHERE `course_teacher`.`sub_id` = `course`.`id` AND `course_teacher`.`staff_id` = '$user_ref_id' AND `course`.`course_type_id` = '1' AND `th_mks_scheme`.`sub_id` = `course`.`id` AND `th_mks_scheme`.`ise2` > 0 AND `ses_conf`.`id` = '1' AND `ses_conf`.`current_session` = `exam_registration`.`sesn_id` AND `exam_registration`.`course_id` = `course`.`id`AND `exam_registration`.`regular_flag` = '1'";
						break;
					case '3':
						$course_query = "SELECT DISTINCT `course`.`id`, `course`.`course_code`,`course`.`course_name` FROM `course`,`th_mks_scheme`,`course_teacher`,`exam_registration`,`ses_conf` WHERE `course_teacher`.`sub_id` = `course`.`id` AND `course_teacher`.`staff_id` = '$user_ref_id' AND `course`.`course_type_id` = '1' AND `th_mks_scheme`.`sub_id` = `course`.`id` AND `th_mks_scheme`.`isa` > 0 AND `ses_conf`.`id` = '1' AND `ses_conf`.`current_session` = `exam_registration`.`sesn_id` AND `exam_registration`.`course_id` = `course`.`id`AND `exam_registration`.`regular_flag` = '1'";
						break;
					case '4':
						$course_query = "SELECT DISTINCT `course`.`id`, `course`.`course_code`,`course`.`course_name` FROM `course`,`pr_mks_scheme`,`course_teacher`,`exam_registration`,`ses_conf` WHERE `course_teacher`.`sub_id` = `course`.`id` AND `course_teacher`.`staff_id` = '$user_ref_id' AND `course`.`course_type_id` = '2' AND `pr_mks_scheme`.`sub_id` = `course`.`id` AND `pr_mks_scheme`.`ica` > 0 AND `ses_conf`.`id` = '1' AND `ses_conf`.`current_session` = `exam_registration`.`sesn_id` AND `exam_registration`.`course_id` = `course`.`id`AND `exam_registration`.`regular_flag` = '1'";
						break;
					case '5':
						$course_query = "SELECT DISTINCT `course`.`id`, `course`.`course_code`,`course`.`course_name` FROM `course`,`th_mks_scheme`,`course_teacher`,`exam_registration`,`ses_conf` WHERE `course_teacher`.`sub_id` = `course`.`id` AND `course_teacher`.`staff_id` = '$user_ref_id' AND `course`.`course_type_id` = '1' AND `th_mks_scheme`.`sub_id` = `course`.`id` AND `th_mks_scheme`.`ese` > 0 AND `ses_conf`.`id` = '1' AND `ses_conf`.`current_session` = `exam_registration`.`sesn_id` AND `exam_registration`.`course_id` = `course`.`id`AND `exam_registration`.`regular_flag` = '1'";
						break;
					case '6':
						$course_query = "SELECT DISTINCT `course`.`id`, `course`.`course_code`,`course`.`course_name` FROM `course`,`pr_mks_scheme`,`course_teacher`,`exam_registration`,`ses_conf` WHERE `course_teacher`.`sub_id` = `course`.`id` AND `course_teacher`.`staff_id` = '$user_ref_id' AND `course`.`course_type_id` = '2' AND `pr_mks_scheme`.`sub_id` = `course`.`id` AND `pr_mks_scheme`.`ese` > 0 AND `ses_conf`.`id` = '1' AND `ses_conf`.`current_session` = `exam_registration`.`sesn_id` AND `exam_registration`.`course_id` = `course`.`id`AND `exam_registration`.`regular_flag` = '1'";
						break;
					default:
						//echo "Invalid Value";
						die("Invalid conditions found!! Plzz contact Admin!");
						break;
				}	
				if ($res = mysqli_query($dbcon,$course_query)) {
					while ($row = mysqli_fetch_assoc($res)) {
			?>
					<option value="<?php echo $row['id']; ?>"><?php echo $row['course_code'].": ".$row['course_name']; ?></option>
			<?php
					}
				}
			?>
			</select>

		</div>
		
	</div>
<?php
	}
?>     
								<div id="students_from_container">
								</div>               
							</fieldset>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
	
	function show_course()
	{
		$.blockUI({ message: '<img src="../assets/images/loader.gif" /> &nbsp;&nbsp;&nbsp; Just a moment...' });
		var exam_id = document.getElementById('exam_id').value;
		var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        	if (this.readyState == 4 && this.status == 200) {
        		document.getElementById('course_from_container').innerHTML = this.responseText; 
				$('select').selectpicker();
        		$.unblockUI();
        		//alert("Successfully Returned");
        	}
        };
        xhttp.open("POST", "../config/ajax/get_ne_course.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("exam_id="+exam_id);
	}
</script>
<script type="text/javascript">
	function show_list()
	{
		$.blockUI({ message: '<img src="../assets/images/loader.gif" /> &nbsp;&nbsp;&nbsp; Just a moment...' });
		var course = document.getElementById('course').value;
		var exam_id = document.getElementById('exam_id').value;
		var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        	if (this.readyState == 4 && this.status == 200) {
        		document.getElementById('students_from_container').innerHTML = this.responseText; 
        		$('.dataTable').DataTable();
        		$.unblockUI();
        	}
        };
        xhttp.open("POST", "../config/ajax/not_eligible.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("exam="+exam_id+"&course="+course);;
	}
</script>				
<script>
	function change(id,rid)
	{
		var stat =  document.getElementById(id).checked;
		
		if(stat)
		{
			$("#"+rid).prop("disabled",false);
		}
		else
		{
			var stud_id =  document.getElementById(id).value;
			var course = document.getElementById('course').value;
			var exam_id = document.getElementById('exam_id').value;
			$.blockUI({ message: '<img src="../assets/images/loader.gif" /> &nbsp;&nbsp;&nbsp; Just a moment...' });
			var xhttp = new XMLHttpRequest();
	        xhttp.onreadystatechange = function() {
	        	if (this.readyState == 4 && this.status == 200) {
	        		//document.getElementById('students_from_container').innerHTML = this.responseText; 
	        		//$.unblockUI();
	        		var ret_value = this.responseText;
	        		if(ret_value =="removed from ne list" )
	        		{
	        			swal("Done","Removed from NE LIST","success");
	        		}
	        		else if( ret_value == "not removed")
	        		{
	        			swal("Failed"," Failed to remove from NE LIST","error");
	        		}
	        		$.unblockUI()
	        	}
	        };
	        xhttp.open("POST", "../config/ajax/remove_not_eligible.php", true);
	        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	        xhttp.send("stud="+stud_id+"&exam="+exam_id+"&course="+course);

			document.getElementById(rid).value = "";
			$("#"+rid).prop("disabled",true);

		}
	}
</script>
<script type="text/javascript">
	function finalize()
	{
		$.blockUI({ message: '<img src="../assets/images/loader.gif" /> &nbsp;&nbsp;&nbsp; Just a moment...' });
		var course_id =  document.getElementById('course').value;
		var exam_id = document.getElementById('exam_id').value;
		//alert(course_id+"<-->" + exam_id);
		var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        	if (this.readyState == 4 && this.status == 200) {
        		document.getElementById('students_from_container').innerHTML = this.responseText; 
        		$('.dataTable').DataTable();
        		$.unblockUI();
        	}
        };
        xhttp.open("POST", "../config/ajax/finalize_not_eligible.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("exam="+exam_id+"&course="+course_id);
	}
</script>
<script>
	function get_print(number)
	{
		var department = document.getElementById('department').value;
		var exam_id = document.getElementById('exam_id').value;
		var course = document.getElementById('course').value;
		
		window.location.href="../formats/NE.php?id="+number+"&course="+course+"&department="+department+"&exam="+exam_id;
	}
</script>