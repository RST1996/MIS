<link href="../plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

<?php
	
?>
<section class="content">
    <div class="container-fluid">
        
        
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            All assigned Course Coordinator 
                        </h2>
                       
                    </div>
                    <div class="body" >
                        <table id="course_table" class="table table-bordered table-striped table-hover js-basic-example dataTable">
						<thead>
                                <tr>
									<th>Course Code</th>
									<th>Course Name</th>
									<th>Course Teacher</th>
									<th>Branch</th>
									<th>Semester</th>
									<th>Update</th>
                                    </tr>
                            </thead>
							<tfoot>
                                    <tr>
									<th>Course Code</th>
									<th>Course Name</th>
									<th>Course Teacher</th>
									<th>Branch</th>
									<th>Semester</th>
									<th>Update</th>
                                    </tr>
                                </tfoot>
                            <tbody>
<?php
	$query = "SELECT `staff`.`name`, `course_coordinator`.`course_id`,`course_coordinator`.`course_coord_id`,`course_assign`.`sub_id`,`course_assign`.`sem`,`course_assign`.`branch`,`course`.`course_code`,`course`.`course_name` FROM `course_assign`,`course`,`course_coordinator`,`staff` WHERE `course_coordinator`.`course_coord_id` =`staff`.`id` AND `course_coordinator`.`course_id` = `course_assign`.`sub_id` AND `course_coordinator`.`course_id` = `course`.`id`";
	if ($res = mysqli_query($dbcon,$query)) {
	
		while ($row = mysqli_fetch_assoc($res)) {
			$branch = $row['branch'];
			$department = get_department_name($branch);
			$sem = $row['sem'];
			$ip_id = "ip".$branch."and".$sem;
			$btn_id = "btn".$branch."and".$sem;
			
?>
								<tr>
									
									<td><?php echo $row['course_code']; ?></td>
									<td><?php echo $row['course_name']; ?></td>
									<td id="<?php echo $ip_id; ?>"><?php echo $row['name']; ?></td>
									<td><?php echo $department; ?></td>
									<td><?php echo $sem; ?></td>
									<td id="<?php echo $btn_id; ?>"><input type="button" class="btn btn-primary waves-effect" onclick="enable_edit('<?php echo $branch; ?>','<?php echo $course_id; ?>','<?php echo $ip_id ?>','<?php echo $btn_id ?>')" class="btn btn-danger" value="Update" /></td>
								</tr>
<?php
		}
	}
?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>        
    </div>
</section>
<script type="text/javascript">
    $(document).ready(function() {
    	$('#course_table').DataTable({
    		responsive: true
    	});
	} );
</script>
<script type="text/javascript">
	function enable_edit(branch, course, ip_id, btn_id )
	{
		var xhttp = new XMLHttpRequest();
		var upd_btn =  "<input type=\"button\" class=\"btn btn-primary waves-effect\" onclick=\"save("+branch+","+course+",'"+ip_id+"select'"+")\"  value=\"Save\" />";
        xhttp.onreadystatechange = function() {
        	if (this.readyState == 4 && this.status == 200) {
        		document.getElementById(ip_id).innerHTML = this.responseText; 
        		document.getElementById(btn_id).innerHTML = upd_btn;
        	}
        };
        xhttp.open("POST", "../config/ajax/manage_course_coordinator.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("department="+branch+"&course="+course+"&set_id="+ip_id+"select");
	}
</script>
<script type="text/javascript">
	function save(branch,course,source_id)
	{
		var teacher = document.getElementById(source_id).value;
		if (teacher) {
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
	        	if (this.readyState == 4 && this.status == 200) {
	        		document.getElementById('content_box').innerHTML = this.responseText; 
	        		
	        	}
	        };
			
	        xhttp.open("POST", "../config/ajax/manage_course_coordinator2.php", true);
	        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	        xhttp.send("department="+branch+"&course="+course+"&teacher="+teacher);
		} else
		{
			alert("Plz select a staff !!");
		}
	}
</script>