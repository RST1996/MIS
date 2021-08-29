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
						<form method = "POST" action = "marks_entry.php">
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
                                        <select id="exam_id" name="exam_id" onchange="show_course()" required>
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
                                <div id="course_from_container"></div>
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
                                <div id="course_from_container">
<?php

        $sesn_id = get_sesn_id();
        switch ($exam_id) {
            case '1':
                $query = "SELECT DISTINCT `course`.`id`,`course`.`course_code`,`course`.`course_name` FROM `course`,`student`,`exam_registration`,`th_mks_scheme`,`course_assign` WHERE `exam_registration`.`sesn_id` = '$sesn_id' AND  `exam_registration`.`course_id` = `course`.`id` AND `exam_registration`.`regular_flag` = '1' AND `exam_registration`.`conform_status` = '1' AND `th_mks_scheme`.`sub_id` = `course`.`id` AND `th_mks_scheme`.`ise1` > 0 AND`course_assign`.`sub_id`= `course`.`id` AND(`course_assign`.`sem`='1' OR `course_assign`.`sem` = '2')";
                break;
            case '2':
                $query = "SELECT DISTINCT `course`.`id`,`course`.`course_code`,`course`.`course_name` FROM `course`,`student`,`exam_registration`,`th_mks_scheme` WHERE `exam_registration`.`sesn_id` = '$sesn_id'  AND `exam_registration`.`course_id` = `course`.`id` AND `exam_registration`.`regular_flag` = '1' AND `exam_registration`.`conform_status` = '1' AND `th_mks_scheme`.`sub_id` = `course`.`id` AND `th_mks_scheme`.`ise2` > 0 AND`course_assign`.`sub_id`= `course`.`id` AND(`course_assign`.`sem`='1' OR `course_assign`.`sem` = '2')";
                break;
            case '3':
                $query = "SELECT DISTINCT `course`.`id`,`course`.`course_code`,`course`.`course_name` FROM `course`,`student`,`exam_registration`,`th_mks_scheme` WHERE `exam_registration`.`sesn_id` = '$sesn_id' AND `exam_registration`.`course_id` = `course`.`id` AND `exam_registration`.`regular_flag` = '1' AND `exam_registration`.`conform_status` = '1' AND `th_mks_scheme`.`sub_id` = `course`.`id` AND `th_mks_scheme`.`isa` > 0 AND`course_assign`.`sub_id`= `course`.`id` AND(`course_assign`.`sem`='1' OR `course_assign`.`sem` = '2')";
                break;
            case '4':
                $query = "SELECT DISTINCT `course`.`id`,`course`.`course_code`,`course`.`course_name` FROM `course`,`student`,`exam_registration`,`pr_mks_scheme` WHERE `exam_registration`.`sesn_id` = '$sesn_id' AND  `exam_registration`.`course_id` = `course`.`id` AND `exam_registration`.`regular_flag` = '1' AND `exam_registration`.`conform_status` = '1' AND `pr_mks_scheme`.`sub_id` = `course`.`id` AND `pr_mks_scheme`.`ica` > 0 AND`course_assign`.`sub_id`= `course`.`id` AND(`course_assign`.`sem`='1' OR `course_assign`.`sem` = '2')";
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
                                                    <label>Course: </label> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <select id="course" name="course" onchange="show_list()" required>
                                                <option> -- SELECT Course -- </option>
<?php
                while ($row = mysqli_fetch_assoc($res)) 
                {
                    $id = $row['id'];
                    $code = $row['course_code'];
                    $name = $row['course_name'];
                    //$roman_sem = romanic_number($sem);
?>
                                                <option value="<?php echo $id; ?>"><?php echo $code." :".$name; ?></option>
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
							<div id="students_from_container">
							</div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    function show_course()
    {
        var exam_id = document.getElementById('exam_id').value;
        if(exam_id != null)
        {
            $.blockUI({ message: '<img src="../assets/images/loader.gif" /> &nbsp;&nbsp;&nbsp; Just a moment...' });
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) 
                {
                    document.getElementById('course_from_container').innerHTML = this.responseText; 
                    document.getElementById('students_from_container').innerHTML = "";
                    $.unblockUI();
                }
            };
            xhttp.open("POST", "../config/ajax/get_course_for_internal_makeup_reg_fy.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("exam_id="+exam_id);
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