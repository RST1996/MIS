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
                                <select class="form-control show-tick" data-live-search="true" id="sesn_id" name="sesn_id" onchange="load_cases()" required>
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
                        <div id="case_container"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    function load_cases()
    {
        var sesn_id = document.getElementById('sesn_id').value;
        document.getElementById('case_container').innerHTML = "";
        if(sesn_id)
        {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById('case_container').innerHTML = this.responseText;
                    
                }
            };
            xhttp.open("POST", "../config/ajax/fetch_cps.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("sesn_id="+sesn_id);
        }
    }
</script>
<script type="text/javascript">
    function update_punish(stud,course,exam,sesn)
    {
        if(document.getElementById('action_'+stud+course))
        {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    if(this.responseText != "No punishment found")
                    {
                        document.getElementById('punish_'+stud+course).innerHTML = this.responseText;    
                        document.getElementById('action_'+stud+course).innerHTML = "<button id=\"savbtn_"+stud+course+"\" class=\"btn btn-primary\" onclick=\"save_punish('"+stud+"','"+course+"')\">Save Punishment</button>";
                    }
                    else
                    {
                        alert("No punishment found..Plzz contact admin if the problem persists");
                        window.location.href="../";    
                    }
                    
                }
            };
            xhttp.open("POST", "../config/ajax/update_punish.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("sesn_id="+sesn+"&stud_id="+stud+"&course_id="+course+"&exam_type="+exam);
        }
        else
        {
            console.log("Plzz.. not available plzz do not play here...!!");
        }
    }
</script>
<script type="text/javascript">
    function save_punish(stud,course)
    {
        if(document.getElementById('punish_'+stud+course))
        {
            var stud_id =document.getElementById("stud_id_"+stud+course).value;
            var sesn_id =document.getElementById("sesn_id_"+stud+course).value ;
            var exam_type = document.getElementById( "exam_type_"+stud+course).value;
            var course_id = document.getElementById("course_id_"+stud+course).value;
            var pid = document.getElementById("pid_"+stud+course).value;
            if(pid)
            {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        if(this.responseText == "success")
                        {
                            swal("Done.!","Punishment Assigned","success");
                        }                        
                        else
                        {
                            swal("Failure.!","Failed to assign the punishment..","error");
                        }
                        load_cases();
                    }
                };
                xhttp.open("POST", "../config/ajax/save_punishment.php", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("sesn_id="+sesn_id+"&stud_id="+stud_id+"&course_id="+course_id+"&exam_type="+exam_type+"&pid="+pid);
            }
            else
            {
                alert("Select valid a punishment..! ");
            }
        }
    }

</script>


