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