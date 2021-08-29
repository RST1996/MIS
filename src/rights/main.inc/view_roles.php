
    <!-- JQuery DataTable Css -->
    <link href="../plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

    <section class="content">
        <div class="container-fluid">
            
            
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                All assigned Roles
                            </h2>
                           
                        </div>
                        <div class="body" id="role_view_container">
                            <table id="role_view_table" class="table table-bordered table-striped ">
                                <thead>
                                    <tr>
                                        	<th>Role</th>
											<th>Usre Type</th>
											<th>Staff Type</th>
											<th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        	<th>Role</th>
											<th>Usre Type</th>
											<th>Staff Type</th>
											<th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
  <?php
	$query = "SELECT `role_id`, `user_type`, `staff_type` FROM `role_assign` ORDER BY `role_id` ASC";
	if ($res = mysqli_query($dbcon,$query)) {
		if (mysqli_num_rows($res) > 0) {
			while ($row = mysqli_fetch_assoc($res)) {
				$role_id = $row['role_id'];
				$user_type = $row['user_type'];

				$staff_type = $row['staff_type'];
				$role_name = get_role_name($role_id);
				$user_type_name = get_user_type_name($user_type);
				if($user_type == 2)
				{
					$staff_type_name = get_staff_type_name($staff_type);	
				}
				else
				{
					$staff_type_name = "NOT A STAFF..";
				}
				
?>
				<tr>
					<td><?php echo $role_name; ?></td>
					<td><?php echo $user_type_name; ?></td>
					<td><?php echo $staff_type_name; ?></td>
					<td><button onclick="remove_role('<?php echo $role_id; ?>','<?php echo $user_type; ?>','<?php echo $staff_type ?>')" class="btn btn-danger waves-effect" > REMOVE</button></td>
				</tr>
<?php

			}
		} else {
?>
				<tr>
					<td colspan="4">NO ROLES ASSIGNED YET..!!</td>
				</tr>
<?php			
		}
		
		
	} else {
?>
				<tr>
					<td colspan="4">UNABLE TO FETCH ROLES..!!</td>
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
<script type="text/javascript">
        $(document).ready(function() {
    		$('#role_view_table').DataTable();
		} );
    </script>
    <script type="text/javascript">
    	function remove_role(role_id,user_type,staff_type)
    	{
    		var xhttp = new XMLHttpRequest();
	        xhttp.onreadystatechange = function() {
	        	if (this.readyState == 4 && this.status == 200) {
	        		document.getElementById('role_view_container').innerHTML = this.responseText; 
	        	}
	        };
	        xhttp.open("POST", "../config/ajax/remove_role.php", true);
	        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	        xhttp.send("role_id="+role_id+"&user_type="+user_type+"&staff_type="+staff_type);
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