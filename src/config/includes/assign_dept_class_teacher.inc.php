<div class="row clearfix">
	<div class="col-sm-2">
		<div class="form-group">
			<div>
				<label>Department : </label> 
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<select id="department" name="department" data-live-search="true" onchange="get_staff()"  required>
			<option value="">--SELECT DEPARTMENT--</option>
				<?php
						$query = "SELECT `id`, `department_name` FROM `department`";
						if ($res = mysqli_query($dbcon,$query)) {
						while ($row = mysqli_fetch_assoc($res)) {
				?>
			<option value="<?php echo $row['id']; ?>"><?php echo $row['department_name']; ?></option>
				<?php
							}
						}
				?>
		</select>
	</div>										
</div>

<div id="inner_form_container">
</div>