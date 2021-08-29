<?php
	if(isset($_POST['lock_marks']))
	{
		$sesn_id = get_sesn_id();
		$course_id = $_POST['course'];
		$exam_type = $_POST['exam_id'];
		$dept = $_POST['department'];
		
		
		$s = lock_pc_reval_marks($($sesn_id,$course_id,$dept,$exam_type);
		if($s)
		{
?>
	<script type="text/javascript">
		swal("Good Job", "Locked Successfully","success");
		
	</script>
<?php
			header( "refresh:1; url=challenge_marks_entry.php" );
		}
	}
    if(isset($_POST['marks_list']))
    {
        $exam_id = $_POST['exam_id'];
        $dept = $_POST['department'];
        $course_id = $_POST['course'];
        $stud_list = $_POST['stud_ids'];
        $marks_list = $_POST['marks'];
        $result = challenge_marks_entry($stud_list,$course_id,$marks_list);
        if($result == "success")
        {
            echo "Recoed Successfully Updated!!";
            unset($_POST);
?>  
        <script type="text/javascript">
            swal("Great!","Reval marks entered successfully!! ","success");
        </script>
<?php
            //header();
        }
        else
        {
?>  
        <script type="text/javascript">
            swal("Opps!","Failed to enter marks   :( ","error");
        </script>
<?php        }
    }
?>
<section class="content">
    <div class="container-fluid">
	   <div class="row clearfix">	
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
						Photocopy Challenge Marks Entry
						</h2>                            
                    </div>
                    <div class="body">
						<form method = "POST" action = "challenge_marks_entry.php">
                            <fieldset>
<?php
    //var_dump($activity);
    if (sizeof($activity) > 1)
    {
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
                                        <select id="exam_id" name="exam_id" onchange="show_dept()" required>
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
                                <div id="dept_from_container"></div>
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
                                    <div class="col-sm-2">
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
                                
<?php
        include "../config/includes/show_dept.inc.php";
?>
                                
<?php
    }
?>
                                <div id="course_form_container"></div>
                                <div id="stud_form_container"></div>
                           	</fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
	function show_dept()
	{
		$.blockUI({ message: '<img src="../assets/images/loader.gif" /> &nbsp;&nbsp;&nbsp; Just a moment...' });
		var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        	if (this.readyState == 4 && this.status == 200) {
        		document.getElementById('dept_from_container').innerHTML = this.responseText; 
        		$.unblockUI();
        		$('select').selectpicker(); 
        	}
        };
        xhttp.open("POST", "../config/includes/show_dept.inc.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send();
	}
</script>
<!--script type="text/javascript">
	/*function show_sem()
	{
		$.blockUI({ message: '<img src="../assets/images/loader.gif" /> &nbsp;&nbsp;&nbsp; Just a moment...' });
		var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        	if (this.readyState == 4 && this.status == 200) {
        		document.getElementById('sem_form_container').innerHTML = this.responseText;
        		$('select').selectpicker(); 
        		$.unblockUI();
        	}
        };
        xhttp.open("POST", "../config/ajax/show_sem.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send();
	}*/
</script-->
<script type="text/javascript">
	function show_course()
	{
		var dept = document.getElementById('department').value;
		if(dept != null)
		{
			$.blockUI({ message: '<img src="../assets/images/loader.gif" /> &nbsp;&nbsp;&nbsp; Just a moment...' });
			var xhttp = new XMLHttpRequest();
		    xhttp.onreadystatechange = function() {
		    	if (this.readyState == 4 && this.status == 200) {
		    		document.getElementById('course_form_container').innerHTML = this.responseText;
		    		$('select').selectpicker(); 
		    		$.unblockUI();
		    	}
		    };
		    xhttp.open("POST", "../config/ajax/show_reval_course.php", true);
		    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		    xhttp.send("dept="+dept);
		}
	}
</script>
<script type="text/javascript">
    function show_stud_list()
    {
        var exam_id = document.getElementById('exam_id').value;
        var course = document.getElementById('course').value;
        var dept = document.getElementById('department').value;
        if (exam_id != null && course != null && dept != null) 
        {
            $.blockUI({ message: '<img src="../assets/images/loader.gif" /> &nbsp;&nbsp;&nbsp; Just a moment...' });
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById('stud_form_container').innerHTML = this.responseText;
                    $('select').selectpicker(); 
                    $.unblockUI();
                }
            };
            xhttp.open("POST", "../config/ajax/challenge_marks_entry.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("dept="+dept+"&course="+course+"&exam_id="+exam_id);
        }
    }
