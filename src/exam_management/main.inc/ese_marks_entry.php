<?php
	if(isset($_POST['lock_marks']))
	{
		$sesn_id = get_sesn_id();
		$course_id = $_POST['course'];
		$exam_type = $_POST['exam_id'];
		$dept = $_POST['department'];
		
		$s = lock_ese_marks($sesn_id,$course_id,$dept,$exam_type);
		if($s)
		{
?>
	<script type="text/javascript">
		swal("Good Job", "Locked Successfully","success");
		
	</script>
<?php
			header( "refresh:1; url=ese_marks_entry.php" );
		}
	}
	if (isset($_POST['marks_list'])) {
		$exam_id = $_POST['exam_id'];
		
		$course_id = $_POST['course'];
		$student_list = $_POST['stud_ids'];
		if(isset($_POST['marks']))
		{
			$marks_list = $_POST['marks'];
		}
		else
		{
			$marks_list = array();
		}

		if(isset($_POST['ne_stud']))
		{
			$ne_stud_list = $_POST['ne_stud'];
		}
		else
		{
			$ne_stud_list = array();
		}

		if(isset($_POST['absent']))
		{
			$absent_stud_list = $_POST['absent'];
		}
		else
		{
			$absent_stud_list = array();
		}
		if($exam_id == 5)
			$marks_entry = ese_th_marks_entry($exam_id,$course_id,$student_list,$marks_list,$ne_stud_list,$absent_stud_list);
		else if($exam_id == 6)
			$marks_entry = ese_pr_marks_entry($exam_id,$course_id,$student_list,$marks_list,$ne_stud_list,$absent_stud_list);
		if($marks_entry == "success")
		{
?>
	<script type="text/javascript">
		swal("Good Job!","Success","success");
	</script>
<?php
			header( "refresh:1; url=ese_marks_entry.php" );
		}
		else
		{
?>
	<script type="text/javascript">
		swal("Failed!","Unable to save....","error");
	</script>
<?php
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
							ESE Marks Entry
							</h2>                            
                        </div>
                        <div class="body">
							<form method = "POST" action = "ese_marks_entry.php">
                                <fieldset>

<?php
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
			<select id="exam_id" name="exam_id" onchange="show_department()" required>
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
	<div id="department_from_container">
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
			
		</div>		
	</div>
	<div class="row clearfix">
		<div class="col-sm-3">
			<div class="form-group">
				<div>
					<label>Department : </label> 
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<select id="department" name="department" data-live-search="true" onchange="show_course()" required>
					<option value="">---SELECT DEPARTMENT---</option>
					<?php
							$dep_sel_query = "SELECT `id`, `department_name` FROM `department`";
							if ($res = mysqli_query($dbcon,$dep_sel_query)) {
							if (mysqli_num_rows($res) > 0) {
									while ($row = mysqli_fetch_assoc($res)) {
					?>
					<option value="<?php echo $row['id']; ?>"><?php echo $row['department_name'];  ?></option>
					<?php				
									}
							}
							}				
					?>
			</select>

		</div>
	</div>
	
	
	
	
<?php
	}
?>
									<div id="course_from_container">
								
									</div>
									<div id="students_from_container">
											
									</div>
									<div id="students_back_from_container">
								
									</div>
								</fieldset>
								
							</form>
							</div>
<script type="text/javascript">
	
	function show_course()
	{
		$.blockUI({ message: '<img src="../assets/images/loader.gif" /> &nbsp;&nbsp;&nbsp; Just a moment...' });
		var exam_id = document.getElementById('exam_id').value;
		var department = document.getElementById('department').value;
		if(exam_id != null)
		{
			var xhttp = new XMLHttpRequest();
	        xhttp.onreadystatechange = function() {
	        	if (this.readyState == 4 && this.status == 200) {
	        		document.getElementById('course_from_container').innerHTML = this.responseText; 
	        		document.getElementById('students_from_container').innerHTML = "";
	        		$('select').selectpicker();
					$.unblockUI();
	        		//alert("Successfully Returned");
	        	}
	        };
	        xhttp.open("POST", "../config/ajax/get_course.php", true);
	        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	        xhttp.send("exam_id="+exam_id+"&department="+department);
		}
	}
</script>
<script type="text/javascript">
	
	function show_department()
	{
		$.blockUI({ message: '<img src="../assets/images/loader.gif" /> &nbsp;&nbsp;&nbsp; Just a moment...' });
		var exam_id = document.getElementById('exam_id').value;
		
		if(exam_id != null)
		{
			var xhttp = new XMLHttpRequest();
	        xhttp.onreadystatechange = function() {
	        	if (this.readyState == 4 && this.status == 200) {
					
	        		document.getElementById('department_from_container').innerHTML = this.responseText; 
	        		document.getElementById('course_from_container').innerHTML = ""; 
	        		document.getElementById('students_from_container').innerHTML = "";
	        		$('select').selectpicker();
	        		$.unblockUI();
	        	}
	        };
	        xhttp.open("POST", "../config/ajax/get_department.php", true);
	        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	        xhttp.send("exam_id="+exam_id);
		}
	}
</script>
<script type="text/javascript">
	function show_list()
	{
		
		$.blockUI({ message: '<img src="../assets/images/loader.gif" /> &nbsp;&nbsp;&nbsp; Just a moment...' });
		var exam_id = document.getElementById('exam_id').value;
		var course = document.getElementById('course').value;
		var department = document.getElementById('department').value;
		var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        	if (this.readyState == 4 && this.status == 200) {
        		document.getElementById('students_back_from_container').innerHTML = this.responseText; 
        		$.unblockUI();
        	}
        };
        xhttp.open("POST", "../config/ajax/ese_marks_entry.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("course="+course+"&exam="+exam_id+"&department="+department);
	}
</script>
<script type="text/javascript">
	function show_list()
	{
		
		$.blockUI({ message: '<img src="../assets/images/loader.gif" /> &nbsp;&nbsp;&nbsp; Just a moment...' });
		var exam_id = document.getElementById('exam_id').value;
		var course = document.getElementById('course').value;
		var department = document.getElementById('department').value;
		var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        	if (this.readyState == 4 && this.status == 200) {
        		document.getElementById('students_from_container').innerHTML = this.responseText; 
        		$.unblockUI();
        	}
        };
        xhttp.open("POST", "../config/ajax/ese_marks_entry.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("course="+course+"&exam="+exam_id+"&department="+department);
	}
</script>
<script>
	function change(id,rid)
	{
		var stat =  document.getElementById(id).checked;
		
		if(stat)
		{
			//$("#"+rid).prop("type","text");
			document.getElementById(rid).value = "";
			$("#"+rid).prop("placeholder","AB");
			$("#"+rid).prop("disabled",true);
			
		}
		else
		{
			document.getElementById(rid).value = "";
			//$("#"+rid).prop("type","number");
			$("#"+rid).prop("placeholder","");
			$("#"+rid).prop("disabled",false);
			
		}
	}
</script>
<script type="text/javascript">
// To disabled input spinners
jQuery(document).ready( function($) {
 
    // Disable scroll when focused on a number input.
    $('form').on('focus', 'input[type=number]', function(e) {
        $(this).on('wheel', function(e) {
            e.preventDefault();
        });
    });
 
    // Restore scroll on number inputs.
    $('form').on('blur', 'input[type=number]', function(e) {
        $(this).off('wheel');
    });
 
    // Disable up and down keys.
    $('form').on('keydown', 'input[type=number]', function(e) {
        if ( e.which == 38 || e.which == 40 )
            e.preventDefault();
    });  
      
});
</script>
<script type="text/javascript">
	function edit_marks(mark_id,act_id,id)
	{
		var max_marks = document.getElementById('max_marks').value;
		var mark_string = "<input type=\"number\" min=\"0\" max=\"" + max_marks + "\" id=\"cid"+id+"\" /> &nbsp;&nbsp; <input type=\"checkbox\" name=\"absent\" value=\""+id+"\" id=\"status"+id+"\" class=\"chk-col-teal\" onchange=\"change(this.id,'cid"+id+"')\" /><label for=\"status"+id+"\"> Absent</label>";
		var act_string = "<input type=\"button\" class=\"btn bg-teal waves-effect\" value=\"UPDATE\" onclick=\"update_marks('cid"+id+"','status"+id+"','"+id+"')\" /> &nbsp;&nbsp; <input class=\"btn bg-teal waves-effect\" type=\"button\" value=\"CANCEL\" onclick=\"show_list()\" />";
		
		document.getElementById(mark_id).innerHTML = mark_string;
		document.getElementById(act_id).innerHTML = act_string; 
	}
</script>	
<script type="text/javascript">
	function update_marks(marks,status,stud_id)
	{
		var stat =  document.getElementById(status).checked;
		if(stat)
		{
			//alert("Student is absent");
			var mark = 0;
			var ab_flag = 1;


			$.blockUI({ message: '<img src="../assets/images/loader.gif" /> &nbsp;&nbsp;&nbsp; Just a moment...' });
			var exam_id = document.getElementById('exam_id').value;
			var course = document.getElementById('course').value;
			var xhttp = new XMLHttpRequest();
	        xhttp.onreadystatechange = function() {
	        	if (this.readyState == 4 && this.status == 200) {
	        		var op_string = this.responseText;
	        		//alert(op_string);
	        		if(op_string == "success")
	        		{
	        			swal("Great","Successfully Updated","success");
	        		} 
	        		else
	        		{
	        			swal("Opps!","Failed to update... :(","error")
	        		}
	        		$.unblockUI();
	        		show_list();
	        	}
	        };
	        xhttp.open("POST", "../config/ajax/update_marks_ese.php", true);
	        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	        xhttp.send("course="+course+"&exam="+exam_id+"&stud="+stud_id+"&mark="+mark+"&ab_flag="+ab_flag);

		}
		else
		{
			var max_marks = document.getElementById('max_marks').value;
			var mark = parseInt(document.getElementById(marks).value);
			if(mark == "")
			{
				alert("plz enter a valid marks..!!");
				document.getElementById(marks).focus();
			}
			else if( mark <= max_marks)
			{
				var ab_flag = 0;
				$.blockUI({ message: '<img src="../assets/images/loader.gif" /> &nbsp;&nbsp;&nbsp; Just a moment...' });
				var exam_id = document.getElementById('exam_id').value;
				var course = document.getElementById('course').value;
				var xhttp = new XMLHttpRequest();
		        xhttp.onreadystatechange = function() {
		        	if (this.readyState == 4 && this.status == 200) {
		        		var op_string = this.responseText;
		        		//alert(op_string);
		        		if(op_string == "success")
		        		{
		        			swal("Great","Successfully Updated","success");
		        		} 
		        		else
		        		{
		        			swal("Opps!","Failed to update... :(","error")
		        		}
		        		$.unblockUI();
		        		show_list();
		        	}
		        };
		        xhttp.open("POST", "../config/ajax/update_marks_ese.php", true);
		        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		        xhttp.send("course="+course+"&exam="+exam_id+"&stud="+stud_id+"&mark="+mark+"&ab_flag="+ab_flag);
			}
			else
			{
				alert("Maximum marks limit exceeded: maximum value is "+ max_marks);
				//alert(mark);
				document.getElementById(marks).focus();
			}	
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
        		
        		$.unblockUI();
        	}
        };
        xhttp.open("POST", "../config/ajax/finalize_ese_marks.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("exam="+exam_id+"&course="+course_id);
	}
</script>
			
							</div>
					</div>
		</div>
</div>
</section>


