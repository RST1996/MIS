
								<div class="row clearfix">
										<div class="col-sm-2">
											<div class="form-group">
												<div>
													<label>Department : </label> 
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<select id="department" name="department" data-live-search="true" required>
													<option value="">--SELECT Department--</option>
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
									<div class="row clearfix">
										<div class="col-sm-2">
											<div class="form-group">
												<div>
													<label>Teacher : </label> 
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<select id="teacher" name="teacher" data-live-search="true" required>
												<option value="">--SELECT TEACHER--</option>
											<?php
												$query = "SELECT `staff`.`id`,`staff`.`name` FROM `staff`,`staff_role` WHERE `staff`.`department` = '7' AND `staff_role`.`staff_id` = `staff`.`id` AND `staff_role`.`staff_type_id` = '7'";
												if ($res = mysqli_query($dbcon,$query)) {
													while ($row = mysqli_fetch_assoc($res)) {
											?>
												<option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
											<?php
													}
												}
											?>
											</select>
										</div>
										
									</div>
									<div class="row clearfix">
										<div class="col-sm-6">
											<div class="form-group">
												<div align="center">
													<input class="btn btn-primary waves-effect" type="submit" name="assign_class_teacher">
												</div>
											</div>
										</div>
									</div>