</script>
<script type="text/javascript">
    function edit_marks(mark_id,act_id,id)
    {
        var max_marks = document.getElementById('max_marks').value;
        
        var mark_string = "<input id=\"mark"+id+"\" type=\"number\" min=\"0\" max=\"" + max_marks + "\" id=\"cid"+id+"\" />";
        //var mark_string = "<input type=\"number\" min=\"0\" max=\"" + max_marks + "\" id=\"cid"+id+"\" /> &nbsp;&nbsp; <input type=\"checkbox\" name=\"absent\" value=\""+id+"\" id=\"status"+id+"\" class=\"chk-col-teal\" onchange=\"change(this.id,'cid"+id+"')\" /><label for=\"status"+id+"\"> Absent</label>";
        var act_string = "<input type=\"button\" class=\"btn bg-teal waves-effect\" value=\"UPDATE\" onclick=\"update_marks('mark"+id+"','"+id+"')\" /> &nbsp;&nbsp; <input class=\"btn bg-teal waves-effect\" type=\"button\" value=\"CANCEL\" onclick=\"show_list()\" />";
        
        document.getElementById(mark_id).innerHTML = mark_string;
        document.getElementById(act_id).innerHTML = act_string; 
    }
</script>
<script type="text/javascript">
    function update_marks(input_id,id)
    {
        var max_marks = document.getElementById('max_marks').value;
        var mark = parseInt(document.getElementById(input_id).value);
        var course = document.getElementById('course').value;
        if(mark <= max_marks && mark >= 0)
        {
            $.blockUI({ message: '<img src="../assets/images/loader.gif" /> &nbsp;&nbsp;&nbsp; Just a moment...' });
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var op_string = this.responseText;
                    alert(op_string);
                    if(op_string == "success")
                    {
                        swal("Great","Successfully Updated","success");
                    } 
                    else
                    {
                        swal("Opps!","Failed to update... :(","error")
                    }
                    $.unblockUI();
                    show_stud_list();
                }
            };
            xhttp.open("POST", "../config/ajax/update_challenge_marks.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("course="+course+"&stud="+id+"&mark="+mark);
        }
        else
        {
            alert("Enter marks in range[0-"+max_marks+"]");
        }
    }
</script>
<script type="text/javascript">
    $('form').on('focus', 'input[type=number]', function (e) {
      $(this).on('mousewheel.disableScroll', function (e) {
        e.preventDefault()
      })
    })
    $('form').on('blur', 'input[type=number]', function (e) {
      $(this).off('mousewheel.disableScroll')
    })
</script>
<script type="text/javascript">
	function finalize()
	{
		$.blockUI({ message: '<img src="../assets/images/loader.gif" /> &nbsp;&nbsp;&nbsp; Just a moment...' });
		var course_id =  document.getElementById('course').value;
		var exam_id = document.getElementById('exam_id').value;
		
		var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        	if (this.readyState == 4 && this.status == 200) {
        		document.getElementById('students_from_container').innerHTML = this.responseText; 
        		
        		$.unblockUI();
        	}
        };
        xhttp.open("POST", "../config/ajax/finalize_challenge_marks.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("exam="+exam_id+"&course="+course_id);
	}
</script>