<?php
	$query = "SELECT `id`, `department_name` FROM `department` WHERE 1";
	if($res = mysqli_query($dbcon,$query))
	{
		if(mysqli_num_rows($res) > 0)
		{
?>
							<div class="row clearfix">
								<div class="col-sm-2">
									<div class="form-group">
										<div>
											<label>Department : </label> 
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<select class="form-control show-tick"  data-live-search="true" id="department" name="department" onchange="show_course()"  >
										<option value="">---SELECT DEPARTMENT---</option>
<?php
			while($row = mysqli_fetch_assoc($res))
			{
?>
										<option value="<?php echo $row['id']; ?>"><?php echo $row['department_name']; ?></option>
<?php
			}
?>
									</select>
								</div>
							</div>

<?php
		}
		else
		{
			echo "NO Department entry found!! Contact admin..";
		}
	}
?>