<?php
    if(isset($_POST['add_case']))
    {
        //print_r($_POST);
        $sesn_id = $_POST['sesn_id'];
        $stud_id = $_POST['stud_id'];
        $exam_type = $_POST['exam_type'];
        $course_id_list = $_POST['sublist'];
        if(sizeof($course_id_list) > 0)
        {
            $query = "INSERT INTO `copy_case` (`sesn_id`, `stud_id`, `course_id`, `exam_type`, `punishment_flag`, `punish_id`) VALUES ";
            $setarray = array();
            foreach ($course_id_list as $course_id) {
                $setarray[] ="('$sesn_id', '$stud_id', '$course_id', '$exam_type', '0', '0')";
            }
            $query .= implode(",", $setarray);
            // echo $query;
            if($res = mysqli_query($dbcon,$query))
            {
?>
<script type="text/javascript">       
    swal("Done!", "Copy Case Added.!", "success");
</script>
<?php
                unset($_POST);
                header("Location:add_copy_case.php");
            }
            else
            {
?>
<script type="text/javascript">       
    swal("Failed..!", "Unable to add copy case.", "error");
</script>
<?php
            }
        }
        else
        {
?>
<script type="text/javascript">       
    swal("Oops!", "No cource selected....,", "info");
</script>
<?php
        }

    }
?>
<section class="content">
	<div class="container-fluid">
		<div class="row clearfix">	
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
							ADD COPY CASE 
						</h2>                            
                    </div>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <div>
                                        <label>Academic Session : </label> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <select class="form-control show-tick" data-live-search="true" id="sesn_id" name="sesn_id" required>
                                    <option value="">---SELECT SESSION---</option>
                                    <?php
                                        $session_sel_query = "SELECT `exam_session`.`session`, `academic_year`.`academic_year`,`sessions`.`sesn_id` FROM `exam_session`,`sessions`,`academic_year` WHERE `sessions`.`end_flag` = '0' AND `sessions`.`academic_yr` = `academic_year`.`ac_id` AND `sessions`.`exam_sesn` = `exam_session`.`id` ";
                                        if ($res = mysqli_query($dbcon,$session_sel_query)) {
                                            if (mysqli_num_rows($res) > 0) {
                                                while ($row = mysqli_fetch_assoc($res)) {
                                    ?>
                                    <option value="<?php echo $row['sesn_id']; ?>"><?php echo $row['session']." : ".$row['academic_year'];  ?></option>
                                    <?php               
                                                }
                                            }
                                        }           
                                    ?>
                                </select>
                            </div>
                        </div>
                    	<div class="row clearfix">
                            <div class="col-sm-2 col-md-2">
                                <div class="form-group">
                                    <div>
                                        <label>PRN :</label> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="form-line">
                                        <input class="form-control" onkeypress='return (((event.charCode >= 48 && event.charCode <= 57)) && this.value.length < 7  || event.keyCode == 8 || event.keyCode == 46 )' type="text" id="stud_prn" placeholder="Enter the PRN of student" pattern="^\d{7}$" size = '7' />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <button class="btn btn-primary" onclick="fetch()">Fetch</button>
                            </div>
                        </div>
                        <div class="clearfix">
                            <div id="stud_container"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    function fetch()
    {
        var prn = document.getElementById('stud_prn').value;
        var sesn_id = document.getElementById('sesn_id').value;
        if(sesn_id)
        {
            if(prn)
            {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById('stud_container').innerHTML = this.responseText;
                        
                    }
                };
                xhttp.open("POST", "../config/ajax/fetch_student_cps.php", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("prn="+prn+"&sesn_id="+sesn_id);
            }
            else
            {
                alert("Enter the prn ");
            }
        }
        else
        {
            alert("Select academic session");
        }
    }
</script>
<script type="text/javascript">
    function check_course_sel()
    {
        checked = $("input[type=checkbox]:checked").length;

        if(!checked) {
            alert("You must check at least one course.");
            return false;
        } 
        return true;
    }

</script>

<!-- <div class="col-md-3">
                            <select name="multiple[]" data-live-search="true" data-selected-text-format="count > 2" class="form-control show-tick" multiple>
                                <option>Mustard</option>
                                <option>Ketchup</option>
                                <option>Relish</option>
                            </select>
                        </div> -->