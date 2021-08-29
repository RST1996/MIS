<?php
	if (isset($_POST['add_course'])) {
		/*$name = clean_ip($_POST['name']);
		$designation = clean_ip($_POST['designation']);
		$department = clean_ip($_POST['department']);
		$username = clean_ip($_POST['username']);*/
		$formdata = $_POST;
		$add_course  = add_course($formdata);
		if ($add_course == "success") {
			?>
			<script type="text/javascript">
				
				swal("Good Job!", "Successfully Registered", "success")
			</script>
			<?php
			unset($_POST);
			
			header( "refresh:1; url=add_course.php" );
		}
		else
		{
?>
		<script type="text/javascript">
			swal("Failed!", "<?php echo $add_course ?>", "error")
		</script>
<?php
		}
	}
?>
<section class="content">
<div class="container-fluid">
	<div class="row clearfix"></div>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
        	<div class="header">
				<h2>Add Course</h2>
			</div>
			<div class="body">
				<form id="wizard_with_validation" action="add_course.php" method="POST">
					<h4>Subject Basic Info</h4>
					<fieldset>
							<div class="row clearfix">
										<div class="col-sm-2">
											<div class="form-group">
												<div>
													<label for="course_code">Course Code :</label> 
												</div>
											</div>
										</div>
										<div class="col-sm-3">
											<div class="form-group">
												<div class="form-line">
														<input type="text" id="course_code" class="form-control" name="course_code" value="<?php if(isset($course_code)){echo $course_code;} ?>" required/>
												</div>
											</div>
										</div>
										
						</div>
						<div class="row clearfix">
										<div class="col-sm-2">
											<div class="form-group">
												<div>
													<label for="name">Course Name :</label> 
												</div>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<div class="form-line">
													<input type="text" id="name" name="name"class="form-control"  value="<?php if(isset($name)){echo $name;} ?>" required/>
												</div>
											</div>
										</div>
										
						</div>
						<div class="row clearfix">
										<div class="col-sm-2">
											<div class="form-group">
												<div>
													<label for="credits">Credits :</label> 
												</div>
											</div>
										</div>
										<div class="col-sm-3">
											<div class="form-group">
												<div class="form-line">
														<input type="number" id="credits" class="form-control" name="credits" required/>
												</div>
											</div>
										</div>
										
						</div>
						<div class="row clearfix">
										<div class="col-sm-2">
											<div class="form-group">
												<div>
													<label for="course_type">Course Type : </label> 
												</div>
											</div>
										</div>
										<div class="col-sm-4">
											<div class="form-group">
												<div class="form-line">
														<select id="course_type" class="form-control show-tick" name="course_type" onchange="showform()" required>
															<option value="">---SELECT COURSE TYPE---</option>
															<?php
																$dep_sel_query = "SELECT `id`, `name` FROM `course_type`";
																if ($res = mysqli_query($dbcon,$dep_sel_query)) {
																	if (mysqli_num_rows($res) > 0) {
																		while ($row = mysqli_fetch_assoc($res)) {
															?>
															<option value="<?php echo $row['id']; ?>"><?php echo $row['name'];  ?></option>
															<?php				
																		}
																	}
																}			
															?>
														</select>
												</div>
											</div>
										</div>
										
						</div>
						
					<fieldset>
					<div id="mks_form"></div>
				</form>
			</div>
		</div>
	</div>
</div>
</section>
<script type="text/javascript">
	function showform()
	{
		var ctype = document.getElementById('course_type').value;
		var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        	if (this.readyState == 4 && this.status == 200) {
        		document.getElementById('mks_form').innerHTML = this.responseText; 
        	}
        };
        xhttp.open("POST", "../config/ajax/add_course.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("ctype="+ctype);

	}
</script>