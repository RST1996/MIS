<?php
    //print_r($_POST);
    if(isset($_POST['register_for_makeup']))
    {
        $sesn_id = get_sesn_id();
        $course_id = $_POST['course'];
        $exam_id = $_POST['exam_id'];
        if(isset($_POST['student_list']) && sizeof($_POST['student_list'] > 0))
        {
            $student_list = $_POST['student_list'];
            $result = internal_makeup_register($sesn_id,$student_list,$course_id,$exam_id);
            if($result == "success")
            {
?>
    <script type="text/javascript">
        swal("Good Job","Successfully  registered","success");
    </script>
<?php
            }
            else
            {
?>
    <script type="text/javascript">
        swal("Opps...","Failed due to some error..","error");
    </script>
<?php
            }
        }
        else
        {
?>
    <script type="text/javascript">
        swal("Alert","No student registered for makeup","info");
    </script>
<?php        }
    }
    $dept = get_hod_department();
    if($dept == 7)
    {
        include "../config/includes/main/makeup_reg_fy.php";
    }
    else
    {
        include "../config/includes/main/makeup_reg_others.php";
    }
?>