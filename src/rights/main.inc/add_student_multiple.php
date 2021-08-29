<?php
	if (isset($_POST['submit_add_multiple'])) {
		if($_FILES['file']['type'] == "application/vnd.ms-excel" )
		{
			ini_set('auto_detect_line_endings',TRUE);
			$file = $_FILES['file']['tmp_name'];
			$handle = fopen($file, "r");
			$c = 0;
			$s = 0;
			$error_array = array();
			while(($filesop = fgetcsv($handle, 2000, ",")) !== false)
			{
				//print_r($filesop);
				$prn = $filesop[0];
				$name = $filesop[1];
				$father_name = $filesop[2];
				$date = $filesop[3];
				$caste = $filesop[4];
				$category = $filesop[5];
				$religion = $filesop[6];
				$nationality = $filesop[7];
				$ph_type = $filesop[8];
				$email = $filesop[9];
				$landline_no = $filesop[10];
				$mobile_no = $filesop[11];
				$city = $filesop[12];
				$local_address = $filesop[13];
				$permanent_address = $filesop[14];
				$department = $filesop[15];
				$current_semester = $filesop[16];
				$gender = $filesop[17];
				$add_res = add_student($prn,$name,$father_name,$date,$caste,$category,$religion,$nationality,$ph_type,$email,$landline_no,$mobile_no,$city,$local_address,$permanent_address,$department,$current_semester,$gender);
				if ($add_res == "success") {
					$s = $s + 1;
				} else {
					$a = "@ Row no ".($c + 1)." :- ".$add_res;
					array_push($error_array, $a);
				}
				

				$c = $c + 1;
			}
			if($c == $s)
			{
				?>
			<script type="text/javascript">
				swal("Good Job!", "Successfully Registered", "success")
			</script>
			<?php
				unset($_FILES);
				unset($_POST);
				
				header( "refresh:1; url=add_student.php" );
			}
			else
			{
				unset($_FILES);
				unset($_POST);
				//$alert_str = "Out of ".$c." records ".$s." added successfully!!";
				/*echo $alert_str;

				
				foreach ($error_array as $err) {
					echo ($err);
				}*/
				

			}
			ini_set('auto_detect_line_endings',FALSE);

		}
		else
		{
?>
	<script type="text/javascript">
		swal("Failed!", "<?php echo $add_course ?>", "error")
	</script>
<?php
		}
		
		//print_r($_FILES);
		/*$handle = fopen($file, “r”);
		$c = 0;
		while(($filesop = fgetcsv($handle, 2000, “,”)) !== false)
		{
			$name = $filesop[0];
			$project = $filesop[1];
			
			[type] => application/vnd.ms-excel


			$c = $c + 1;
		}*/	
	}
?>
                            <div class="row clearfix">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="card">
									
										<div class="header">
											<h2>
												Add Multiple Students
											 </h2>
										</div>
										<div class="body">
											<form name="miltiple_add_student" method="post" enctype="multipart/form-data">
												<div class="row clearfix">
										
													<div class="col-md-4" align="center">
														<div class="form-group">
															<input type="file" name="file" class="btn btn-primary waves-effect" required/>
														</div>
													</div>
													<div class="col-md-2" align="center">
														<div class="form-group">
															<input type="submit" name="submit_add_multiple" class="btn btn-primary waves-effect" value="Add" />
														</div>
													</div>
												</div>
												
									
									
											 </form>
											<div class="row clearfix">
													<div class="col-md-4" align="center">
														<div class="form-group">
															<p>Download the required format</p>
														</div>
													</div>
													<div class="col-md-2" align="center">
														<div class="form-group">
														<form method="get" action="../format.csv">
															<button type="submit" class="btn btn-primary waves-effect">Download!</button>
														</form>
														</div>
													</div>
												</div>		
										</div>
									</div>
								</div>
							</div>
                        </div>
                    </div>
                </div>
            </div>
			 
            
        </div>
    </section>

   