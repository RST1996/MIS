<?php
	session_start();
	require_once "../dbconnect.php";
	require_once "../funlib/login_functions.php";
	require_once "../funlib/not_elligible_functions.php";
	
	if (isset($_POST['course']) && isset($_POST['exam']) && ( isLogin() != null)) {
		$course = $_POST['course'];
		$exam = $_POST['exam'];

		$query = "SELECT `ne_list`.`stud_id`, `student`.`prn`,`student`.`name`, `ne_list`.`reason` FROM `ne_list`,`student`,`ses_conf` WHERE `ne_list`.`stud_id` = `student`.`id` AND `ses_conf`.`id` = '1' AND `ses_conf`.`current_session` = `ne_list`.`sesn_id` AND `ne_list`.`exam_id` = '$exam' AND `ne_list`.`course_id`= '$course' ";
		if ($res = mysqli_query($dbcon,$query)) {
			if(mysqli_num_rows($res) > 0)
			{
				$n = 1 ;
?>
	<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
        <thead>
            <tr>
				<th>SR No</th>
				<th>PRN</th>
				<th>Name</th>
				
				<th>Remark</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
				<th>SR No</th>
				<th>PRN</th>
				<th>Name</th>
				
				<th>Remark</th>
            </tr>
        </tfoot>
        <tbody>
<?php
		while ($row = mysqli_fetch_assoc($res)) {
?>
		<tr>
			<td><?php echo $n; ?></td>
			<td><?php echo $row['prn']; ?></td>
			<td><?php echo $row['name']; ?></td>
			<td><?php echo $row['reason']; ?></td>
		</tr>
<?php
			$n++;
		}
?>
    	</tbody>
    </table>
<?php
			}
			else
			{
				echo "<h2>NO Not Elligible students for this course</h2>";
			}
?>
	<div class="row clearfix">
		<div class="col-sm-4">
			<input type="button" name="edit" value="EDIT" onclick="show_list()" class="btn bg-teal waves-effect"/> 
		</div>
		<div class="col-sm-4">
			<input type="submit" id="conf_btn" name="lock_ne" onclick="lock()" value="LOCK" class="btn bg-teal waves-effect"/> 
		</div>
	</div>
<?php
		}
	}
?>