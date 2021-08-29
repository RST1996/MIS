
    <!-- JQuery DataTable Css -->
<link href="../plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">
	
<link href="../plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

    <section class="content">
        <div class="container-fluid">
            
            
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                View Staff
                            </h2>
                           
                        </div>
                        <div class="body" id="staff_container">
                            <table class="table table-bordered table-striped " id="staff_table">
                                <thead>
                                    <tr>
										<th>Name</th>
										<th>Designation</th>
										<th>Department</th>
										<th >Action-Edit</th>
										<th>Action-delete</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
										<th>Name</th>
										<th>Designation</th>
										<th>Department</th>
										<th >Action-Edit</th>
										<th>Action-delete</th>
                                    </tr>
                                </tfoot>
                                <tbody>
  <?php
	$sel_query = "SELECT `staff`.`id`, `staff`.`name`,`staff`.`designation`,`staff`.`department`,`department`.`department_name` FROM `staff` LEFT JOIN`department` ON `staff`.`department` = `department`.`id`";
	if ($res = mysqli_query($dbcon,$sel_query)) {
		if (mysqli_num_rows($res) > 0) {
			
			while ($row = mysqli_fetch_assoc($res)) {
				$id = $row['id'];
				$name = $row['name'];
				$designation = $row['designation'];
				$department = $row['department_name'];
				$department_id = $row['department'];
?>
				<tr>
					<td><input type="text" id="name<?php echo $id; ?>"  name = "name<?php echo $id; ?>" value="<?php echo $name ?>" required disabled  /></td>
					<td><input type="text" id="designation<?php echo $id; ?>"  name = "designation<?php echo $id; ?>" value="<?php echo $designation ?>" required disabled /></td>
					<td>
						<select id="department<?php echo $id; ?>"  name = "department<?php echo $id; ?>" required disabled >

						<?php
							$dep_sel_query = "SELECT `id`, `department_name` FROM `department`";
							if ($res1 = mysqli_query($dbcon,$dep_sel_query)) {
								if (mysqli_num_rows($res) > 0) {
									while ($row1 = mysqli_fetch_assoc($res1)) {
						?>
						<option value="<?php echo $row1['id']; ?>" <?php if($department_id == $row1['id']){echo "selected"; }?> ><?php echo $row1['department_name'];  ?></option>
						<?php				
									}
								}
							}

						?>
						</select>
					</td>
					<td id="cell<?php echo $id; ?>"><button class="btn btn-primary waves-effect" onclick='make_editable("name<?php echo $id; ?>","designation<?php echo $id; ?>","department<?php echo $id; ?>","cell<?php echo $id; ?>","<?php echo $id; ?>")' class="btn btn-default">EDIT</button></td>
					<td><button class="btn bg-red waves-effect"onclick="delete_staff(<?php echo $id; ?>)" class="btn btn-danger">Delete</button></td>
				</tr>
<?php
			}
		} else {
			echo "No Staff has been Added yet!";
		}
		
	} else {
		echo "Something went wrong!";
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
    	$('#staff_table').DataTable({
    		
    	});
	} );
</script>
<script type="text/javascript">
	function make_editable($name,$designation,$department,$cell,$id)
	{
		$( "#"+$name ).prop( "disabled", false );
		$( "#"+$designation ).prop( "disabled", false );
		$( "#"+$department ).prop( "disabled", false );
		$str = "<button onclick=\"save_changes('"+$name+"','"+$designation+"','"+$department+"','"+$id+"')\" class=\"btn btn-primary\"> SAVE </button>";
		document.getElementById($cell).innerHTML = $str;
	}
</script>
<script type="text/javascript">
	function delete_staff($uid)
	{
		var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        	if (this.readyState == 4 && this.status == 200) {
        		document.getElementById('staff_container').innerHTML = this.responseText; 
        	}
        };
        xhttp.open("POST", "../config/ajax/delete_staff.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("del_id="+$uid);
	}
</script>
<script type="text/javascript">
	function save_changes(name,designation,department,id)
	{
		var name_val = document.getElementById(name).value;
		var designation_val = document.getElementById(designation).value;
		var department_val = document.getElementById(department).value;
		
		if (name_val!="" && designation_val!="" && department_val!="") 
		{
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
	        	if (this.readyState == 4 && this.status == 200) {
	        		document.getElementById('staff_container').innerHTML = this.responseText; 
	        	}
	        };
	        xhttp.open("POST", "../config/ajax/update_staff.php", true);
	        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	        xhttp.send("up_id="+id+"&name="+name_val+"&designation="+designation_val+"&department="+department);
		}
		else
		{
			alert("Please fill all fields!!");
		} 
	}
</script>
						</div>
                    </div>
                </div>
            </div>
            
            
        </div>
    </section>
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