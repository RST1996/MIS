<section class="content">
    <div class="container-fluid">
	   <div class="row clearfix">	
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
						Makeup Registration for Internal exams
						</h2>                            
                    </div>
                    <div class="body">
						<form method = "POST" action = "make_up_reg.php">
                            <fieldset>
<?php
    //var_dump($activity);
    if (sizeof($activity) > 1)
    {
?>
                                <div class="row clearfix">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <div>
                                                <label>Activity : </label> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <select id="exam_id" name="exam_id" onchange="show_sem()" required>
                                                <option> -- SELECT ACTIVITY -- </option>
                                        <?php
                                            for ($i=0; $i < sizeof($activity) ; $i++) { 
                                                $query = "SELECT `name`, `exam_id` FROM `activities` WHERE `id`='$activity[$i]'";
                                                if ($res = mysqli_query($dbcon,$query)) {
                                                    while ($row = mysqli_fetch_assoc($res)) {
                                            ?>
                                                    <option value="<?php echo $row['exam_id']; ?>"><?php echo $row['name']; ?></option>
                                            <?php
                                                    }
                                                }
                                            }
                                        ?>
                                        </select>
                                        
                                    </div>      
                                </div>
                                <div id="sem_from_container"></div>
<?php    
    }
    else
    {
        $query = "SELECT `name`, `exam_id` FROM `activities` WHERE `id`='$activity[0]'";
        if ($res = mysqli_query($dbcon,$query)) {
            $row = mysqli_fetch_assoc($res);
            $exam_id = $row['exam_id'];
            $act_name = $row['name'];
        }
?>
                                <div class="row clearfix">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <div>
                                                <label>Activity : </label> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <select id="exam_id" name="exam_id" required readonly>
                                                <option value="<?php echo $exam_id; ?>"><?php echo $act_name; ?></option>
                                        </select>
                                    </div>      
                                </div>
                                <div id="sem_from_container">
<?php
        $sesn_id = get_sesn_id();
        switch ($exam_id) {
            case '1':
                $query = "SELECT DISTINCT `student`.`current_semester` FROM `student`,`exam_registration`,`th_mks_scheme` WHERE `exam_registration`.`sesn_id` = '$sesn_id' AND `exam_registration`.`stud_id` = `student`.`id` AND `exam_registration`.`regular_flag` = '1' AND `exam_registration`.`conform_status` = '1' AND `th_mks_scheme`.`sub_id` = `exam_registration`.`course_id` AND `th_mks_scheme`.`ise1` > 0 AND `student`.`current_semester` > 2 AND `student`.`department` = '$dept'";
                break;
            case '2':
                $query = "SELECT DISTINCT `student`.`current_semester` FROM `student`,`exam_registration`,`th_mks_scheme` WHERE `exam_registration`.`sesn_id` = '$sesn_id' AND `exam_registration`.`stud_id` = `student`.`id` AND `exam_registration`.`regular_flag` = '1' AND `exam_registration`.`conform_status` = '1' AND `th_mks_scheme`.`sub_id` = `exam_registration`.`course_id` AND `th_mks_scheme`.`ise2` > 0 AND `student`.`current_semester` > 2 AND `student`.`department` = '$dept'";
                break;
            case '3':
                $query = "SELECT DISTINCT `student`.`current_semester` FROM `student`,`exam_registration`,`th_mks_scheme` WHERE `exam_registration`.`sesn_id` = '$sesn_id' AND `exam_registration`.`stud_id` = `student`.`id` AND `exam_registration`.`regular_flag` = '1' AND `exam_registration`.`conform_status` = '1' AND `th_mks_scheme`.`sub_id` = `exam_registration`.`course_id` AND `th_mks_scheme`.`isa` > 0 AND `student`.`current_semester` > 2 AND `student`.`department` = '$dept'";
                break;
            case '4':
                $query = "SELECT DISTINCT `student`.`current_semester` FROM `student`,`exam_registration`,`pr_mks_scheme` WHERE `exam_registration`.`sesn_id` = '$sesn_id' AND `exam_registration`.`stud_id` = `student`.`id` AND `exam_registration`.`regular_flag` = '1' AND `exam_registration`.`conform_status` = '1' AND `pr_mks_scheme`.`sub_id` = `exam_registration`.`course_id` AND `pr_mks_scheme`.`ica` > 0 AND `student`.`current_semester` > 2 AND `student`.`department` = '$dept'";
                break;
            
            default:
                echo "Invalid Results.!!";
                break;
        }
        if($res = mysqli_query($dbcon,$query))
        {
            if(mysqli_num_rows($res) > 0)
            {
?>
    <div class="row clearfix">
        <div class="col-sm-3">
            <div class="form-group">
                <div>
                    <label>SEMESTER : </label> 
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <select id="sem" name="sem" onchange="show_course()" required>
                    <option> -- SELECT SEMESTER -- </option>
<?php
                while ($row = mysqli_fetch_assoc($res)) 
                {
                    $sem = $row['current_semester'];
                    $roman_sem = romanic_number($sem);
?>
                    <option value="<?php echo $sem; ?>"><?php echo "SEM ".$roman_sem; ?></option>
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
                echo "No Data found";
            }
        }
        else
        {
            echo "Failed to fetch data ... :(";
        }
?>
                                </div>
<?php
    }
?>
                                <div id="course_from_container"></div>    
                                <div id="students_from_container"></div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    function show_sem()
    {
        var exam_id = document.getElementById('exam_id').value;
        if(exam_id != null)
        {
            $.blockUI({ message: '<img src="../assets/images/loader.gif" /> &nbsp;&nbsp;&nbsp; Just a moment...' });
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) 
                {
                    document.getElementById('sem_from_container').innerHTML = this.responseText; 
                    document.getElementById('course_from_container').innerHTML = "";
                    document.getElementById('students_from_container').innerHTML = "";
                    $.unblockUI();
                }
            };
            xhttp.open("POST", "../config/ajax/get_sem_for_internal_makeup_reg.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("exam_id="+exam_id);
        }
    }
</script>
<script type="text/javascript">
    function show_course()
    {
        var exam_id = document.getElementById('exam_id').value;
        var sem = document.getElementById('sem').value;
        if(exam_id!= null && sem != null)
        {
            $.blockUI({ message: '<img src="../assets/images/loader.gif" /> &nbsp;&nbsp;&nbsp; Just a moment...' });
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) 
                {
                    document.getElementById('course_from_container').innerHTML = this.responseText;;
                    document.getElementById('students_from_container').innerHTML = "";
                    $.unblockUI();
                }
            };
            xhttp.open("POST", "../config/ajax/get_course_for_internal_makeup_reg.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("exam_id="+exam_id+"&sem="+sem);
        }
    }
</script>
<script type="text/javascript">
    function show_list()
    {
        var exam_id = document.getElementById('exam_id').value;
        var course = document.getElementById('course').value;
        if(exam_id != null && course != null)
        {
            $.blockUI({ message: '<img src="../assets/images/loader.gif" /> &nbsp;&nbsp;&nbsp; Just a moment...' });
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) 
                {
                    document.getElementById('students_from_container').innerHTML = this.responseText;
                    $.unblockUI();
                }
            };
            xhttp.open("POST", "../config/ajax/get_student_for_internal_makeup_reg.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("exam_id="+exam_id+"&course="+course);
        }
    }
</script>