<link href="../plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
	
<link href="../plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
<?php
	session_start();
	require_once "../dbconnect.php";
	require_once "../funlib/login_functions.php";
	if (isset($_POST['staff']) && ( isLogin() != null)) {
		$staff = $_POST['staff'];
		$query = "SELECT `staff_role`.`staff_id`,`staff_role`.`staff_type_id`,`staff_type`.`staff_type_name` FROM `staff_role`,`staff_type` WHERE `staff_role`.`staff_id`='$staff' AND `staff_role`.`staff_type_id` = `staff_type`.`id`";
		if ($res = mysqli_query($dbcon,$query)) {
			if (mysqli_num_rows($res) > 0) {
?>
    
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
										<th>Staff Role</th>
										<th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
										<th>Staff Role</th>
										<th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
<?php
				while ($row = mysqli_fetch_assoc($res)) {
					$staff_id = $row['staff_id'];
					$staff_type_id = $row['staff_type_id'];
					$staff_type_name = $row['staff_type_name'];
?>
				<tr>
					<td><?php echo $staff_type_name; ?></td>
					<td>
						<button onclick="remove_staff_role('<?php echo $staff_id ?>','<?php echo $staff_type_id ?>')" class="btn btn-danger">REMOVE</button>
					</td>
				</tr>
<?php
				}
?>
                                </tbody>
                            </table>
                        
<?php
			} else {
				echo "No ROLES assigned to selected staff!!";
			}
			
		} else {
			echo "ERROR... ".mysqli_error($dbcon);
		}
		
	}
	
?>
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