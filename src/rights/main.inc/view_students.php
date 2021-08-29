
    <!-- JQuery DataTable Css -->
    <link href="../plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

    <section class="content">
        <div class="container-fluid">
            
            
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                               View Student
                            </h2>
                           
                        </div>
                        <div class="body" id="student_container">
                            <table id="student_table" class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
										<th>PRN</th>
										<th>Name</th>
										<th>Department</th>
										<th>Action</th>

                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
										<th>PRN</th>
										<th>Name</th>
										<th>Department</th>
										<th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
  <?php 
	$view_query = "SELECT `student`.`id`,`student`.`prn`,`student`.`name`,`department`.`department_name` FROM `student` LEFT JOIN `department` ON `department`.`id` = `student`.`department`";
	if ($res = mysqli_query($dbcon,$view_query)) {
		if (mysqli_num_rows($res) > 0)
		{
			while ($row = mysqli_fetch_assoc($res)) {
				$id = $row['id'];
				$prn = $row['prn'];
				$name = $row['name'];
				$department = $row['department_name'];
?>
			<tr>
				<td><?php echo $prn; ?></td>
				<td><?php echo $name; ?></td>
				<td><?php echo $department; ?></td>
				<td><button onclick="delete_student(<?php echo $id; ?>)" class="btn btn-danger">DELETE</button></td>
			</tr>
<?php
			}
		}
		else
		{
?>
			<tr>
				<td colspan="4"> No student entry found!!</td>
			</tr>
<?php
		}
	}
	else
	{
?>
			<tr>
				<td colspan="4"> Something Went Wrong!!!</td>
			</tr>
<?php
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
<<script type="text/javascript">
    $(document).ready(function() {
    	$('#student_table').DataTable({
    		responsive: true
    	});
	} );
</script>
<script type="text/javascript">
	function delete_student(id)
	{
		var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        	if (this.readyState == 4 && this.status == 200) {
        		document.getElementById('student_container').innerHTML = this.responseText; 
        	}
        };
        xhttp.open("POST", "../config/ajax/delete_student.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("del_id="+id);
	}
</script>
    <!-- Waves Effect Plugin Js -->
    <script src="../plugins/node-waves/waves.js"></script>

    <script src="../plugins/jquery-datatable/jquery.dataTables.js"></script>
    <script src="../plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js"></script>
    <script src="../plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js"></script>
    <script src="../plugins/jquery-datatable/extensions/export/buttons.flash.min.js"></script>
    <script src="../plugins/jquery-datatable/extensions/export/jszip.min.js"></script>
    <script src="../plugins/jquery-datatable/extensions/export/pdfmake.min.js"></script>
    <script src="../plugins/jquery-datatable/extensions/export/vfs_fonts.js"></script>
    <script src="../plugins/jquery-datatable/extensions/export/buttons.html5.min.js"></script>
    <script src="../plugins/jquery-datatable/extensions/export/buttons.print.min.js"></script>

    <!-- Custom Js -->
    <script src="../js/pages/tables/jquery-datatable.js"></script>