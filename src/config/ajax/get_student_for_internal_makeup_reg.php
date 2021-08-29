<?php
	session_start();
	require_once "../dbconnect.php";
	require_once "../funlib/login_functions.php";
	//require_once "../funlib/utilities_function.php";
	require_once "../funlib/marks_entry_functions.php";
	if ((isset($_POST['exam_id']) && isset($_POST['course'])) && ( isLogin() != null)) 
	{
		$exam_id = $_POST['exam_id'];
		$course_id = $_POST['course'];
		$sesn_id = get_sesn_id();

		$query = "SELECT `student`.`id`,`student`.`prn`,`student`.`name` FROM `student`,`marks_others` WHERE `marks_others`.`sesn_id` = '$sesn_id' AND `marks_others`.`stud_id` = `student`.`id` AND `marks_others`.`course_id` = '$course_id' AND `marks_others`.`exam_type` = '$exam_id' AND `marks_others`.`ne_flag` = '0' AND `marks_others`.`ab_flag` = '1'";
		
		if($res = mysqli_query($dbcon,$query))
		{
			if(mysqli_num_rows($res) > 0)
			{
?>
	<table class="table table-bordered table-striped table-hover js-basic-example dataTable">
        <thead>
            <tr>
				<th>SR No</th>
				<th>PRN</th>
				<th>Name</th>
				<th>Register</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
				<th>SR No</th>
				<th>PRN</th>
				<th>Name</th>
				<th>Register</th>
            </tr>
        </tfoot>
        <tbody>
<?php
				$i = 1;
				while ($row = mysqli_fetch_assoc($res)) 
				{
?>			<tr>
				<td><?php echo $i++;?></td>
				<td><?php echo $row['prn'];?></td>
				<td><?php echo $row['name'];?></td>
				<td>
					<input type="checkbox" id="<?php echo "cid".$row['id'];?>" value="<?php echo $row['id'];?>" name="student_list[]" class="chk-col-teal" />
                    <label for="<?php echo "cid".$row['id'];?>"></label>
                </td>
			</tr>
<?php
					
				}
?>
        </tbody>
    </table>
    <div class="row clearfix">
		<div class="col-sm-4">
			<input type="submit" name="register_for_makeup" value="SAVE" class="btn bg-teal waves-effect"/> 
		</div>
		<div class="col-sm-4">
			<input type="button" id="conf_btn" name="finalize makeup" onclick="finalize()" value="FINALIZE" class="btn bg-teal waves-effect"/> 
		</div>
	</div>
<?php
			}
			else
			{
				echo "No Students for makup registration under current selection!";
			}

		}
		else
		{
			echo " Failed !! :( ";
		}

	}
?>